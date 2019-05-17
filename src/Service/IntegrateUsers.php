<?php 
	
	// src/Service/IntegrateUsers.php
	namespace App\Service;
	
	
	//use App\Entity\Membership;
	//use App\Entity\Person;
	use Doctrine\ORM\EntityManagerInterface;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

	
	class IntegrateUsers extends AbstractController
	{
		
		public function processIntegrateUsersFull()
		{
			/*Hier een volledige sync met de users tabel.
				
				We syncen op rol met ID=1.
				
				
				Dit doen we een keer per nacht.
				
				
				- Haal alle users op uit users tabel
				- haal alle users op uit Idp
				- doorzoek de verschillen.
				- Pas alle verschillen aan.
				
				
				
				*/
			
		}
		
		public function processIntegrateUsersIncremental()
		{
			/*
				Hier een incrementale sync. Dit kan op basis van de users tabel en de updated at tabel
				
				Als update en created hetzelfde zijn is het een nieuwe. Als er verschil is is het een update.
				
				Timestamp zouden we in de cache kunnen gooien. Als er geen cache waarde is doen we een full sync. Je zou met de cache waarde kunnen regelen hoe vaak een full en of inc. Sync moet plaatsvinden.
				
				Waar hou je de timestamps bij?
				
				- Haal alle wijzigingen op uit log tabel van user type.
				- Is er geen wijziging binnen tijdsvak doe niets. Else {
				- Anders voor wijziging uit.
				- Create -> Gebruiker posten via API.
				
				- Edit -> Gebruiker zoeken via API en dan wijzigen.
				- Delete -> Gebruiker zoeken via API en dan verwijderen.
			*/		
		}
	}