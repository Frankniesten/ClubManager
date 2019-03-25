<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\ContributorFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ContributorController extends AbstractController
{
    /**
    * @Route("/event/{id}/contributor/edit", name="app_organization_contributor_edit")
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
	    $form = $this->createForm(ContributorFormType::class, $event);
		
		//Handle form.
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$contributor = $form->getData();
			$em->persist($contributor);
			$em->flush();
			
			$this->addFlash('success', 'Medewerker: aangepast!');
					
			return $this->redirectToRoute('app_event_contributor', array('id' => $id));			
		}

		return $this->render('contributor/contributorForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);	
	}
}
