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
                InputArgument::OPTIONAL,
                'Requested tldr page'
            )
            ->addOption(
                'platform',
                'p',
                InputOption::VALUE_REQUIRED,
                'Platform of the command',
                'common'
            )
            ->addOption(
                'clear-cache',
                'c',
                InputOption::VALUE_NONE,
                'Clear the entire local cache'
            )
            ->addOption(
                'update',
                'u',
                InputOption::VALUE_NONE,
                'Download latest version of pages in your local cache'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $platform = $input->getOption('platform');
        $page = $input->getArgument('page');

        if ($input->getOption('clear-cache')) {
            return Page::clearCache();
        }

        if ($input->getOption('update')) {
            Page::update();
            return;
        }

        $pageContent = Page::get($platform, $page);

        if (! $pageContent) {
            $output->writeln("<error>{$page} command does not exist on the {$platform} platform</error>");
            return 1;
        }

        $output->writeln($pageContent);
    }
}
