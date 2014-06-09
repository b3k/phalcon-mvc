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
use Propel\Generator\Config\GeneratorConfig;

/**
 * @author Florian Klein <florian.klein@free.fr>
 * @author William Durand <william.durand1@gmail.com>
 */
class ModelBuildCommand extends \Propel\Generator\Command\ModelBuildCommand
{

    const DEFAULT_OUTPUT_DIRECTORY = '/../../../../../../app/Model/';
    const DEFAULT_INPUT_DIRECTORY = '/../../../../../../config/';
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

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
                ->addOption('env', null, InputOption::VALUE_REQUIRED, 'Application environment', AbstractCommand::DEFAULT_INPUT_ENV)
                ->addOption('platform', null, InputOption::VALUE_REQUIRED, 'The platform', self::DEFAULT_PLATFORM)
                ->addOption('recursive', null, InputOption::VALUE_NONE, 'Search for schema.xml inside the input directory')
                ->addOption('mysql-engine', null, InputOption::VALUE_REQUIRED, 'MySQL engine (MyISAM, InnoDB, ...)', self::DEFAULT_MYSQL_ENGINE)
                ->addOption('input-dir', null, InputOption::VALUE_REQUIRED, 'The input directory', __DIR__ . self::DEFAULT_INPUT_DIRECTORY)
                ->addOption('output-dir', null, InputOption::VALUE_REQUIRED, 'The output directory', __DIR__ . self::DEFAULT_OUTPUT_DIRECTORY)
                ->addOption('object-class', null, InputOption::VALUE_REQUIRED, 'The object class generator name', self::DEFAULT_OBJECT_BUILDER)
                ->addOption('object-stub-class', null, InputOption::VALUE_REQUIRED, 'The object stub class generator name', self::DEFAULT_OBJECT_STUB_BUILDER)
                ->addOption('object-multiextend-class', null, InputOption::VALUE_REQUIRED, 'The object multiextend class generator name', self::DEFAULT_MULTIEXTEND_OBJECT_BUILDER)
                ->addOption('query-class', null, InputOption::VALUE_REQUIRED, 'The query class generator name', self::DEFAULT_QUERY_BUILDER)
                ->addOption('query-stub-class', null, InputOption::VALUE_REQUIRED, 'The query stub class generator name', self::DEFAULT_QUERY_STUB_BUILDER)
                ->addOption('query-inheritance-class', null, InputOption::VALUE_REQUIRED, 'The query inheritance class generator name', self::DEFAULT_QUERY_INHERITANCE_BUILDER)
                ->addOption('query-inheritance-stub-class', null, InputOption::VALUE_REQUIRED, 'The query inheritance stub class generator name', self::DEFAULT_QUERY_INHERITANCE_STUB_BUILDER)
                ->addOption('tablemap-class', null, InputOption::VALUE_REQUIRED, 'The tablemap class generator name', self::DEFAULT_TABLEMAP_BUILDER)
                ->addOption('pluralizer-class', null, InputOption::VALUE_REQUIRED, 'The pluralizer class name', self::DEFAULT_PLURALIZER)
                ->addOption('enable-identifier-quoting', null, InputOption::VALUE_NONE, 'Identifier quoting may result in undesired behavior (especially in Postgres)')
                ->addOption('target-package', null, InputOption::VALUE_REQUIRED, '', '')
                ->addOption('enable-package-object-model', null, InputOption::VALUE_NONE, '')
                ->addOption('disable-namespace-auto-package', null, InputOption::VALUE_NONE, 'Disable namespace auto-packaging')
                ->addOption('composer-dir', null, InputOption::VALUE_REQUIRED, 'Directory in which your composer.json resides', null)
                ->setName('propel:model:build')
                ->setAliases(array('build'))
                ->setDescription('Build the model classes based on Propel XML schemas')
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
                    $properties, $this->getBuildProperties($input->getOption('input-dir') . DIRECTORY_SEPARATOR . 'environment' . DIRECTORY_SEPARATOR . $input->getOption('env') . DIRECTORY_SEPARATOR . 'propel' . DIRECTORY_SEPARATOR . 'build.properties')
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
            'propel.builder.object.class' => $input->getOption('object-class'),
            'propel.builder.objectstub.class' => $input->getOption('object-stub-class'),
            'propel.builder.objectmultiextend.class' => $input->getOption('object-multiextend-class'),
            'propel.builder.query.class' => $input->getOption('query-class'),
            'propel.builder.querystub.class' => $input->getOption('query-stub-class'),
            'propel.builder.queryinheritance.class' => $input->getOption('query-inheritance-class'),
            'propel.builder.queryinheritancestub.class' => $input->getOption('query-inheritance-stub-class'),
            'propel.builder.tablemap.class' => $input->getOption('tablemap-class'),
            'propel.builder.pluralizer.class' => $input->getOption('pluralizer-class'),
            'propel.builder.composer.dir' => $input->getOption('composer-dir'),
            'propel.disableIdentifierQuoting' => !$input->getOption('enable-identifier-quoting'),
            'propel.targetPackage' => $input->getOption('target-package'),
            'propel.packageObjectModel' => $input->getOption('enable-package-object-model'),
            'propel.namespace.autoPackage' => !$input->getOption('disable-namespace-auto-package'),
            'propel.addGenericAccessors' => true,
            'propel.addGenericMutators' => true,
            'propel.addSaveMethod' => true,
            'propel.addTimeStamp' => false,
            'propel.addValidateMethod' => true,
            'propel.addHooks' => true,
            'propel.namespace.map' => 'Map',
            'propel.useLeftJoinsInDoJoinMethods' => true,
            'propel.emulateForeignKeyConstraints' => false,
            'propel.schema.autoPrefix' => true,
            'propel.dateTimeClass' => '\DateTime',
            // MySQL specific
            'propel.mysql.tableType' => $input->getOption('mysql-engine'),
            'propel.mysql.tableEngineKeyword' => 'ENGINE',
                ), $input);

        $this->createDirectory($input->getOption('output-dir'));

        $manager = new ModelManager();
        $manager->setFilesystem($this->getFilesystem());
        $manager->setGeneratorConfig($generatorConfig);
        $manager->setSchemas($this->getSchemas($input->getOption('input-dir') . 'db', $input->getOption('recursive')));
        $manager->setLoggerClosure(function ($message) use ($input, $output) {
            if ($input->getOption('verbose')) {
                $output->writeln($message);
            }
        });
        $manager->setWorkingDirectory($input->getOption('output-dir'));

        $manager->build();
    }

}
