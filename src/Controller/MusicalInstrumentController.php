<?php

namespace App\Controller;

use App\Entity\MusicalInstrument;
use App\Entity\Person;
use App\Form\MusicalInstrumentAddFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MusicalInstrumentController extends AbstractController
{
    /**
    * @Route("/person/{id}/musical-instrument/create", name="app_person_musicalInstrument_create")
    */
    public function editMusicalInstrument(EntityManagerInterface $em, Request $request, $id)
    {
	    //get person object.
	    $em = $this->getDoctrine()->getManager();
		$person = $em->getRepository(Person::class)->find($id);
	    
		//generate Form.
	    $form = $this->createForm(MusicalInstrumentAddFormType::class, $person);
		
		//Handle form.
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$person = $form->getData();
			
			$em->persist($person);
			$em->flush();
           
			$this->addFlash('success', 'Muziekinstrument aan: '.$person->getFamilyName().', '.$person->getGivenName().' '.$person->getAdditionalName().' toegevoegd!');
					
			return $this->redirectToRoute('app_person_musicalInstrument', array('id' => $id));			
		}

		return $this->render('musical_instrument/musicalInstrumentForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);	
	}
	
	
	/**
     * @Route("/person/{id}/musical-instrument/delete", name="app_person_musicalInstrument_delete")
     */
	public function deleteMusicalInstrument(EntityManagerInterface $em, Request $request, $id)
    {
	    //get person object.
	    $em = $this->getDoctrine()->getManager();
		$person = $em->getRepository(Person::class)->find($id);
	    
		
		
			
		$person->setMusicalInstrument(null);
		
		$em->persist($person);
		$em->flush();
       
		$this->addFlash('warning', 'Muziekinstrument bij: '.$person->getFamilyName().', '.$person->getGivenName().' '.$person->getAdditionalName().' verwijders!');
				
		return $this->redirectToRoute('app_person', array('id' => $id));			

		return $this->render('musical_instrument/musicalInstrumentForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);	
	}
}
