<?php

// src/Command/DonationRelations.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\DonationSetRelations;

class ProcessDonationSetRelations extends Command
{
	private $DonationSetRelations;
    protected static $defaultName = 'app:processDonationSetRelations';

    protected function configure()
    {
        $this
        ->setDescription('Set Person en Organization based on bank account information')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to process Person en Organization based on bank account information.');
    }

    public function __construct(DonationSetRelations $DonationSetRelations)
    {
        $this->DonationSetRelations = $DonationSetRelations;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
	    
	    $this->DonationSetRelations->processAllRelations();
        $output->writeln('Donations relations set.');
    }
}