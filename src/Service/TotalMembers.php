<?php
// src/Service/TotalMembers.php

namespace App\Service;

use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TotalMembers extends AbstractController
{
	public function countAllMembers()
    {
	    
	    $countMembers = $this->getDoctrine()
        ->getRepository(Person::class)->CountByCategegory();
	    
		return $countMembers;
	}
}