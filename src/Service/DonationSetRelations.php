<?php 
	
	// src/Service/DonationSetRelations.php
	namespace App\Service;
	
	
	use App\Entity\Donation;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

	
	class DonationSetRelations extends AbstractController
	{
		
		public function processAllRelations()
		{
		    //Get all donations:
            $donations = $this->getDoctrine()
            ->getRepository(Donation::class)
            ->findAll();

            foreach ($donations as $key => $value) {

                $bankAccountPerson = 0;
                $bankAccountOrganization = 0;

                if ($value->getBankAccount()) {
                    //Get Person or Organization id from bankaccount.
                    if($value->getBankAccount()->getPerson()) {
                        $bankAccountPerson = $value->getBankAccount()->getPerson();
                    }
                    if($value->getBankAccount()->getOrganization()) {
                        $bankAccountOrganization = $value->getBankAccount()->getOrganization();
                    }
                }

                //Set Person or Organization based on Bankaccount
                $em = $this->getDoctrine()->getManager();
                $data = $em->getRepository(Donation::class)->find($value->getId());

                if ($bankAccountPerson) {
                    $data->setPerson($bankAccountPerson);
                }
                if ($bankAccountOrganization) {
                    $data->setOrganization($bankAccountOrganization);
                }
                $em->flush();
            }
		}
	}