<?php

/**
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace App\Library\PropelConnector\Propel\Generator\Command;

use Propel\Generator\Schema\Dumper\XmlDumper;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Propel\Generator\Manager\ReverseManager;
use App\Tasks\Command\AbstractCommand;

/**
 * @author William Durand <william.durand1@gmail.com>
 */
class DatabaseReverseCommand extends \Propel\Generator\Command\DatabaseReverseCommand
{

    const DEFAULT_OUTPUT_DIRECTORY = '/../../../../../../config/db';
    const DEFAULT_INPUT_DIRECTORY = '/../../../../../../config';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
                ->addOption('env', null, InputOption::VALUE_REQUIRED, 'Application environment', AbstractCommand::DEFAULT_INPUT_ENV)
                ->addOption('output-dir', null, InputOption::VALUE_REQUIRED, 'The output directory', __DIR__ . self::DEFAULT_OUTPUT_DIRECTORY)
                ->addOption('input-dir', null, InputOption::VALUE_REQUIRED, 'The input directory', __DIR__ . self::DEFAULT_INPUT_DIRECTORY)
                ->addOption('database-name', null, InputOption::VALUE_REQUIRED, 'The database name used in the created schema.xml', self::DEFAULT_DATABASE_NAME)
                ->addOption('schema-name', null, InputOption::VALUE_REQUIRED, 'The schema name to generate', self::DEFAULT_SCHEMA_NAME)
                ->addOption('connection', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED, 'Connection to use', array())
                ->setName('propel:database:reverse')
                ->setAliases(array('reverse'))
                ->setDescription('Reverse-engineer a XML schema file based on given database')
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
//    protected function getGeneratorConfig(array $properties, InputInterface $input = null)
//    {
//        $options = $properties;
//        if ($input && $input->hasOption('input-dir')) {
//            $options = array_merge(
//                $properties,
//                $this->getBuildProperties($input->getOption('input-dir') . DIRECTORY_SEPARATOR . 'environment' . DIRECTORY_SEPARATOR . $input->getOption('env') . DIRECTORY_SEPARATOR . 'propel' . DIRECTORY_SEPARATOR . 'build.properties')
//            );
//        }
//
//        return new GeneratorConfig($options);
//    }
    protected function getGeneratorConfig(array $properties = null, InputInterface $input = null)
    {
        if (null === $input) {
            return new GeneratorConfig(null, $properties);
        }

        $inputDir = null;

        if ($input->hasOption('input-dir')) {
            if (!($this instanceof SqlInsertCommand)) {
                $inputDir = $input->getOption('input-dir');
            }
        }

        if ($input->hasOption('platform') && (null !== $input->getOption('platform'))) {
            $properties['propel']['generator']['platformClass'] = '\\Propel\\Generator\\Platform\\' . $input->getOption('platform');
        }

        return new GeneratorConfig($inputDir, $properties);
    }
    
    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $vendor = $input->getArgument('connection');
        $vendor = preg_split('{:}', $vendor);
        $vendor = ucfirst($vendor[0]);

        $generatorConfig = $this->getGeneratorConfig(array(
            'propel.platform.class' => $input->getOption('platform'),
            'propel.reverse.parser.class' => sprintf('\\Propel\\Generator\\Reverse\\%sSchemaParser', $vendor),
                ), $input);

        $this->createDirectory($input->getOption('output-dir'));

        $manager = new ReverseManager(new XmlDumper());
        $manager->setGeneratorConfig($generatorConfig);
        $manager->setLoggerClosure(function ($message) use ($input, $output) {
            if ($input->getOption('verbose')) {
                $output->writeln($message);
            }
        });
        $manager->setWorkingDirectory($input->getOption('output-dir'));

        list(, $dsn, $infos) = $this->parseConnection('connection=' . $input->getArgument('connection'));

        $manager->setConnection(array_merge(array('dsn' => $dsn), $infos));

        $manager->setDatabaseName($input->getOption('database-name'));
        $manager->setSchemaName($input->getOption('schema-name'));

        if (true === $manager->reverse()) {
            $output->writeln('<info>Schema reverse engineering finished.</info>');
        } else {
            $more = $input->getOption('verbose') ? '' : ' You can use the --verbose option to get more information.';

            $output->writeln(sprintf('<error>Schema reverse engineering failed.%s</error>', $more));

            return 1;
        }
    }

}
