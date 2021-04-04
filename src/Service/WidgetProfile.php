<?php
// src/Service/WidgetJubilee.php

namespace App\Service;

use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WidgetProfile extends AbstractController
{
	public function WidgetProfile($id)
    {
	    
	    $em = $this->getDoctrine()->getManager();
		$profile = $em->getRepository(Person::class)->find($id);
	    
		return $profile;
	}
}