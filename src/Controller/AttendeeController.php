<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\AttendeeFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

class AttendeeController extends AbstractController
{
    /**
    * @Route("/event/{id}/attendee/edit", name="attendee_edit")
    * @IsGranted("ROLE_PERSON_EDIT")
    */
    public function edit(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
    {
	    //get person object.
	    $em = $this->getDoctrine()->getManager();
		$data = $em->getRepository(Event::class)->find($id);
		
		if (!$data) {
        	throw $this->createNotFoundException();
    	}
	    
		//generate Form.
	    $form = $this->createForm(AttendeeFormType::class, $data);
		
		//Handle form.
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$attendee = $form->getData();
			$em->persist($attendee);
			$em->flush();

            $this->addFlash('success', $translator->trans('Attendee_updated'));

            return $this->redirectToRoute('event_id', array('id' => $id, '_fragment' => 'attendee'));		
		}

		return $this->render('event/event-attendeeForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);	
	}
}
