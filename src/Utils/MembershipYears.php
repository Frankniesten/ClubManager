<?php 
	
	// src/Utils/MembershipYears.php
	namespace App\Utils;
	
	
	use App\Entity\Membership;
	use App\Entity\Person;
	use Doctrine\ORM\EntityManagerInterface;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\Validator\Constraints\DateTime;
	
	class MembershipYears extends AbstractController
	{
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