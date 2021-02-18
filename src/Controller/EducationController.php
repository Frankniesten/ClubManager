<?php

namespace App\Controller;

use App\Entity\Education;
use App\Entity\Person;
use App\Form\EducationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

class EducationController extends AbstractController
{
    /**
     * @Route("/person/{id}/education/create", name="person_education_create")
     * @IsGranted("ROLE_PERSON_CREATE")
     */
	public function new(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
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

            $this->addFlash('success', $translator->trans('Education').' '. $translator->trans('flash_message_create'));

            return $this->redirectToRoute('person_id', array('id' => $id, '_fragment' => 'education'));
		}
		
		return $this->render('person/person-educationForm.html.twig', [
        	'form' => $form->createView(),
			'id' => $id
		]);
	}
	
	/**
	* @Route("/person/{id}/education/{educationID}/edit", name="person_education_edit")
	* @IsGranted("ROLE_PERSON_EDIT")
	*/
	public function edit(EntityManagerInterface $em, Request $request, $id, $educationID, TranslatorInterface $translator)
	{
		$em = $this->getDoctrine()->getManager();
		$education = $em->getRepository(Education::class)->find($educationID);
		
		if (!$education) {
        	throw $this->createNotFoundException();
    	}    
        
		$form = $this->createForm(EducationFormType::class, $education);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$education = $form->getData();
			
			$em->persist($education);
			$em->flush();

            $this->addFlash('success', $translator->trans('Education').' '. $translator->trans('flash_message_edit'));

            return $this->redirectToRoute('person_id', array('id' => $id, '_fragment' => 'education'));
		}
		
		return $this->render('person/person-educationForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $education,
        	'id' => $id
		]);
	}


	/**
	* @Route("/person/{id}/education/{educationID}/delete", name="person_education_delete")
	* @IsGranted("ROLE_PERSON_DELETE")
	*/
	public function delete(EntityManagerInterface $em, Request $request, $id, $educationID, TranslatorInterface $translator)
	{
		
		$em = $this->getDoctrine()->getManager();
		$education = $em->getRepository(Education::class)->find($educationID);
		
		if (!$education) {
        	throw $this->createNotFoundException('The product does not exist');
    	}    
    	    
		$em->remove($education);
		$em->flush();

        $this->addFlash('warning', $translator->trans('Education').' '. $translator->trans('flash_message_delete'));

        return $this->redirectToRoute('person_id', array('id' => $id, '_fragment' => 'education'));
	} 
}