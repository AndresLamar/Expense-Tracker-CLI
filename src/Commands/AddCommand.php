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
class AddCommand extends Command
{
    // 05 Implementing the configure method

    protected function configure()
    {
        $this
            // 06 defining the command name
            ->setName('add')
            // 07 defining the description of the command
            ->setDescription('Add an expense ')
            // 08 defining the help (shown with -h option)
            ->setHelp('This command adds an expense')

            ->addOption(
                'description',
                'd',
                InputOption::VALUE_REQUIRED,
                'The description of the expense',
                ''
            )
            ->addOption(
                'amount',
                'a',
                InputOption::VALUE_REQUIRED,
                'The amount of the expense',
                0
            )
            ->addOption(
                'category',
                'c',
                InputOption::VALUE_OPTIONAL,
                'The category of the expense',
                ''
            );
    }

    // 09 implementing the execute method
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // 10 using the Output for writing something
        $data = [
            'description' => $input->getOption('description'),
            'amount' => $input->getOption('amount'),
            'category' => $input->getOption('category'),
        ];

        $storage = new ExpenseStorage();
        $result = $storage->addExpense($data['description'], $data['amount'], $data['category']);

        $output->writeln($result);
        // 11 returning the success status

        return Command::SUCCESS;
    }
}
