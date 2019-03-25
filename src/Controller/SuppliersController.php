<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\SuppliersFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class SuppliersController extends AbstractController
{
    /**
    * @Route("/event/{id}/suppliers/edit", name="app_organization_suppliers_edit")
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
	    $form = $this->createForm(SuppliersFormType::class, $event);
		
		//Handle form.
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$suppliers = $form->getData();
			$em->persist($suppliers);
			$em->flush();
			
			$this->addFlash('success', 'Performer: toegevoegd!');
					
			return $this->redirectToRoute('app_event_suppliers', array('id' => $id));			
		}

		return $this->render('suppliers/suppliersForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);	
	}
}
