<?php
// src/Service/WidgetJubilee.php

namespace App\Service;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WidgetEvents extends AbstractController
{
	public function WidgetEvents()
    {
	    
	    $upcomingEvents = $this->getDoctrine()
        ->getRepository(Event::class)->UpcomingEvents();
	    
		return $upcomingEvents;
	}
}