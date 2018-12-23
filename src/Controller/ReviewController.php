<?php

namespace App\Controller;

use App\Entity\Person;
use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ReviewFormType;







class ReviewController extends AbstractController
{
    /**
     * @Route("/person/{id}/review/create", name="app_review_create_person")
     */
     public function newPersonReview(EntityManagerInterface $em, Request $request, $id)
     {
	    //get person object.
	    $em = $this->getDoctrine()->getManager();
		$person = $em->getRepository(Person::class)->find($id);
	    
		//generate Form.
	    $form = $this->createForm(ReviewFormType::class);
		
		//Handle form.
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$review = $form->getData();
			$person->addReview($review);
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($review);
			$em->persist($person);
			$em->flush();

			$this->addFlash('success', 'Notitie aan: '.$person->getFamilyName().', '.$person->getGivenName().' '.$person->getAdditionalName().' toegevoegd!');
			
			return $this->redirectToRoute('app_person', array('id' => $id));			
		}

		return $this->render('review/ReviewPersonCreate.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);
     }
     
	/**
	* @Route("/{entity}/{$entityID}/review/{id}/edit", name="app_review_edit")
	*/
	public function editReview(EntityManagerInterface $em, Request $request, $entity, $entityID, $reviewID)
	{
		$em = $this->getDoctrine()->getManager();
		$review = $em->getRepository(Review::class)->find($reviewID);
		        
        
		$form = $this->createForm(ReviewFormType::class, $review);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$review = $form->getData();
			
			$em->persist($review);
			$em->flush();
           
			$this->addFlash('success', 'Notitie is bijgewerkt!');
			
			return $this->redirectToRoute('app_'.$entity, array('id' => $entityID));			
		}
		
		return $this->render('review/reviewEdit.html.twig', [
        	'form' => $form->createView(),
        	'data' => $review,
        	'entity' => 'app_'.$entity,
        	'entityID' => $entityID
		]);
	}
	
	/**
	* @Route("/{entity}/{$entityID}/review/{reviewID}/delete", name="app_review_delete")
	*/
	public function deleteReview(EntityManagerInterface $em, Request $request, $entity, $entityID, $reviewID)
	{
		
		$em = $this->getDoctrine()->getManager();
		$review = $em->getRepository(Review::class)->find($reviewID);
		        
		$em->remove($review);
		$em->flush();
		
		$this->addFlash('success', 'Notitie is verwijderd!');
		
		return $this->redirectToRoute('app_'.$entity, array('id' => $entityID));	
	}     
}
