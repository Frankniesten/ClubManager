<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\OrganizerFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class OrganizerController extends AbstractController
{
    /**
    * @Route("/event/{id}/organizer/edit", name="app_organization_organizer_edit")
    * @IsGranted("ROLE_EVENT_EDIT")
    */
    public function edit(EntityManagerInterface $em, Request $request, $id)
    {
	    //get person object.
	    $em = $this->getDoctrine()->getManager();
		$event = $em->getRepository(Event::class)->find($id);
		
		if (!$event) {
        	throw $this->createNotFoundException('The Organization does not exist');
    	}
	    
		//generate Form.
	    $form = $this->createForm(OrganizerFormType::class, $event);
		
		//Handle form.
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$organizer = $form->getData();
			$em->persist($organizer);
			$em->flush();
			
			$this->addFlash('success', 'Organisator: toegevoegd!');
					
			return $this->redirectToRoute('app_event_organizer', array('id' => $id));			
		}

		return $this->render('organizer/organizerForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);	
	}
}
