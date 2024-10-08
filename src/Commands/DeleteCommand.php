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
class DeleteCommand extends Command
{
    // 05 Implementing the configure method

    protected function configure()
    {
        $this
            // 06 defining the command name
            ->setName('delete')
            // 07 defining the description of the command
            ->setDescription('Delete an expense')
            // 08 defining the help (shown with -h option)
            ->setHelp('This command allows you to delete an expense')
            ->addOption(
                'id',
                '',
                InputOption::VALUE_REQUIRED,
                'The ID of the expense to delete',
                ''
            );
    }

    // 09 implementing the execute method
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // 10 using the Output for writing something

        $storage = new ExpenseStorage();

        $result = $storage->deleteExpenses($input->getOption('id'));

        $output->writeln($result);

        return Command::SUCCESS;
    }
}
