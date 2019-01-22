<?php

// src/Command/ProcessProductsOnLoanCommand.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\ProductsOnLoan;

class ProcessProductsOnLoanCommand extends Command
{
	private $productsOnLoan;
    protected static $defaultName = 'app:processProductsOnLoan';

    protected function configure()
    {
        $this
        ->setDescription('Process products that have been loaned.')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to process products that have been loaned.');
    }
    
    
    

    public function __construct(ProductsOnLoan $productsOnLoan)
    {
        $this->ProductsOnLoan = $productsOnLoan;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
	    
	    $this->ProductsOnLoan->processAllProducts();
        $output->writeln('Products that have been loaned are processed.');
    }
}
