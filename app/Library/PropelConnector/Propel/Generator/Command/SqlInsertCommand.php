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
use App\Tasks\Command\AbstractCommand;
use App\Library\PropelConnector\Propel\Generator\Config\GeneratorConfig;

/**
 * @author William Durand <william.durand1@gmail.com>
 */
class SqlInsertCommand extends \Propel\Generator\Command\SqlInsertCommand
{

    const DEFAULT_SQL_DIRECTORY = '/../../../../../../config/db/sql';
    const DEFAULT_INPUT_DIRECTORY = '/../../../../../../config/db';
    const DEFAULT_PLATFORM = 'MysqlPlatform';

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
                ->addOption('sql-dir', null, InputOption::VALUE_REQUIRED, 'The SQL files directory', __DIR__ . self::DEFAULT_SQL_DIRECTORY)
                ->addOption('connection', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED, 'Connection to use. Example: \'bookstore=mysql:host=127.0.0.1;dbname=test;user=root;password=foobar\' where "bookstore" is your propel database name (used in your schema.xml)')
                ->setName('propel:sql:insert')
                ->setAliases(array('insert-sql'))
                ->setDescription('Insert SQL statements')
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
