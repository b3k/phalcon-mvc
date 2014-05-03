<?php

namespace App\Tasks\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Propel\Generator\Exception\RuntimeException;

/**
 * @author William Durand <william.durand1@gmail.com>
 */
abstract class AbstractCommand extends Command
{

    const DEFAULT_INPUT_DIRECTORY = '.';

    protected $filesystem;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
                ->addOption('input-dir', null, InputOption::VALUE_REQUIRED, 'The input directory', self::DEFAULT_INPUT_DIRECTORY)
        ;
    }

    /**
     * Returns a Filesystem instance.
     *
     * @return Filesystem
     */
    protected function getFilesystem()
    {
        if (null === $this->filesystem) {
            $this->filesystem = new Filesystem();
        }

        return $this->filesystem;
    }

    protected function createDirectory($directory)
    {
        $filesystem = $this->getFilesystem();

        try {
            $filesystem->mkdir($directory);
        } catch (IOException $e) {
            throw new \RuntimeException(sprintf('Unable to write the "%s" directory', $directory), 0, $e);
        }
    }

}
