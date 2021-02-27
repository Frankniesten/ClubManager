<?php
// src/Service/WidgetTotalMembers.php

namespace App\Service;

use App\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WidgetBirthdays extends AbstractController
{
	public function WidgetBirthdays()
    {
	    
	    $birthdays = $this->getDoctrine()
        ->getRepository(Person::class)->Birthday();
	    
		return $birthdays;
	}
}