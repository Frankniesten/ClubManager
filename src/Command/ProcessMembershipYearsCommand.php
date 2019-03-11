<?php

// src/Command/ProcessMembershipYearsCommand.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\MembershipYears;

class ProcessMembershipYearsCommand extends Command
{
	private $MembershipYears;
    protected static $defaultName = 'app:processMembershipyears';

    protected function configure()
    {
        $this
        ->setDescription('Process years of membership from every person')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to process all persons membershipyears');
    }
    
    public function __construct(MembershipYears $MembershipYears)
    {
        $this->MembershipYears = $MembershipYears;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
	    
	    $this->MembershipYears->processAllMembershipYears();
        $output->writeln('All memberships have been loaned are processed.');
    }
}
