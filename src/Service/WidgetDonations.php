<?php
// src/Service/WidgetDonations.php

namespace App\Service;

use App\Entity\Donation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WidgetDonations extends AbstractController
{
	public function WidgetDonations($id)
    {

        $donations = array();


        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Donation::class)->findByFund($id);


        foreach ($data as $key => $value)
        {

            $date = $value->getDonationDate();
            $date = $date->format('d-m-Y');




            $donations[$key]['date'] = $date;
            $donations[$key]['amount'] = $value->getAmount();

            //Haal de gegevens op.
            //Check of de datum al bestaat.
            //Indien ja tel de waarde erbij op
            //Indien nee creeer een nieuwe waarde.
        }

		return $donations;
	}
}