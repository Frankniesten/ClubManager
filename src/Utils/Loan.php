<?php 
	
	// src/Utils/Loan.php
	namespace App\Utils;
	
	
	use App\Entity\Product;
	use App\Entity\OwnershipInfo;
	use Doctrine\ORM\EntityManagerInterface;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\Validator\Constraints\DateTime;
	
	class Loan extends AbstractController
	{
		public function Loan(string $productID)
		{
			
			//Get all ownershipinfo from product:	
			
			
			//Is er een einddatum
				//Nee is kassa.
				
			//Ja is datum checken.
			// Valt datum voor huidige datum?
				//Ja is kassa.
				
				
			//Zet waarde in DB
			
		}
	}
