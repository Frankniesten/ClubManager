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
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ReviewFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;


class ReviewController extends AbstractController
{
    /**
	* @Route("/{entity}/{id}/review/create", name="review_create")
	*/
	public function new (EntityManagerInterface $em, Request $request, $entity, $id, TranslatorInterface $translator)
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
        	throw $this->createNotFoundException();
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
			
			$this->addFlash('success', $review->getReviewAspect() . ' ' . $translator->trans('flash_message_create'));
			
			if ($entity == 'person') 
		    {
			    return $this->redirectToRoute('person_id', array('id' => $id, '_fragment' => 'review'));
		    }
		    if ($entity == 'organization') 
		    {
			    return $this->redirectToRoute('organization_id', array('id' => $id, '_fragment' => 'review'));
		    }	
		    if ($entity == 'product') 
		    {
			    return $this->redirectToRoute('product_id', array('id' => $id, '_fragment' => 'review'));
		    }
		    if ($entity == 'event') 
		    {
			    return $this->redirectToRoute('event_id', array('id' => $id, '_fragment' => 'review'));
		    }
		    if ($entity == 'service') 
		    {
			    return $this->redirectToRoute('service_id', array('id' => $id, '_fragment' => 'review'));
		    }					
		}
		
		return $this->render('global/reviewForm.html.twig', [
	    	'form' => $form->createView(),
	    	'id' => $id
		]);
	}
	

	/**
	* @Route("/{entity}/{id}/review/{reviewID}/edit", name="review_edit")
	*/
	public function edit(EntityManagerInterface $em, Request $request, $entity, $id, $reviewID, TranslatorInterface $translator)
	{
		$em = $this->getDoctrine()->getManager();
		$review = $em->getRepository(Review::class)->find($reviewID);
		
		if (!$review) {
        	throw $this->createNotFoundException();
    	}
		        
		$form = $this->createForm(ReviewFormType::class, $review);
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$review = $form->getData();
			
			$em->persist($review);
			$em->flush();
           
			$this->addFlash('success', $review->getReviewAspect() . ' ' . $translator->trans('flash_message_edit'));
			
			if ($entity == 'person') 
		    {
			    return $this->redirectToRoute('person_id', array('id' => $id, '_fragment' => 'review'));
            }
		    if ($entity == 'organization') 
		    {
			    return $this->redirectToRoute('organization_id', array('id' => $id, '_fragment' => 'review'));
            }
		    if ($entity == 'product') 
		    {
			    return $this->redirectToRoute('product_id', array('id' => $id, '_fragment' => 'review'));
		    }
		    if ($entity == 'event') 
		    {
			    return $this->redirectToRoute('event_id', array('id' => $id, '_fragment' => 'review'));
		    }
		    if ($entity == 'service') 
		    {
			    return $this->redirectToRoute('service_id', array('id' => $id, '_fragment' => 'review'));
		    }			
		}
		
		return $this->render('global/reviewForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $review,
        	'id' => $id,
        	'entity' => $entity,
        	'reviewID' => $reviewID
		]);
	}
	
	/**
	* @Route("/{entity}/{id}/review/{reviewID}/delete", name="review_delete")
	* @IsGranted("ROLE_REVIEW_DELETE")
	*/
	public function delete(EntityManagerInterface $em, Request $request, $entity, $id, $reviewID, TranslatorInterface $translator)
	{
		
		$em = $this->getDoctrine()->getManager();
		$review = $em->getRepository(Review::class)->find($reviewID);
		
		if (!$review) {
        	throw $this->createNotFoundException();
    	}
		        
		$em->remove($review);
		$em->flush();
		
		$this->addFlash('warning', $review->getReviewAspect() . ' ' . $translator->trans('flash_message_delete'));
		
		if ($entity == 'person') 
	    {
		    return $this->redirectToRoute('person_id', array('id' => $id, '_fragment' => 'review'));
	    }
	    if ($entity == 'product') 
	    {
		    return $this->redirectToRoute('product_id', array('id' => $id, '_fragment' => 'review'));
	    }	
	    if ($entity == 'organization') 
	    {
		    return $this->redirectToRoute('organization_id', array('id' => $id, '_fragment' => 'review'));
	    }	
	    if ($entity == 'service') 
	    {
		    return $this->redirectToRoute('service_id', array('id' => $id, '_fragment' => 'review'));
	    }	
	    if ($entity == 'event') 
	    {
		    return $this->redirectToRoute('event_id', array('id' => $id, '_fragment' => 'review'));
	    }	
	}     
}
