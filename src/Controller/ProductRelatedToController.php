<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ProductIsRelatedToFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductRelatedToController extends AbstractController
{
	
    /**
    * @Route("/product/{id}/isrelatedto/edit", name="app_product_isRelatedTo_edit")
    */
    public function edit(EntityManagerInterface $em, Request $request, $id)
    {
	    //get product object.
	    $em = $this->getDoctrine()->getManager();
		$products = $em->getRepository(Products::class)->find($id);
	    
	    
	    
	    
	    
	    
	    
		//generate Form.
	    $form = $this->createForm(ProductIsRelatedToFormType::class, $products, array('productId' => $id));
		
		//Handle form.
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$products = $form->getData();
			
			$em->persist($products);
			$em->flush();
           
			//$this->addFlash('success', 'Rol bij: '.$person->getFamilyName().', '.$person->getGivenName().' '.$person->getAdditionalName().'aangepast!');
					
			return $this->redirectToRoute('app_product_isRelatedTo', array('id' => $id));			
		}

		return $this->render('product_related_to/isrelatedtoForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);	
	}
}
