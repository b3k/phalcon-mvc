<?php

namespace App\Tasks\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;

class ClearCacheCommand extends AbstractCommand
{

    protected function configure()
    {
        parent::configure();

        $this
                ->addOption('skip-removed-table', null, InputOption::VALUE_NONE, 'Option to skip removed table from the migration')
                ->addOption('skip-tables', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL, 'List of excluded tables', array())
                ->addOption('comment', "m", InputOption::VALUE_OPTIONAL, 'A comment for the migration', '')
                ->setName('falconidae:cache:clear')
                ->setAliases(array('cc'))
                ->setDescription('Clears the cache')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $output->writeln(sprintf('<info>No connection configured for database "%s"</info>', 'cache'));
    }

}
