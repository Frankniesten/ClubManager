<?php
// src/Service/WidgetJubilee.php

namespace App\Service;

use App\Entity\Person;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WidgetJubilee extends AbstractController
{
	public function WidgetJubilee()
    {

        $countMembers = array();

	    $jubilee = $this->getDoctrine()
        ->getRepository(Person::class)->Jubilee();

        //Count number of members per category:
        foreach ($jubilee as $key => $value)
        {
            $givenName = $value->getGivenName();
            $additionalName = $value->getAdditionalName();
            $familyName = $value->getFamilyName();

            $countMembers[$key]['name'] = $familyName.", ".$givenName." ".$additionalName;
            $countMembers[$key]['membershipYears'] = $value->getMembershipYears();
        }
	    
		return $countMembers;
	}
}