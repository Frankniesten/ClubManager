<?php

namespace App\Controller;

use App\Entity\OwnershipInfo;
use App\Entity\Product;
use App\Entity\Person;
use App\Entity\Organization;
use App\Form\OwnsFormType;
use App\Form\OwnsEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ProductsOnLoan;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class OwnsController extends AbstractController
{
	/**
     * @Route("/{entity}/{id}/owns/create", name="app_owns_create")
     * @IsGranted("ROLE_PRODUCT_CREATE")
     */
	public function new(EntityManagerInterface $em, ProductsOnLoan $productsOnLoan, Request $request, $entity, $id)
	{
		$em = $this->getDoctrine()->getManager();
		
		if ($entity == 'person') 
	    {
		    $data = $em->getRepository(Person::class)->find($id);    
	    }
	    if ($entity == 'organization') 
	    {
		    $data = $em->getRepository(Organization::class)->find($id);    
	    }
		
		$form = $this->createForm(OwnsFormType::class);
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$owns = $form->getData();
			$data->addOwn($owns);
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($owns);
			$em->persist($data);
			$em->flush();
					
			$this->addFlash('success', 'Nieuw product in bruikleen is aangemaakt!');
			
			//Process products in loan
			$loan = $productsOnLoan->processProduct($owns->getTypeofGood()->getId());
			
			if ($entity == 'person') 
		    {
			    return $this->redirectToRoute('app_person_owns', array('id' => $id));    
		    }
		    if ($entity == 'organization') 
		    {
			    return $this->redirectToRoute('app_organization_owns', array('id' => $id));    
		    }			
		}
		
		return $this->render('owns/ownsForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);
	}
	
	
	/**
	* @Route("/{entity}/{id}/owns/{ownershipInfoID}/edit", name="app_person_owns_edit")
	* @IsGranted("ROLE_PRODUCT_EDIT")
	*/
	public function edit(EntityManagerInterface $em, ProductsOnLoan $productsOnLoan, Request $request, $entity, $id, $ownershipInfoID)
	{
		$em = $this->getDoctrine()->getManager();
		$owns = $em->getRepository(OwnershipInfo::class)->find($ownershipInfoID);
		        
        
		$form = $this->createForm(OwnsEditFormType::class, $owns);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$owns = $form->getData();
			
			$em->persist($owns);
			$em->flush();
			
			//Process products in loan
			$productID = $owns->getTypeofGood()->getId();
			$loan = $productsOnLoan->processProduct($productID);
           
			$this->addFlash('success', 'Product in bruikleen is bijgewerkt!');
			
			if ($entity == 'person') 
		    {
			    return $this->redirectToRoute('app_person_owns', array('id' => $id));    
		    }
		    if ($entity == 'organization') 
		    {
			    return $this->redirectToRoute('app_organization_owns', array('id' => $id));    
		    }				
		}
		
		return $this->render('owns/ownsEditForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $owns,
        	'id' => $id
		]);
	}


	/**
	* @Route("/{entity}/{id}/owns/{ownershipInfoID}/delete", name="app_person_owns_delete")
	* @IsGranted("ROLE_PRODUCT_DELETE")
	*/
	public function delete(EntityManagerInterface $em, ProductsOnLoan $productsOnLoan, Request $request, $entity, $id, $ownershipInfoID)
	{
		
		$em = $this->getDoctrine()->getManager();
		$owns = $em->getRepository(OwnershipInfo::class)->find($ownershipInfoID);
		        
		$em->remove($owns);
		$em->flush();
		
		//Process products in loan
		$productID = $owns->getTypeofGood()->getId();
		$loan = $productsOnLoan->processProduct($productID);
		
		$this->addFlash('warning', 'Product in bruikleen is verwijderd!');
		
		if ($entity == 'person') 
	    {
		    return $this->redirectToRoute('app_person_owns', array('id' => $id));    
	    }
	    if ($entity == 'organization') 
	    {
		    return $this->redirectToRoute('app_organization_owns', array('id' => $id));    
	    }		
	} 
}