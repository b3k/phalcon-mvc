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
use Propel\Generator\Manager\GraphvizManager;
use Propel\Generator\Config\GeneratorConfig;
use App\Tasks\Command\AbstractCommand;

/**
 * @author William Durand <william.durand1@gmail.com>
 */
class GraphvizGenerateCommand extends \Propel\Generator\Command\GraphvizGenerateCommand
{

    const DEFAULT_OUTPUT_DIRECTORY = '/../../../../../../config/db/graphviz';
    const DEFAULT_INPUT_DIRECTORY = '/../../../../../../config/db';
    const DEFAULT_PLATFORM = 'MysqlPlatform';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
                ->addOption('env', null, InputOption::VALUE_REQUIRED, 'Application environment', AbstractCommand::DEFAULT_INPUT_ENV)
                ->addOption('input-dir', null, InputOption::VALUE_REQUIRED, 'The input directory', __DIR__ . self::DEFAULT_INPUT_DIRECTORY)
                ->addOption('output-dir', null, InputOption::VALUE_REQUIRED, 'The output directory', __DIR__ . self::DEFAULT_OUTPUT_DIRECTORY)
                ->addOption('platform', null, InputOption::VALUE_REQUIRED, 'The platform', self::DEFAULT_PLATFORM)
                ->addOption('recursive', null, InputOption::VALUE_NONE, 'Search for schema.xml inside the input directory')
                ->setName('propel:graphviz:generate')
                ->setAliases(array('graphviz'))
                ->setDescription('Generate Graphviz files (.dot)')
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
            'propel.platform.class' => $input->getOption('platform'),
            'propel.packageObjectModel' => true,
                ), $input);

        $this->createDirectory($input->getOption('output-dir'));

        $manager = new GraphvizManager();
        $manager->setGeneratorConfig($generatorConfig);
        $manager->setSchemas($this->getSchemas($input->getOption('input-dir'), $input->getOption('recursive')));
        $manager->setLoggerClosure(function ($message) use ($input, $output) {
            if ($input->getOption('verbose')) {
                $output->writeln($message);
            }
        });
        $manager->setWorkingDirectory($input->getOption('output-dir'));

        $manager->build();
    }

}
