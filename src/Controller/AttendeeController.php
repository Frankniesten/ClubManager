<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\AttendeeFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AttendeeController extends AbstractController
{
    /**
    * @Route("/event/{id}/attendee/edit", name="app_organization_attendee_edit")
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
	    $form = $this->createForm(AttendeeFormType::class, $event);
		
		//Handle form.
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$attendee = $form->getData();
			$em->persist($attendee);
			$em->flush();
			
			$this->addFlash('success', 'Performer: aangepast!');
					
			return $this->redirectToRoute('app_event_attendee', array('id' => $id));			
		}

		return $this->render('attendee/attendeeForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);	
	}
}
