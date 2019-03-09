<?php

namespace App\Controller;


use App\Entity\Category;
use App\Form\CategoryFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class CategoriesController extends AbstractController
{

	/**
     * @Route("/settings/categorys", name="app_settings_categorys")
     * @IsGranted("ROLE_SETTINGS_VIEW")
     */
	public function list(EntityManagerInterface $em, Request $request)
	{
		$category = $this->getDoctrine()
        ->getRepository(Category::class)
        ->findAll();
		
				
		return $this->render('categories/Categories.html.twig', [
        	'data' => $category
		]);
	}

	/**
     * @Route("/settings/category/create", name="category_create")
     * @IsGranted("ROLE_SETTINGS_CREATE")
     */
	public function new(EntityManagerInterface $em, Request $request)
	{
		$form = $this->createForm(CategoryFormType::class);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$category = $form->getData();
		 
			$em->persist($category);
			$em->flush();
           
			$this->addFlash('success', 'Category: '.$category->getName().' is toegevoegd!');
			
			return $this->redirectToRoute('app_settings_categorys');			
		}
		
		return $this->render('categories/CategoryForm.html.twig', [
        	'form' => $form->createView()
		]);
	}
		
	/**
     * @Route("/settings/category/{id}/edit", name="category_edit")
     * @IsGranted("ROLE_SETTINGS_EDIT")
     */
	public function edit(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$category = $em->getRepository(Category::class)->find($id);
		        
		$form = $this->createForm(CategoryFormType::class, $category);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$category = $form->getData();
			
			$em->persist($category);
			$em->flush();
           
			$this->addFlash('success', 'Category: '.$category->getName().' is bijgewerkt!');
			
			return $this->redirectToRoute('app_settings_categorys');			
		}
		
		return $this->render('categories/CategoryForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $category
		]);
	}
	
	/**
     * @Route("/settings/category/{id}/delete", name="category_delete")
     * @IsGranted("ROLE_SETTINGS_DELETE")
     */
	public function del(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$category = $em->getRepository(Category::class)->find($id);

			$em->remove($category);
			$em->flush();
           
			$this->addFlash('warning', 'De category is verwijderd!');
			
			return $this->redirectToRoute('app_settings_categorys');			
	}
}