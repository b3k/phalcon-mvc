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
use App\Library\PropelConnector\Propel\Generator\Builder\ConfigBuilder;

class ConfigBuildCommand
        extends \App\Tasks\Command\AbstractCommand
{

    const DEFAULT_OUTPUT_FILE = 'service.php';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        
        parent::configure();
        
        $this
                ->addOption('output-dir', null, InputOption::VALUE_REQUIRED, 'The output directory', APP_CONFIG_DIR . DS . 'environment')
                ->addOption('output-file', null, InputOption::VALUE_REQUIRED, 'The output file', self::DEFAULT_OUTPUT_FILE)
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
        $configPath = $input->getOption('output-dir') . DIRECTORY_SEPARATOR . $input->getOption('env') . DS . 'propel';
        
        $this->createDirectory($configPath);

        $outputFilePath = $configPath . DIRECTORY_SEPARATOR . $input->getOption('output-file');

        if (!is_writable(dirname($outputFilePath))) {
            throw new \RuntimeException(sprintf('Unable to write the "%s" output file', $outputFilePath));
        }

        $mainConf = \Phalcon\DI::getDefault()->get('config')->toArray();

        if (!isset($mainConf['database'])) {
            throw new \Exception('No database config');
        }

        $ConfigBuilder = new ConfigBuilder($mainConf['database']);
        $ConfigBuilder->saveXml($configPath . DS . 'runtime-conf.build.xml');

        $arrayConf = XmlToArrayConverter::convert($ConfigBuilder->getXml());
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
