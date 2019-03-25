<?php

namespace App\Controller;

use App\Entity\Person;
use App\Entity\Organization;
use App\Entity\Products;
use App\Entity\Review;
use App\Entity\Service;
use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ReviewFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class ReviewController extends AbstractController
{
    /**
	* @Route("/{entity}/{id}/review/create", name="app_person_review_create")
	* @IsGranted("ROLE_REVIEW_CREATE")
	*/
	public function new (EntityManagerInterface $em, Request $request, $entity, $id)
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
	    if ($entity == 'product') 
	    {
		    $data = $em->getRepository(Products::class)->find($id);    
	    }
	    if ($entity == 'event') 
	    {
		    $data = $em->getRepository(Event::class)->find($id);    
	    }
	    if ($entity == 'service') 
	    {
		    $data = $em->getRepository(Service::class)->find($id);    
	    }
	    
	    if (!$data) {
        	throw $this->createNotFoundException('The product does not exist');
    	}
	    
	    $form = $this->createForm(ReviewFormType::class);
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$review = $form->getData();
			$data->addReview($review);
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($review);
			$em->persist($data);
			$em->flush();
			
			$this->addFlash('success', 'Notitie is toegevoegd!');
			
			if ($entity == 'person') 
		    {
			    return $this->redirectToRoute('app_person', array('id' => $id));    
		    }
		    if ($entity == 'organization') 
		    {
			    return $this->redirectToRoute('app_organization', array('id' => $id));    
		    }	
		    if ($entity == 'product') 
		    {
			    return $this->redirectToRoute('app_product', array('id' => $id));    
		    }
		    if ($entity == 'event') 
		    {
			    return $this->redirectToRoute('app_event', array('id' => $id));    
		    }
		    if ($entity == 'service') 
		    {
			    return $this->redirectToRoute('app_service', array('id' => $id));    
		    }					
		}
		
		return $this->render('review/ReviewForm.html.twig', [
	    	'form' => $form->createView(),
	    	'id' => $id
		]);
	}
	

	/**
	* @Route("/{entity}/{id}/review/{reviewID}/edit", name="app_review_edit")
	* @IsGranted("ROLE_REVIEW_EDIT")
	*/
	public function edit(EntityManagerInterface $em, Request $request, $entity, $id, $reviewID)
	{
		$em = $this->getDoctrine()->getManager();
		$review = $em->getRepository(Review::class)->find($reviewID);
		
		if (!$review) {
        	throw $this->createNotFoundException('The product does not exist');
    	}
		        
		$form = $this->createForm(ReviewFormType::class, $review);
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$review = $form->getData();
			
			$em->persist($review);
			$em->flush();
           
			$this->addFlash('success', 'Notitie is bijgewerkt!');
			
			if ($entity == 'person') 
		    {
			    return $this->redirectToRoute('app_person', array('id' => $id));    
		    }
		    if ($entity == 'organization') 
		    {
			    return $this->redirectToRoute('app_organization', array('id' => $id));    
		    }
		    if ($entity == 'product') 
		    {
			    return $this->redirectToRoute('app_product', array('id' => $id));    
		    }
		    if ($entity == 'event') 
		    {
			    return $this->redirectToRoute('app_event', array('id' => $id));    
		    }
		    if ($entity == 'service') 
		    {
			    return $this->redirectToRoute('app_service', array('id' => $id));    
		    }			
		}
		
		return $this->render('review/reviewForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $review,
        	'id' => $id,
        	'entity' => $entity,
        	'reviewID' => $reviewID
		]);
	}
	
	/**
	* @Route("/{entity}/{id}/review/{reviewID}/delete", name="app_review_delete")
	* @IsGranted("ROLE_REVIEW_DELETE")
	*/
	public function delete(EntityManagerInterface $em, Request $request, $entity, $id, $reviewID)
	{
		
		$em = $this->getDoctrine()->getManager();
		$review = $em->getRepository(Review::class)->find($reviewID);
		
		if (!$review) {
        	throw $this->createNotFoundException('The product does not exist');
    	}
		        
		$em->remove($review);
		$em->flush();
		
		$this->addFlash('success', 'Notitie is verwijderd!');
		
		if ($entity == 'person') 
	    {
		    return $this->redirectToRoute('app_person', array('id' => $id));    
	    }
	    if ($entity == 'product') 
	    {
		    return $this->redirectToRoute('app_product', array('id' => $id));    
	    }	
	    if ($entity == 'organization') 
	    {
		    return $this->redirectToRoute('app_organization', array('id' => $id));    
	    }	
	    if ($entity == 'service') 
	    {
		    return $this->redirectToRoute('app_service', array('id' => $id));    
	    }	
	    if ($entity == 'event') 
	    {
		    return $this->redirectToRoute('app_event', array('id' => $id));    
	    }	
	}     
}
