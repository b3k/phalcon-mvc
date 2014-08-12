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
use App\Library\PropelConnector\Propel\Generator\Manager\ModelManager;
use App\Tasks\Command\AbstractCommand;
use App\Library\PropelConnector\Propel\Generator\Config\GeneratorConfig;

/**
 * @author Florian Klein <florian.klein@free.fr>
 * @author William Durand <william.durand1@gmail.com>
 */
class ModelBuildCommand extends \Propel\Generator\Command\ModelBuildCommand
{

    const DEFAULT_OUTPUT_DIRECTORY = '/../../../../../../app/Model';
    const DEFAULT_INPUT_DIRECTORY = '/../../../../../../config/db/';
    const DEFAULT_MYSQL_ENGINE = 'InnoDB';
    const DEFAULT_OBJECT_BUILDER = '\Propel\Generator\Builder\Om\ObjectBuilder';
    const DEFAULT_OBJECT_STUB_BUILDER = '\Propel\Generator\Builder\Om\ExtensionObjectBuilder';
    const DEFAULT_MULTIEXTEND_OBJECT_BUILDER = '\Propel\Generator\Builder\Om\MultiExtendObjectBuilder';
    const DEFAULT_QUERY_BUILDER = '\Propel\Generator\Builder\Om\QueryBuilder';
    const DEFAULT_QUERY_STUB_BUILDER = '\Propel\Generator\Builder\Om\ExtensionQueryBuilder';
    const DEFAULT_QUERY_INHERITANCE_BUILDER = '\Propel\Generator\Builder\Om\QueryInheritanceBuilder';
    const DEFAULT_QUERY_INHERITANCE_STUB_BUILDER = '\Propel\Generator\Builder\Om\ExtensionQueryInheritanceBuilder';
    const DEFAULT_TABLEMAP_BUILDER = '\Propel\Generator\Builder\Om\TableMapBuilder';
    const DEFAULT_PLURALIZER = '\Propel\Common\Pluralizer\StandardEnglishPluralizer';
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
                ->addOption('output-dir', null, InputOption::VALUE_REQUIRED, 'The output directory', __DIR__ . self::DEFAULT_OUTPUT_DIRECTORY)
                ->addOption('mysql-engine', null, InputOption::VALUE_REQUIRED, 'MySQL engine (MyISAM, InnoDB, ...)')
                ->addOption('object-class', null, InputOption::VALUE_REQUIRED, 'The object class generator name')
                ->addOption('object-stub-class', null, InputOption::VALUE_REQUIRED, 'The object stub class generator name')
                ->addOption('object-multiextend-class', null, InputOption::VALUE_REQUIRED, 'The object multiextend class generator name')
                ->addOption('query-class', null, InputOption::VALUE_REQUIRED, 'The query class generator name')
                ->addOption('query-stub-class', null, InputOption::VALUE_REQUIRED, 'The query stub class generator name')
                ->addOption('query-inheritance-class', null, InputOption::VALUE_REQUIRED, 'The query inheritance class generator name')
                ->addOption('query-inheritance-stub-class', null, InputOption::VALUE_REQUIRED, 'The query inheritance stub class generator name')
                ->addOption('tablemap-class', null, InputOption::VALUE_REQUIRED, 'The tablemap class generator name')
                ->addOption('pluralizer-class', null, InputOption::VALUE_REQUIRED, 'The pluralizer class name')
                ->addOption('enable-identifier-quoting', null, InputOption::VALUE_NONE, 'Identifier quoting may result in undesired behavior (especially in Postgres)')
                ->addOption('target-package', null, InputOption::VALUE_REQUIRED, '', '')
                ->addOption('enable-package-object-model', null, InputOption::VALUE_NONE, '')
                ->addOption('disable-namespace-autopackage', null, InputOption::VALUE_NONE, 'Disable namespace auto-packaging')
                ->addOption('composer-dir', null, InputOption::VALUE_REQUIRED, 'Directory in which your composer.json resides', null)
                ->setName('propel:model:build')
                ->setAliases(array('build'))
                ->setDescription('Build the model classes based on Propel XML schemas')
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
        $configOptions = array();
        $inputOptions = $input->getOptions();

        foreach ($inputOptions as $key => $option) {
            if (null !== $option) {
                switch ($key) {
                    case 'output-dir':
                        $configOptions['propel']['paths']['phpDir'] = $option;
                        break;
                    case 'objects-class':
                        $configOptions['propel']['generator']['objectModel']['builders']['object'] = $option;
                        break;
                    case 'object-stub-class':
                        $configOptions['propel']['generator']['objectModel']['builders']['objectstub'] = $option;
                        break;
                    case 'object-multiextend-class':
                        $configOptions['propel']['generator']['objectModel']['builders']['objectmultiextend'] = $option;
                        break;
                    case 'query-class':
                        $configOptions['propel']['generator']['objectModel']['builders']['query'] = $option;
                        break;
                    case 'query-stub-class':
                        $configOptions['propel']['generator']['objectModel']['builders']['querystub'] = $option;
                        break;
                    case 'query-inheritance-class':
                        $configOptions['propel']['generator']['objectModel']['builders']['queryinheritance'] = $option;
                        break;
                    case 'query-inheritance-stub-class':
                        $configOptions['propel']['generator']['objectModel']['builders']['queryinheritancestub'] = $option;
                        break;
                    case 'tablemap-class':
                        $configOptions['propel']['generator']['objectModel']['builders']['tablemap'] = $option;
                        break;
                    case 'pluralizer-class':
                        $configOptions['propel']['generator']['objectModel']['pluralizerClass'] = $option;
                        break;
                    case 'composer-dir':
                        $configOptions['propel']['paths']['composerDir'] = $option;
                        break;
                    case 'enable-identifier-quoting':
                        if ($option) {
                            $configOptions['propel']['generator']['objectModel']['disableIdentifierQuoting'] = !$option;
                        }
                        break;
                    case 'enable-package-object-model':
                        if ($option) {
                            $configOptions['propel']['generator']['packageObjectModel'] = $option;
                        }
                        break;
                    case 'disable-namespace-autopackage':
                        if ($option) {
                            $configOptions['propel']['generator']['namespaceAutoPackage'] = TRUE;
                        }
                        break;
                    case 'mysql-engine':
                        $configOptions['propel']['database']['adapters']['mysql']['tableType'] = $option;
                        break;
                }
            }
        }

        $generatorConfig = $this->getGeneratorConfig($configOptions, $input);
        $this->createDirectory($generatorConfig->getSection('paths')['phpDir']);

        $manager = new ModelManager();
        $manager->setFilesystem($this->getFilesystem());
        $manager->setGeneratorConfig($generatorConfig);
        $manager->setSchemas($this->getSchemas($input->getOption('input-dir'), $input->getOption('recursive')));
        $manager->setLoggerClosure(function ($message) use ($input, $output) {
            if ($input->getOption('verbose')) {
                $output->writeln($message);
            }
        });
        $manager->setWorkingDirectory($generatorConfig->getSection('paths')['phpDir']);

        $manager->build();
    }

}
