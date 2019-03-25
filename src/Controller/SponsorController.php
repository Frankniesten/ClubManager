<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\SponsorFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class SponsorController extends AbstractController
{
    /**
    * @Route("/event/{id}/sponsor/edit", name="app_organization_sponsor_edit")
    * @IsGranted("ROLE_EVENT_EDIT")
    */
    public function edit(EntityManagerInterface $em, Request $request, $id)
    {
	    //get person object.
	    $em = $this->getDoctrine()->getManager();
		$event = $em->getRepository(Event::class)->find($id);
		
		if (!$event) {
        	throw $this->createNotFoundException('The event does not exist');
    	}
	    
		//generate Form.
	    $form = $this->createForm(SponsorFormType::class, $event);
		
		//Handle form.
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$sponsor = $form->getData();
			$em->persist($sponsor);
			$em->flush();
			
			$this->addFlash('success', 'Sponsor: aangepast!');
					
			return $this->redirectToRoute('app_event_sponsor', array('id' => $id));			
		}

		return $this->render('sponsor/sponsorForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);	
	}
}
