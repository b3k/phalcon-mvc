<?php

namespace App\Tasks\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Propel\Generator\Exception\RuntimeException;

abstract class AbstractCommand extends Command
{

    const DEFAULT_INPUT_DIRECTORY = '.';
    const DEFAULT_INPUT_ENV = 'development';

    protected $filesystem;

    protected function configure()
    {
        $this
                ->addOption('env', null, InputOption::VALUE_REQUIRED, 'Application environment', self::DEFAULT_INPUT_ENV)
                ->addOption('input-dir', null, InputOption::VALUE_REQUIRED, 'The input directory', self::DEFAULT_INPUT_DIRECTORY)
        ;
    }

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
