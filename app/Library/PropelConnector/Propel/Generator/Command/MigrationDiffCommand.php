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
use App\Tasks\Command\AbstractCommand;

/**
 * @author William Durand <william.durand1@gmail.com>
 */
class MigrationDiffCommand extends \Propel\Generator\Command\MigrationDiffCommand
{

    const DEFAULT_OUTPUT_DIRECTORY = '/../../../../../../config/db/migrations';
    const DEFAULT_INPUT_DIRECTORY = '/../../../../../../config/db';
    const DEFAULT_PLATFORM = 'MysqlPlatform';
    const DEFAULT_MIGRATION_TABLE = 'propel_migration';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
                ->addOption('env', null, InputOption::VALUE_REQUIRED, 'Application environment', AbstractCommand::DEFAULT_INPUT_ENV)
                ->addOption('input-dir', null, InputOption::VALUE_REQUIRED, 'The input directory', __DIR__ . self::DEFAULT_INPUT_DIRECTORY)
                ->addOption('platform', null, InputOption::VALUE_REQUIRED, 'The platform', self::DEFAULT_PLATFORM)
                ->addOption('recursive', null, InputOption::VALUE_NONE, 'Search for schema.xml inside the input directory')
                ->addOption('output-dir', null, InputOption::VALUE_REQUIRED, 'The output directory where the migration files are located', __DIR__ . self::DEFAULT_OUTPUT_DIRECTORY)
                ->addOption('migration-table', null, InputOption::VALUE_REQUIRED, 'Migration table name', self::DEFAULT_MIGRATION_TABLE)
                ->addOption('connection', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED, 'Connection to use. Example: \'bookstore=mysql:host=127.0.0.1;dbname=test;user=root;password=foobar\' where "bookstore" is your propel database name (used in your schema.xml)', array())
                ->addOption('table-renaming', null, InputOption::VALUE_NONE, 'Detect table renaming', null)
                ->addOption('editor', null, InputOption::VALUE_OPTIONAL, 'The text editor to use to open diff files', null)
                ->addOption('skip-removed-table', null, InputOption::VALUE_NONE, 'Option to skip removed table from the migration')
                ->addOption('skip-tables', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL, 'List of excluded tables', array())
                ->addOption('comment', "m", InputOption::VALUE_OPTIONAL, 'A comment for the migration', '')
                ->setName('propel:migration:diff')
                ->setAliases(array('diff'))
                ->setDescription('Generate diff classes')
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
