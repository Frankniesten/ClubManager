<?php

namespace App\Controller;

use App\Entity\Products;
use App\Entity\Person;
use App\Entity\Category;
use App\Form\ProductFormType;
use App\Entity\OwnershipInfo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ProductsController extends AbstractController
{
    /**
     * @Route("/products", name="app_products")
     * @IsGranted("ROLE_PRODUCT_VIEW")
     */
    public function list(EntityManagerInterface $em, Request $request)
    {
	    $query = $request->query->get('query');
    	
    	if ($query == null) {
    
			$products = $this->getDoctrine()
	        ->getRepository(Products::class)
	        ->findAll();    
	    }
	    
	    else {
		    
		    $em = $this->getDoctrine()->getManager();
			$products = $em->getRepository(Products::class)->findByCategegory($query);
		        
	    }
        
		$em = $this->getDoctrine()->getManager();
		$category = $em->getRepository(Category::class)->findCategoryType('product');
        
        return $this->render('products/products.twig', [
            'controller_name' => 'OrganizationsController',
            'data' => $products,
        	'category' => $category,
        	'query' => $query
        ]);
    }
    
    /**
     * @Route("/product/{id}", name="app_product")
     * @IsGranted("ROLE_PRODUCT_VIEW")
     */
	public function show(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$products = $em->getRepository(Products::class)->find($id);
		
		if (!$products) {
        	throw $this->createNotFoundException('The product does not exist');
    	}
    			        
		return $this->render('products/product.html.twig', [
        	'data' => $products
		]);
	}
    
    /**
     * @Route("/product/create", name="app_product_create")
     * @IsGranted("ROLE_PRODUCT_CREATE")
     */
	public function new(EntityManagerInterface $em, Request $request)
	{
		$form = $this->createForm(ProductFormType::class);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$products = $form->getData();
			
			$em->persist($products);
			$em->flush();
			$id = $products->getId();
           
			$this->addFlash('success', $products->getName(). ' is nieuw toegevoegd!');
			
			return $this->redirectToRoute('app_product', array('id' => $id));			
		}
		
		return $this->render('products/productForm.html.twig', [
        	'form' => $form->createView()
		]);
	}
	
	/**
     * @Route("/organization/{id}/edit", name="app_organization_edit")
     * @IsGranted("ROLE_PRODUCT_EDIT")
     */
	public function edit(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$products = $em->getRepository(Products::class)->find($id);
		
		if (!$products) {
        	throw $this->createNotFoundException('The product does not exist');
    	}
		        
        
		$form = $this->createForm(ProductFormType::class, $products);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$products = $form->getData();
			
			$em->persist($products);
			$em->flush();
           
			$this->addFlash('success', $products->getName(). ' is bijgewerkt!');
			
			return $this->redirectToRoute('app_product', array('id' => $id));			
		}
		
		return $this->render('products/productForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $products
		]);
	}
	
	/**
     * @Route("/product/{id}/delete", name="product_delete")
     * @IsGranted("ROLE_PRODUCT_DELETE")
     */
	public function del(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$products = $em->getRepository(Products::class)->find($id);
		
		if (!$products) {
        	throw $this->createNotFoundException('The product does not exist');
    	}

			$em->remove($products);
			$em->flush();
           
			$this->addFlash('success', 'Het product is verwijderd!');
			
			return $this->redirectToRoute('app_products');			
	}

}