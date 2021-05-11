<?php

namespace App\Controller;

use App\Entity\Products;
use App\Entity\Category;
use App\Form\ProductFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProductsController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     * @IsGranted("ROLE_PRODUCT_VIEW")
     */
    public function list(SessionInterface $session, EntityManagerInterface $em, Request $request)
    {
	    //Check categorie:       
	    if ($query = $request->query->get('category'))
	    {
		    $session->set('products_query', $query);
	    }
	    else 
	    {
		    $query = $session->get('products_query', 'all');
	    }
    	
    	if ($query == 'all') 
    	{
			$data = $this->getDoctrine()
	        ->getRepository(Products::class)
	        ->findAll();     
	    }
	    
	    else 
	    {  
		    $query = $session->get('products_query', 'all');
		    
		    $em = $this->getDoctrine()->getManager();
			$data = $em->getRepository(Products::class)->findByCategegory($query);    
	    }
	            
		$em = $this->getDoctrine()->getManager();
		$category = $em->getRepository(Category::class)->findCategoryType('product');
        
        return $this->render('products/products.twig', [
            'data' => $data,
            'club_name' => getenv('CLUB_NAME'),
        	'category' => $category,
        	'query' => $query
        ]);
    }

    /**
     * @Route("/product/create", name="product_create")
     * @IsGranted("ROLE_PRODUCT_CREATE")
     */
    public function new(EntityManagerInterface $em, Request $request, TranslatorInterface $translator)
    {
        $form = $this->createForm(ProductFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $em->persist($data);
            $em->flush();
            $id = $data->getId();

            $this->addFlash('success', $data->getName() . ' ' . $translator->trans('flash_message_create'));

            return $this->redirectToRoute('product_id', array('id' => $id));
        }

        return $this->render('products/productForm.html.twig', [
            'form' => $form->createView()
        ]);
    }

    
    /**
     * @Route("/product/{id}", name="product_id")
     * @IsGranted("ROLE_PRODUCT_VIEW")
     */
	public function show(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$data = $em->getRepository(Products::class)->find($id);
		
		if (!$data) {
        	throw $this->createNotFoundException();
    	}

        //Call Log File:
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry');
        $log = $em->find('App\Entity\Products', $id);
        $logs = $repo->getLogEntries($log);
    			        
		return $this->render('products/product.html.twig', [
        	'data' => $data,
            'logs' => $logs,
            'id' => $data->getID()
		]);
	}
    

	
	/**
     * @Route("/product/{id}/edit", name="product_edit")
     * @IsGranted("ROLE_PRODUCT_EDIT")
     */
	public function edit(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
	{
		$em = $this->getDoctrine()->getManager();
		$data = $em->getRepository(Products::class)->find($id);
		
		if (!$data) {
        	throw $this->createNotFoundException();
    	}
		        
        
		$form = $this->createForm(ProductFormType::class, $data);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$data = $form->getData();
			
			$em->persist($data);
			$em->flush();

            $this->addFlash('success', $data->getName() . ' ' . $translator->trans('flash_message_edit'));
			
			return $this->redirectToRoute('product_id', array('id' => $id));
		}
		
		return $this->render('products/productForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $data
		]);
	}
	
	/**
     * @Route("/product/{id}/delete", name="product_delete")
     * @IsGranted("ROLE_PRODUCT_DELETE")
     */
	public function del(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
	{
		$em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Products::class)->find($id);
		
		if (!$data) {
        	throw $this->createNotFoundException();
    	}

			$em->remove($data);
			$em->flush();

        $this->addFlash('warning', $data->getName() . ' ' . $translator->trans('flash_message_delete'));
			
			return $this->redirectToRoute('products');
	}

}