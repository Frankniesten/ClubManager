<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\PerformerFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

class PerformerController extends AbstractController
{
    /**
    * @Route("/event/{id}/performer/edit", name="performer_edit")
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
	    $form = $this->createForm(PerformerFormType::class, $data);
		
		//Handle form.
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$performer = $form->getData();
			$em->persist($performer);
			$em->flush();

            $this->addFlash('success', $translator->trans('Performer_updated'));

            return $this->redirectToRoute('event_id', array('id' => $id, '_fragment' => 'performer'));
		}

		return $this->render('event/event-performerForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);	
	}
}
