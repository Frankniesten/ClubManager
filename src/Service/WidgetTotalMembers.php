<?php
// src/Service/WidgetTotalMembers.php

namespace App\Service;

use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WidgetTotalMembers extends AbstractController
{
	public function WidgetTotalMembers()
    {
	    
	    $countMembers = $this->getDoctrine()
        ->getRepository(Person::class)->CountByCategegory();
	    
		return $countMembers;
	}
}