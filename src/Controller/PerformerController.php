<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\PerformerFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class PerformerController extends AbstractController
{
    /**
    * @Route("/event/{id}/performer/edit", name="app_organization_performer_edit")
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
	    $form = $this->createForm(PerformerFormType::class, $event);
		
		//Handle form.
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$performer = $form->getData();
			$em->persist($performer);
			$em->flush();
			
			$this->addFlash('success', 'Performer: toegevoegd!');
					
			return $this->redirectToRoute('app_event_performer', array('id' => $id));			
		}

		return $this->render('performer/performerForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);	
	}
}
