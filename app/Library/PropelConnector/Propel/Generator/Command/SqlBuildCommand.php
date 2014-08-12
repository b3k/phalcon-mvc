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
use App\Library\PropelConnector\Propel\Generator\Config\GeneratorConfig;
use Symfony\Component\Console\Output\OutputInterface;
use Propel\Generator\Manager\SqlManager;
use App\Tasks\Command\AbstractCommand;

/**
 * @author William Durand <william.durand1@gmail.com>
 */
class SqlBuildCommand extends \Propel\Generator\Command\SqlBuildCommand
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
                ->addOption('env', null, InputOption::VALUE_REQUIRED, 'Application environment', AbstractCommand::DEFAULT_INPUT_ENV)
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

    protected function getGeneratorConfig(array $properties = null, InputInterface $input = null)
    {
        if (null === $input) {
            return new GeneratorConfig(null, $properties);
        }

        $inputDir = dirname($input->getOption('input-dir')) . DIRECTORY_SEPARATOR . 'environment' . DIRECTORY_SEPARATOR . $input->getOption('env');

        if ($input->hasOption('platform') && (null !== $input->getOption('platform'))) {
            $properties['propel']['generator']['platformClass'] = '\\Propel\\Generator\\Platform\\' . $input->getOption('platform');
        }

        return new GeneratorConfig($inputDir, $properties);
    }

}
