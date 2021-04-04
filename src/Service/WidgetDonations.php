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
            //Get date and map in the right dateformat.
            $date = $value->getDonationDate();
            $date = $date->format('Y-m-d');

            //Get amount.
            $amount = (float) $value->getAmount();

            //Check if date exists in donations array.
            if (array_key_exists($date, $donations))
            {
                $oldAmount = $donations[$date];
                $newAmount = $oldAmount + $amount;
                $donations[$date] = $newAmount;
            }
            else
            {
                $donations[$date] = $amount;
            }
        }

        $convert = array();
        $i = 0;
        foreach ($donations as $key => $value)
        {
            $convert[$i]['date'] = $key;
            $convert[$i]['amount'] = $value;
            $i++;
        }



		return $convert;
	}
}