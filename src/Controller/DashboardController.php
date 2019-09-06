<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\WidgetTotalMembers;
use App\Service\WidgetBirthdays;
use App\Service\WidgetJubilee;
use App\Service\WidgetEvents;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="dashboard")
     */
    public function index(WidgetEvents $events)
    {
	    $events = $events->WidgetEvents();
	    
        return $this->render('dashboard/dashboard.html.twig', [
            'events' =>$events
        ]);
    }
}
