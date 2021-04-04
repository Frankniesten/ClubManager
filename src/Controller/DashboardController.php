<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Service\WidgetEvents;
use App\Service\WidgetProfile;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="dashboard")
     * @IsGranted("ROLE_USER")
     */
    public function index(WidgetEvents $events, WidgetProfile $profile)
    {
	    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
	    $user = $this->getUser();
	    
	    $id=$user->getPerson();
	    
	    $events = $events->WidgetEvents();
	    $profile = $profile->WidgetProfile($id);
	    
        return $this->render('dashboard/dashboard.html.twig', [
            'events' =>$events,
            'profile' =>$profile
        ]);
    }
}