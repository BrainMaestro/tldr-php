<?php

namespace BrainMaestro\Tldr\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Tldr extends Command
{
    protected function configure()
    {
        $this
            ->setName('tldr')
            ->setDescription('Displays simplified and community-driven man pages')
            ->setHelp('This command allows you to show simple man pages for commands')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Hello world');
    }
}
