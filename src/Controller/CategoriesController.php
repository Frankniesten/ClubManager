<?php

namespace App\Controller;


use App\Entity\Categorie;
use App\Form\CategorieFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CategoriesController extends AbstractController
{
	
	
	/**
     * @Route("/settings/categories", name="app_settings_categories")
     */
	public function list(EntityManagerInterface $em, Request $request)
	{
		$categorie = $this->getDoctrine()
        ->getRepository(Categorie::class)
        ->findAll();
		
				
		return $this->render('categories/Categories.html.twig', [
        	'data' => $categorie
		]);
	}


	/**
     * @Route("/settings/categorie/create", name="categorie_create")
     */
	public function new(EntityManagerInterface $em, Request $request)
	{
		
		$form = $this->createForm(CategorieFormType::class);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$data = $form->getData();
						
			$categorie = new Categorie();
			$categorie->setName($data['name']);
			$categorie->setDescription($data['description']);
			$categorie->setAdditionalType($data['additionalType']);
		 
			$em->persist($categorie);
			$em->flush();
           
			$this->addFlash('success', 'De nieuwe categorie is opgeslagen!');
			
			return $this->redirectToRoute('app_settings_categories');			
		}
		
		return $this->render('categories/CategorieCreate.html.twig', [
        	'form' => $form->createView()
		]);
	}
	
	/**
     * @Route("/settings/categorie/{id}/edit", name="categorie_edit")
     */
	public function edit(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$categorie = $em->getRepository(Categorie::class)->find($id);
		        
        
		$form = $this->createForm(CategorieFormType::class, $categorie);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$categorie = $form->getData();
			
			$em->persist($categorie);
			$em->flush();
           
			$this->addFlash('success', 'De categorie is aangepast!');
			
			return $this->redirectToRoute('app_settings_categories');			
		}
		
		return $this->render('categories/CategorieEdit.html.twig', [
        	'form' => $form->createView(),
        	'data' => $categorie
		]);
	}
	
	/**
     * @Route("/settings/categorie/{id}/delete", name="categorie_delete")
     */
	public function del(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$categorie = $em->getRepository(Categorie::class)->find($id);

			$em->remove($categorie);
			$em->flush();
           
			$this->addFlash('success', 'De categorie is verwijderd!');
			
			return $this->redirectToRoute('app_settings_categories');			
	}
}