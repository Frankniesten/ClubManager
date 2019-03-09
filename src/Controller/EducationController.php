<?php

namespace App\Controller;

use App\Entity\Education;
use App\Entity\Person;
use App\Form\EducationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class EducationController extends AbstractController
{
    /**
     * @Route("/person/{id}/education/create", name="app_person_education_create")
     * @IsGranted("ROLE_PERSON_CREATE")
     */
	public function new(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$person = $em->getRepository(Person::class)->find($id);
	    
		//generate Form.
	    $form = $this->createForm(EducationFormType::class);
		
		//Handle form.
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$education = $form->getData();
			$person->addEducation($education);
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($education);
			$em->persist($person);
			$em->flush();
			
			return $this->redirectToRoute('app_person_education', array('id' => $id));				
		}
		
		return $this->render('education/educationForm.html.twig', [
        	'form' => $form->createView(),
			'id' => $id
		]);
	}
	
	/**
	* @Route("/person/{id}/education/{educationID}/edit", name="app_person_education_edit")
	* @IsGranted("ROLE_PERSON_EDIT")
	*/
	public function edit(EntityManagerInterface $em, Request $request, $id, $educationID)
	{
		$em = $this->getDoctrine()->getManager();
		$education = $em->getRepository(Education::class)->find($educationID);
		        
        
		$form = $this->createForm(EducationFormType::class, $education);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$education = $form->getData();
			
			$em->persist($education);
			$em->flush();
           
			$this->addFlash('success', 'Opleiding is bijgewerkt!');
			
			return $this->redirectToRoute('app_person_education', array('id' => $id));			
		}
		
		return $this->render('education/educationForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $education,
        	'id' => $id
		]);
	}


	/**
	* @Route("/person/{id}/education/{educationID}/delete", name="app_person_education_delete")
	* @IsGranted("ROLE_PERSON_DELETE")
	*/
	public function delete(EntityManagerInterface $em, Request $request, $id, $educationID)
	{
		
		$em = $this->getDoctrine()->getManager();
		$education = $em->getRepository(Education::class)->find($educationID);
		        
		$em->remove($education);
		$em->flush();
		
		$this->addFlash('warning', 'Opleiding is verwijderd!');
		
		return $this->redirectToRoute('app_person_education', array('id' => $id));	
	} 
}