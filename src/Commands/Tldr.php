<?php

namespace BrainMaestro\Tldr\Commands;

use BrainMaestro\Tldr\Page;
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
            ->addArgument(
                'page',
                InputArgument::REQUIRED,
                'Requested tldr page'
            )
            ->addOption(
                'platform',
                'p',
                InputOption::VALUE_REQUIRED,
                'Platform of the command',
                'common'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $platform = $input->getOption('platform');
        $page = $input->getArgument('page');

        $pageContent = Page::get($platform, $page);

        if (! $pageContent) {
            $output->writeln("<error>{$page} command does not exist on the {$platform} platform</error>");
            return 1;
        }

        $output->writeln($pageContent);
    }
}
