<?php 
	
	// src/Service/MembershipYears.php
	namespace App\Service;
	
	
	use App\Entity\Membership;
	use App\Entity\Person;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

	
	class MembershipYears extends AbstractController
	{
		
		public function processAllMembershipYears()
		{
			$people = $this->getDoctrine()
			->getRepository(Person::class)
			->findAll();
			
			foreach ($people as $key => $value)
			{
				$personID = $value->getId();

				//Get all memberships from person:	
				$memberships = $this->getDoctrine()
				->getRepository(Membership::class)
				->findMembershipsFromPerson($personID);
			
				if ($memberships) {
					
					$totalYears = null;
		
					foreach ($memberships as $key => $value)
					{
						
						$startDate = $value->GetstartDate();
						
						
						if (empty($value->GetendDate())) 
						{	
							$endDate = new \DateTime();
						}
						else 
						{
							$endDate = $value->GetendDate();
						}
						
						$difference = date_diff($endDate, $startDate);
						$totalYears += $difference = $difference->format('%y');
					}				
				}
				
				else {
					$totalYears = null;
				}
		
				$em = $this->getDoctrine()->getManager();
				$person = $em->getRepository(Person::class)->find($personID);
				
				$person->setMembershipYears($totalYears);
				$em->flush();
			}
		}
		
		public function MembershipYears(string $personID)
		{
			//Get all memberships from person:	
			$memberships = $this->getDoctrine()
				->getRepository(Membership::class)
				->findMembershipsFromPerson($personID);
				
			if ($memberships) {
				
				$totalYears = null;
	
				foreach ($memberships as $key => $value)
				{
					
					$startDate = $value->GetstartDate();
					
					
					if (empty($value->GetendDate())) 
					{	
						$endDate = new \DateTime();
					}
					else 
					{
						$endDate = $value->GetendDate();
					}
					
					$difference = date_diff($endDate, $startDate);
					$totalYears += $difference = $difference->format('%y');
				}				
			}
			else {
				$totalYears = null;
			}
			
			//Zet waarde in database.
				
				$em = $this->getDoctrine()->getManager();
				$person = $em->getRepository(Person::class)->find($personID);
				
				$person->setMembershipYears($totalYears);
				$em->flush();
		}
	}