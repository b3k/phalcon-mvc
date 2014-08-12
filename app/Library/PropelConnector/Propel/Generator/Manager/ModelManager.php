<?php

/**
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace App\Library\PropelConnector\Propel\Generator\Manager;

use Propel\Generator\Builder\Om\AbstractOMBuilder;
use Symfony\Component\Filesystem\Filesystem;

class ModelManager extends \Propel\Generator\Manager\ModelManager
{

    /**
     * A Filesystem object.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Sets the filesystem object.
     *
     * @param Filesystem $filesystem
     */
    public function setFilesystem(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Uses a builder class to create the output class.
     * This method assumes that the DataModelBuilder class has been initialized
     * with the build properties.
     *
     * @param  AbstractOMBuilder $builder
     * @param  boolean           $overwrite
     * @return int
     */
    protected function doBuild(AbstractOMBuilder $builder, $overwrite = true)
    {
        $path = str_replace('App/Model/', '', $builder->getClassFilePath());
        $file = new \SplFileInfo($this->getWorkingDirectory() . DIRECTORY_SEPARATOR . $path);

        $this->filesystem->mkdir($file->getPath());

        // skip files already created once
        if ($file->isFile() && !$overwrite) {
            $this->log("\t-> (exists) " . $builder->getClassFilePath());

            return 0;
        }

        $script = $builder->build();
        foreach ($builder->getWarnings() as $warning) {
            $this->log($warning);
        }

        // skip unchanged files
        if ($file->isFile() && $script == file_get_contents($file->getPathname())) {
            $this->log("\t-> (unchanged) " . $builder->getClassFilePath());

            return 0;
        }

        // write / overwrite new / changed files
        $action = $file->isFile() ? 'Updating' : 'Creating';
        $this->log(sprintf("\t-> %s %s (table: %s, builder: %s)", $action, $builder->getClassFilePath(), $builder->getTable()->getName(), get_class($builder)));
        file_put_contents($file->getPathname(), $script);

        return 1;
    }

}
