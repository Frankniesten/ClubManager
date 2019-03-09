<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\ParentsFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ParentsController extends AbstractController
{
    /**
    * @Route("/person/{id}/parents/create", name="app_person_parents_create")
    * @IsGranted("ROLE_PERSON_EDIT")
    */
    public function edit(EntityManagerInterface $em, Request $request, $id)
    {
	    //get person object.
	    $em = $this->getDoctrine()->getManager();
		$person = $em->getRepository(Person::class)->find($id);
	    
		//generate Form.
	    $form = $this->createForm(ParentsFormType::class, $person, array('personId' => $id));
		
		//Handle form.
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$person = $form->getData();
			
			$em->persist($person);
			$em->flush();
           
			$this->addFlash('success', 'Ouder(s) aan: '.$person->getFamilyName().', '.$person->getGivenName().' '.$person->getAdditionalName().' toegevoegd!');
					
			return $this->redirectToRoute('app_person_parents', array('id' => $id));			
		}

		return $this->render('parents/parentsForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);	
	}
	
}
