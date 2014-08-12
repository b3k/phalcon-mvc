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
use App\Library\PropelConnector\Propel\Generator\Config\GeneratorConfig;
use Propel\Generator\Config\ArrayToPhpConverter;
use App\Tasks\Command\AbstractCommand;

class ConfigConvertCommand extends \Propel\Generator\Command\ConfigConvertCommand
{

    const DEFAULT_OUTPUT_DIRECTORY = '/../../../../../../tmp';
    const DEFAULT_OUTPUT_FILE = 'propel.php';
    const DEFAULT_INPUT_DIRECTORY = '/../../../../../../config/db';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
                ->addOption('env', null, InputOption::VALUE_REQUIRED, 'Application environment', AbstractCommand::DEFAULT_INPUT_ENV)
                ->addOption('input-dir', null, InputOption::VALUE_REQUIRED, 'The input directory', __DIR__ . self::DEFAULT_INPUT_DIRECTORY)
                ->addOption('output-dir', null, InputOption::VALUE_REQUIRED, 'The output directory', __DIR__ . self::DEFAULT_OUTPUT_DIRECTORY)
                ->addOption('output-file', null, InputOption::VALUE_REQUIRED, 'The output file', self::DEFAULT_OUTPUT_FILE)
                ->setName('propel:config:convert')
                ->setAliases(array('convert-conf'))
                ->setDescription('Transform the configuration to PHP code leveraging the ServiceContainer')
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

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //$configManager = new ConfigurationManager($input->getOption('input-dir'));
        $configManager = $this->getGeneratorConfig(null, $input);
        $input->setOption('output-dir', $input->getOption('output-dir') . DIRECTORY_SEPARATOR . $input->getOption('env'));

        $this->createDirectory($input->getOption('output-dir'));

        $outputFilePath = $input->getOption('output-dir') . DIRECTORY_SEPARATOR . $input->getOption('output-file');
        if (!is_writable(dirname($outputFilePath))) {
            throw new \RuntimeException(sprintf('Unable to write the "%s" output file', $outputFilePath));
        }

        //Create the options array to pass to ArrayToPhpConverter
        $options['connections'] = $configManager->getConnectionParametersArray();
        $options['defaultConnection'] = $configManager->getSection('runtime')['defaultConnection'];
        $options['log'] = $configManager->getSection('runtime')['log'];
        $options['profiler'] = $configManager->getConfigProperty('runtime.profiler');

        $phpConf = ArrayToPhpConverter::convert($options);
        $phpConf = "<?php
" . $phpConf;

        if (file_exists($outputFilePath)) {
            $currentContent = file_get_contents($outputFilePath);
            if ($currentContent == $phpConf) {
                $output->writeln(sprintf('No change required in the current configuration file <info>"%s"</info>.', $outputFilePath));
            } else {
                file_put_contents($outputFilePath, $phpConf);
                $output->writeln(sprintf('Successfully updated PHP configuration in file <info>"%s"</info>.', $outputFilePath));
            }
        } else {
            file_put_contents($outputFilePath, $phpConf);
            $output->writeln(sprintf('Successfully wrote PHP configuration in file <info>"%s"</info>.', $outputFilePath));
        }
    }

}
