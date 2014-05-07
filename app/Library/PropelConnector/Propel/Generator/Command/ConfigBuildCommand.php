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
use Propel\Generator\Config\XmlToArrayConverter;
use Propel\Generator\Config\ArrayToPhpConverter;

class ConfigBuildCommand extends \Propel\Generator\Command\AbstractCommand
{

    const DEFAULT_OUTPUT_DIRECTORY = '/../../../../../../config/db';
    const DEFAULT_OUTPUT_FILE = 'database.php';
    const DEFAULT_INPUT_DIRECTORY = '/../../../../../../config/environment/';
    const DEFAULT_INPUT_FILE = 'database.php';
    const DEFAULT_DEFAULT_ENVIRONMENT = 'development';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
                ->addOption('input-dir', null, InputOption::VALUE_REQUIRED, 'The input directory', __DIR__ . self::DEFAULT_INPUT_DIRECTORY)
                ->addOption('input-file', null, InputOption::VALUE_REQUIRED, 'The input file', self::DEFAULT_INPUT_FILE)
                ->addOption('output-dir', null, InputOption::VALUE_REQUIRED, 'The output directory', __DIR__ . self::DEFAULT_OUTPUT_DIRECTORY)
                ->addOption('output-file', null, InputOption::VALUE_REQUIRED, 'The output file', self::DEFAULT_OUTPUT_FILE)
                ->addOption('env', null, InputOption::VALUE_REQUIRED, 'Used environment', self::DEFAULT_DEFAULT_ENVIRONMENT)
                ->setName('falconidae:config:database')
                ->setAliases(array('db-config'))
                ->setDescription('Transform configuration of database into proper adapter config.')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputFilePath = $input->getOption('input-dir') . DIRECTORY_SEPARATOR . $input->getOption('env') . DIRECTORY_SEPARATOR . $input->getOption('input-file');
        
        if (!file_exists($inputFilePath)) {
            throw new \RuntimeException(sprintf('Unable to find the "%s" configuration file', $inputFilePath));
        }
        
        $this->createDirectory($input->getOption('output-dir') . DIRECTORY_SEPARATOR . $input->getOption('env'));

        $outputFilePath = $input->getOption('output-dir') . DIRECTORY_SEPARATOR . $input->getOption('env') . DIRECTORY_SEPARATOR . $input->getOption('output-file');

        if (!is_writable(dirname($outputFilePath))) {
            throw new \RuntimeException(sprintf('Unable to write the "%s" output file', $outputFilePath));
        }

        $mainConf = require($inputFilePath);
        $arrayConf = XmlToArrayConverter::convert($stringConf);
        $phpConf = ArrayToPhpConverter::convert($arrayConf);
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
