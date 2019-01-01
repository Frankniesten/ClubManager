<?php

namespace App\Controller;

use App\Entity\OwnershipInfo;
use App\Entity\Person;
use App\Form\OwnsFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class OwnsController extends AbstractController
{
	/**
     * @Route("/person/{id}/owns/create", name="app_person_owns_create")
     */
	public function new(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$person = $em->getRepository(Person::class)->find($id);
		
		$form = $this->createForm(OwnsFormType::class);
		
		
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$owns = $form->getData();
			$person->addOwn($owns);
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($owns);
			$em->persist($person);
			$em->flush();
			//$id = $person->getId();
           
			$this->addFlash('success', 'Nieuw product in bruikleen is aangemaakt!');
			
			return $this->redirectToRoute('app_person_owns', array('id' => $id));			
		}
		
		return $this->render('owns/ownsForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);
	}
	
	
	/**
	* @Route("/person/{id}/owns/{ownershipInfoID}/edit", name="app_person_owns_edit")
	*/
	public function edit(EntityManagerInterface $em, Request $request, $id, $ownershipInfoID)
	{
		$em = $this->getDoctrine()->getManager();
		$owns = $em->getRepository(OwnershipInfo::class)->find($ownershipInfoID);
		        
        
		$form = $this->createForm(OwnsFormType::class, $owns);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$owns = $form->getData();
			
			$em->persist($owns);
			$em->flush();
           
			$this->addFlash('success', 'Product in bruikleen is bijgewerkt!');
			
			return $this->redirectToRoute('app_person_owns', array('id' => $id));			
		}
		
		return $this->render('owns/ownsForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $owns,
        	'id' => $id
		]);
	}


	/**
	* @Route("/person/{id}/owns/{ownershipInfoID}/edit", name="app_person_owns_delete")
	*/
	public function delete(EntityManagerInterface $em, Request $request, $id, $ownershipInfoID)
	{
		
		$em = $this->getDoctrine()->getManager();
		$owns = $em->getRepository(OwnershipInfo::class)->find($ownershipInfoID);
		        
		$em->remove($owns);
		$em->flush();
		
		$this->addFlash('warning', 'Product in bruikleen is verwijderd!');
		
		return $this->redirectToRoute('app_person_owns', array('id' => $id));	
	} 
}