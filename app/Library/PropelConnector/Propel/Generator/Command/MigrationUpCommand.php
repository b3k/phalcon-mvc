<?php

/**
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace App\Library\PropelConnector\Propel\Generator\Command;

use Propel\Runtime\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Propel\Generator\Manager\MigrationManager;
use Propel\Generator\Util\SqlParser;
use Propel\Generator\Config\GeneratorConfig;
use App\Tasks\Command\AbstractCommand;

/**
 * @author William Durand <william.durand1@gmail.com>
 */
class MigrationUpCommand extends \Propel\Generator\Command\MigrationUpCommand
{

    const DEFAULT_OUTPUT_DIRECTORY = '/../../../../../../config/db/migrations';
    const DEFAULT_INPUT_DIRECTORY = '/../../../../../../config/db';
    const DEFAULT_MIGRATION_TABLE = 'propel_migration';
    const DEFAULT_PLATFORM = 'MysqlPlatform';

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
                ->addOption('output-dir', null, InputOption::VALUE_REQUIRED, 'The output directory', __DIR__ . self::DEFAULT_OUTPUT_DIRECTORY)
                ->addOption('migration-table', null, InputOption::VALUE_REQUIRED, 'Migration table name', self::DEFAULT_MIGRATION_TABLE)
                ->addOption('connection', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED, 'Connection to use', array())
                ->setName('propel:migration:up')
                ->setAliases(array('up'))
                ->setDescription('Execute migrations up')
        ;
    }

    /**
     * Returns a new `GeneratorConfig` object with your `$properties` merged with
     * the build.properties in the `input-dir` folder.
     *
     * @param array $properties
     * @param       $input
     *
     * @return GeneratorConfig
     */
    protected function getGeneratorConfig(array $properties, InputInterface $input = null)
    {
        $options = $properties;
        if ($input && $input->hasOption('input-dir')) {
            $options = array_merge(
                    $properties, $this->getBuildProperties(dirname($input->getOption('input-dir')) . DIRECTORY_SEPARATOR . 'environment' . DIRECTORY_SEPARATOR . $input->getOption('env') . DIRECTORY_SEPARATOR . 'propel' . DIRECTORY_SEPARATOR . 'build.properties')
            );
        }

        return new GeneratorConfig($options);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $generatorConfig = $this->getGeneratorConfig(array(
            'propel.platform.class' => $input->getOption('platform')
                ), $input);

        $this->createDirectory($input->getOption('output-dir'));

        $manager = new MigrationManager();
        $manager->setGeneratorConfig($generatorConfig);

        $connections = array();
        $optionConnections = $input->getOption('connection');
        if (!$optionConnections) {
            $connections = $generatorConfig->getBuildConnections(dirname($input->getOption('input-dir')) . DIRECTORY_SEPARATOR . 'environment' . DIRECTORY_SEPARATOR . $input->getOption('env') . DIRECTORY_SEPARATOR . 'propel');
        } else {
            foreach ($optionConnections as $connection) {
                list($name, $dsn, $infos) = $this->parseConnection($connection);
                $connections[$name] = array_merge(array('dsn' => $dsn), $infos);
            }
        }

        $manager->setConnections($connections);
        $manager->setMigrationTable($input->getOption('migration-table'));
        $manager->setWorkingDirectory($input->getOption('output-dir'));

        if (!$nextMigrationTimestamp = $manager->getFirstUpMigrationTimestamp()) {
            $output->writeln('All migrations were already executed - nothing to migrate.');

            return false;
        }
        $output->writeln(sprintf(
                        'Executing migration %s up', $manager->getMigrationClassName($nextMigrationTimestamp)
        ));

        $migration = $manager->getMigrationObject($nextMigrationTimestamp);
        if (false === $migration->preUp($manager)) {
            $output->writeln('<error>preUp() returned false. Aborting migration.</error>');

            return false;
        }

        foreach ($migration->getUpSQL() as $datasource => $sql) {
            $connection = $manager->getConnection($datasource);

            if ($input->getOption('verbose')) {
                $output->writeln(sprintf(
                                'Connecting to database "%s" using DSN "%s"', $datasource, $connection['dsn']
                ));
            }

            $conn = $manager->getAdapterConnection($datasource);
            $res = 0;
            $statements = SqlParser::parseString($sql);
            foreach ($statements as $statement) {
                try {
                    if ($input->getOption('verbose')) {
                        $output->writeln(sprintf('Executing statement "%s"', $statement));
                    }

                    $stmt = $conn->prepare($statement);
                    $stmt->execute();
                    $res++;
                } catch (\PDOException $e) {
                    throw new RuntimeException(sprintf('<error>Failed to execute SQL "%s". Aborting migration.</error>', $statement), 0, $e);
                }
            }
            if (!$res) {
                $output->writeln('No statement was executed. The version was not updated.');
                $output->writeln(sprintf(
                                'Please review the code in "%s"', $manager->getMigrationDir() . DIRECTORY_SEPARATOR . $manager->getMigrationClassName($nextMigrationTimestamp)
                ));
                $output->writeln('<error>Migration aborted</error>', Project::MSG_ERR);

                return false;
            }
            $output->writeln(sprintf(
                            '%d of %d SQL statements executed successfully on datasource "%s"', $res, count($statements), $datasource
            ));
            $manager->updateLatestMigrationTimestamp($datasource, $nextMigrationTimestamp);
            if ($input->getOption('verbose')) {
                $output->writeln(sprintf(
                                'Updated latest migration date to %d for datasource "%s"', $nextMigrationTimestamp, $datasource
                ));
            }
        }

        $migration->postUp($manager);

        if ($timestamps = $manager->getValidMigrationTimestamps()) {
            $output->writeln(sprintf(
                            'Migration complete. %d migrations left to execute.', count($timestamps)
            ));
        } else {
            $output->writeln('Migration complete. No further migration to execute.');
        }
    }

}
