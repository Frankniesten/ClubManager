<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\ContributorFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

class ContributorController extends AbstractController
{
    /**
    * @Route("/event/{id}/contributor/edit", name="contributor_edit")
    * @IsGranted("ROLE_EVENT_EDIT")
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
	    $form = $this->createForm(ContributorFormType::class, $data);
		
		//Handle form.
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$contributor = $form->getData();
			$em->persist($contributor);
			$em->flush();

            $this->addFlash('success', $translator->trans('Contributor_updated'));

            return $this->redirectToRoute('event_id', array('id' => $id, '_fragment' => 'contributor'));			
		}

		return $this->render('event/event-contributorForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);	
	}
}
