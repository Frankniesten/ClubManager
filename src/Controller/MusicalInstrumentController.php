<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\MusicalInstrumentAddFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

class MusicalInstrumentController extends AbstractController
{
    /**
    * @Route("/person/{id}/musical-instrument/edit", name="person_musicalInstrument")
    * @IsGranted("ROLE_PERSON_EDIT")
    */
    public function edit(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
    {
	    //get person object.
	    $em = $this->getDoctrine()->getManager();
		$person = $em->getRepository(Person::class)->find($id);
		
		if (!$person) {
        	throw $this->createNotFoundException();
    	}
	    
		//generate Form.
	    $form = $this->createForm(MusicalInstrumentAddFormType::class, $person);
		
		//Handle form.
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$person = $form->getData();
			
			$em->persist($person);
			$em->flush();
           
			$this->addFlash('success', $translator->trans('Musical instrument').' '. $translator->trans('flash_message_edit'));

            return $this->redirectToRoute('person_id', array('id' => $id, '_fragment' => 'musicalInstrument'));
		}

		return $this->render('person/person-musicalInstrumentForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);	
	}
}
