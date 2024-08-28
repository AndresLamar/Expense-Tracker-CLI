<?php

// 01 giving a name space
//Remember to set MyExample in the autoload.psr-4 in composer.json

namespace App\Commands;

// 02 Importing the Command base class
use Symfony\Component\Console\Command\Command;
// 03 Importing the input/output interfaces
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use App\Services\ExpenseStorage;

// 04 Defining the class extending the Command base class
class ListCommand extends Command
{
    // 05 Implementing the configure method

    protected function configure()
    {
        $this
            // 06 defining the command name
            ->setName('list')
            // 07 defining the description of the command
            ->setDescription('List all expenses ')
            // 08 defining the help (shown with -h option)
            ->setHelp('This command lists all expenses')
            ->addOption(
                'category',
                'c',
                InputOption::VALUE_OPTIONAL,
                'The category of the expense',
                ''
            )
            ->addOption(
                'list-categories',
                'lc',
                InputOption::VALUE_NONE,
                'List all categories with the number of expenses'
            );
    }

    // 09 implementing the execute method
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // 10 using the Output for writing something

        $storage = new ExpenseStorage();

        if ($input->getOption('list-categories')) {
            $result = $storage->listCategories();
        } else {
            $result = $storage->listExpenses($input->getOption('category'));
        }

        // $result = $storage->listExpenses($input->getOption('category'));

        $output->writeln($result);

        return Command::SUCCESS;
    }
}
