<?php

/**
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace App\Library\PropelConnector\Propel\Generator\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Propel\Generator\Manager\SqlManager;

/**
 * @author William Durand <william.durand1@gmail.com>
 */
class SqlBuildCommand
        extends \Propel\Generator\Command\SqlBuildCommand
{

    const DEFAULT_PLATFORM = 'MysqlPlatform';
    const DEFAULT_MYSQL_ENGINE = 'InnoDB';
    const DEFAULT_DATABASE_ENCODING = 'UTF-8';
    const DEFAULT_OUTPUT_DIRECTORY = '/../../../../../../config/db/sql';
    const DEFAULT_INPUT_DIRECTORY = '/../../../../../../config/db';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
                ->addOption('platform', null, InputOption::VALUE_REQUIRED, 'The platform', self::DEFAULT_PLATFORM)
                ->addOption('recursive', null, InputOption::VALUE_NONE, 'Search for schema.xml inside the input directory')
                ->addOption('input-dir', null, InputOption::VALUE_REQUIRED, 'The input directory', __DIR__ . self::DEFAULT_INPUT_DIRECTORY)
                ->addOption('mysql-engine', null, InputOption::VALUE_REQUIRED, 'MySQL engine (MyISAM, InnoDB, ...)', self::DEFAULT_MYSQL_ENGINE)
                ->addOption('output-dir', null, InputOption::VALUE_REQUIRED, 'The output directory', __DIR__ . self::DEFAULT_OUTPUT_DIRECTORY)
                ->addOption('validate', null, InputOption::VALUE_NONE, '')
                ->addOption('connection', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED, 'Connection to use', array())
                ->addOption('schema-name', null, InputOption::VALUE_REQUIRED, 'The schema name for RDBMS supporting them', '')
                ->addOption('encoding', null, InputOption::VALUE_REQUIRED, 'The encoding to use for the database', self::DEFAULT_DATABASE_ENCODING)
                ->addOption('table-prefix', null, InputOption::VALUE_REQUIRED, 'Add a prefix to all the table names in the database', '')
                ->setName('propel:sql:build')
                ->setAliases(array('sql'))
                ->setDescription('Build SQL files')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $generatorConfig = $this->getGeneratorConfig(array(
            'propel.platform.class' => $input->getOption('platform'),
            'propel.database.schema' => $input->getOption('schema-name'),
            'propel.database.encoding' => $input->getOption('encoding'),
            'propel.tablePrefix' => $input->getOption('table-prefix'),
            'propel.useLeftJoinsInDoJoinMethods' => true,
            // MySQL specific
            'propel.mysql.tableType' => $input->getOption('mysql-engine'),
            'propel.mysql.tableEngineKeyword' => 'ENGINE',
                ), $input);

        $this->createDirectory($input->getOption('output-dir'));

        $manager = new SqlManager();

        $connections = array();
        $optionConnections = $input->getOption('connection');
        if (!$optionConnections) {
            $connections = $generatorConfig->getBuildConnections($input->getOption('input-dir'));
        } else {
            foreach ($optionConnections as $connection) {
                list($name, $dsn, $infos) = $this->parseConnection($connection);
                $connections[$name] = array_merge(array('dsn' => $dsn), $infos);
            }
        }
        $manager->setConnections($connections);

        $manager->setValidate($input->getOption('validate'));
        $manager->setGeneratorConfig($generatorConfig);
        $manager->setSchemas($this->getSchemas($input->getOption('input-dir'), $input->getOption('recursive')));
        $manager->setLoggerClosure(function ($message) use ($input, $output) {
            if ($input->getOption('verbose')) {
                $output->writeln($message);
            }
        });
        $manager->setWorkingDirectory($input->getOption('output-dir'));

        if ($manager->existSqlMap()) {
            $output->writeln("<info>sqldb.map won't be saved because it already exists. Remove it to generate a new map.</info>");
        }

        $manager->buildSql();
    }

}
