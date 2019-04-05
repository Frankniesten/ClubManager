<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\TotalMembers;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="dashboard")
     */
    public function index(TotalMembers $totalMembers)
    {
	    
	    $totalMembers = $totalMembers->countAllMembers();
	    
        return $this->render('dashboard/dashboard.html.twig', [
            'totalMembers' => $totalMembers,
        ]);
    }
}
