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
class UpdateCommand extends Command
{
    // 05 Implementing the configure method

    protected function configure()
    {
        $this
            // 06 defining the command name
            ->setName('update')
            // 07 defining the description of the command
            ->setDescription('Update an expense ')
            // 08 defining the help (shown with -h option)
            ->setHelp('This command allows you to update an expense')
            ->addOption(
                'id',
                '',
                InputOption::VALUE_REQUIRED,
                'The ID of the expense to update'
            )
            ->addOption(
                'description',
                'd',
                InputOption::VALUE_OPTIONAL,
                'The description of the expense',
                ''
            )
            ->addOption(
                'amount',
                'a',
                InputOption::VALUE_REQUIRED,
                'The amount of the expense',

            );
    }

    // 09 implementing the execute method
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // 10 using the Output for writing something
        $data = [
            'id' => $input->getOption('id'),
            'description' => $input->getOption('description'),
            'amount' => $input->getOption('amount'),
        ];

        $storage = new ExpenseStorage();
        $result = $storage->updateExpense($data['id'], $data['description'], $data['amount']);

        $output->writeln($result);
        // 11 returning the success status

        return Command::SUCCESS;
    }
}
