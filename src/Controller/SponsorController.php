<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\SponsorFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

class SponsorController extends AbstractController
{
    /**
    * @Route("/event/{id}/sponsor/edit", name="sponsor_edit")
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
	    $form = $this->createForm(SponsorFormType::class, $data);
		
		//Handle form.
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$sponsor = $form->getData();
			$em->persist($sponsor);
			$em->flush();

            $this->addFlash('success', $translator->trans('Sponsor_updated'));

            return $this->redirectToRoute('event_id', array('id' => $id, '_fragment' => 'sponsor'));			
		}

		return $this->render('event/event-sponsorForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);	
	}
}
