<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PeopleController extends AbstractController
{
    /**
     * @Route("/people", name="app_people")
     */
	public function list(EntityManagerInterface $em, Request $request)
	{
		$people = $this->getDoctrine()
        ->getRepository(Person::class)
        ->findAll();
		
				
		return $this->render('people/people.html.twig', [
        	'data' => $people
		]);
	}

	/**
     * @Route("/person/create", name="app_person_create")
     */
	public function new(EntityManagerInterface $em, Request $request)
	{
		$form = $this->createForm(PersonFormType::class);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$person = $form->getData();
			
			$em->persist($person);
			$em->flush();
			$id = $person->getId();
           
			$this->addFlash('success', $person->getFamilyName().', '.$person->getGivenName().' '.$person->getAdditionalName().' is aangemaakt!');
			
			return $this->redirectToRoute('app_person', array('id' => $id));			
		}
		
		return $this->render('people/personCreate.html.twig', [
        	'form' => $form->createView()
		]);
	}

	/**
     * @Route("/person/{id}", name="app_person")
     */
	public function show(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$person = $em->getRepository(Person::class)->find($id);
		        
		return $this->render('people/person.html.twig', [
        	'data' => $person
		]);
	}
	
		
	/**
     * @Route("/person/{id}/edit", name="app_person_edit")
     */
	public function edit(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$person = $em->getRepository(Person::class)->find($id);
		        
        
		$form = $this->createForm(PersonFormType::class, $person);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$person = $form->getData();
			
			$em->persist($person);
			$em->flush();
           
			$this->addFlash('success', $person->getFamilyName().', '.$person->getGivenName().' '.$person->getAdditionalName().' is bijgewerkt!');
			
			return $this->redirectToRoute('app_person', array('id' => $id));			
		}
		
		return $this->render('people/personEdit.html.twig', [
        	'form' => $form->createView(),
        	'data' => $person
		]);
	}
	
	
	/**
     * @Route("/person/{id}/delete", name="person_delete")
     */
	public function del(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$person = $em->getRepository(Person::class)->find($id);

			$em->remove($person);
			$em->flush();
           
			$this->addFlash('success', 'Persoon is verwijderd!');
			
			return $this->redirectToRoute('app_people');			
	}
}
