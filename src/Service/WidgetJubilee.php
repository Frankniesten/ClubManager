<?php
// src/Service/WidgetJubilee.php

namespace App\Service;

use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WidgetJubilee extends AbstractController
{
	public function WidgetJubilee()
    {
	    
	    $jubilee = $this->getDoctrine()
        ->getRepository(Person::class)->Jubilee();
	    
		return $jubilee;
	}
}