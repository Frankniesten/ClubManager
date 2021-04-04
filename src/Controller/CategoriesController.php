<?php

namespace App\Controller;


use App\Entity\Category;
use App\Form\CategoryFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;


class CategoriesController extends AbstractController
{

	/**
     * @Route("/settings/category", name="category")
     * @IsGranted("ROLE_SETTINGS_VIEW")
     */
	public function list(SessionInterface $session, EntityManagerInterface $em, Request $request)
	{

		//Check categorie:       
	    if ($query = $request->query->get('query'))
	    {
		    $session->set('category_query', $query);
	    }
	    else 
	    {
		    $query = $session->get('category_query', 'all');
	    }
    	
    	if ($query == 'all') {
    
			$category = $this->getDoctrine()
	        ->getRepository(Category::class)
	        ->findAll();    
	    }
	    
	    else 
	    {
		    $query = $session->get('category_query', 'all');
		    
		    $em = $this->getDoctrine()->getManager();
			$category = $em->getRepository(Category::class)->findCategoryType($query);      
	    }
		
				
		
		
		$em = $this->getDoctrine()->getManager();
		$categories = $em->getRepository(Category::class)->findByAdditionalType();
						
		return $this->render('categories/Categories.html.twig', [
        	'data' => $category,
        	'categories' => $categories,
        	'query' => $query
		]);
	}

	/**
     * @Route("/settings/category/create", name="category_create")
     * @IsGranted("ROLE_SETTINGS_CREATE")
     */
	public function new(EntityManagerInterface $em, Request $request, TranslatorInterface $translator)
	{
		$form = $this->createForm(CategoryFormType::class);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
		 
			$em->persist($data);
			$em->flush();

            $this->addFlash('success', $data->getName() . ' ' . $translator->trans('flash_message_create'));
			
			return $this->redirectToRoute('category');
		}
		
		return $this->render('categories/CategoryForm.html.twig', [
        	'form' => $form->createView()
		]);
	}
		
	/**
     * @Route("/settings/category/{id}/edit", name="category_edit")
     * @IsGranted("ROLE_SETTINGS_EDIT")
     */
	public function edit(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
	{
		$em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Category::class)->find($id);
		
		if (!$data) {
        	throw $this->createNotFoundException();
    	} 
		        
		$form = $this->createForm(CategoryFormType::class, $data);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
			
			$em->persist($data);
			$em->flush();

            $this->addFlash('success', $data->getName() . ' ' . $translator->trans('flash_message_edit'));
			
			return $this->redirectToRoute('category');
		}
		
		return $this->render('categories/CategoryForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $data
		]);
	}
	
	/**
     * @Route("/settings/category/{id}/delete", name="category_delete")
     * @IsGranted("ROLE_SETTINGS_DELETE")
     */
	public function del(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
	{
		$em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Category::class)->find($id);
		
		if (!$data) {
        	throw $this->createNotFoundException();
    	}    

			$em->remove($data);
			$em->flush();

        $this->addFlash('warning', $data->getName() . ' ' . $translator->trans('flash_message_delete'));
			
			return $this->redirectToRoute('category');
	}
}