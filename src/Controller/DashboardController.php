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
    public function index(WidgetTotalMembers $totalMembers, WidgetBirthdays $birthdays, WidgetJubilee $jubilee, WidgetEvents $events)
    {
	    
	    $totalMembers = $totalMembers->WidgetTotalMembers();
	    $birthdays = $birthdays->WidgetBirthdays();
	    $jubilee = $jubilee->WidgetJubilee();
	    $events = $events->WidgetEvents();
	    
        return $this->render('dashboard/dashboard.html.twig', [
            'totalMembers' => $totalMembers,
            'birthdays'=> $birthdays,
            'jubilee' => $jubilee,
            'events' =>$events
        ]);
    }
}
