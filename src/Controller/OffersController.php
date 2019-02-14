<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Entity\Service;
use App\Form\OfferFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OffersController extends AbstractController
{
    /**
     * @Route("/service/{id}/offer/create", name="app_offer_create")
     */
	public function new(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$data = $em->getRepository(Service::class)->find($id);    
	    
		
		$form = $this->createForm(OfferFormType::class);
		
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$offer = $form->getData();
			
			//Hier zou je dan eventueel de data naar centen kunnen omzetten
			
			
			$data->addOffer($offer);
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($offer);
			$em->persist($data);
			$em->flush();
					
			$this->addFlash('success', 'Nieuw aanbod is aangemaakt!');
			
			return $this->redirectToRoute('app_service_offer', array('id' => $id));
					
		}
		
		return $this->render('offers/offerForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);
	}
	
	/**
	* @Route("/service/{id}/offer/{offerID}/edit", name="app_offer_create")
	*/
	public function edit(EntityManagerInterface $em, Request $request, $id, $offerID)
	{
		$em = $this->getDoctrine()->getManager();
		$offer = $em->getRepository(Offer::class)->find($offerID);
		        
        
		$form = $this->createForm(OfferFormType::class, $offer);
		
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$offer = $form->getData();
			
			$em->persist($offer);
			$em->flush();
           
			$this->addFlash('success', 'Aanbod is bijgewerkt!');
			
			return $this->redirectToRoute('app_service_offer', array('id' => $id));			
		}
		
		return $this->render('offers/offerForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $offer,
        	'id' => $id
		]);	
	}
		
	/**
	* @Route("/service/{id}/offer/{mofferID}/delete", name="app_offer_delete")
	*/
	public function delete(EntityManagerInterface $em, Request $request, $id, $offerID)
	{
		
		$em = $this->getDoctrine()->getManager();
		$offer = $em->getRepository(Offer::class)->find($offerID);
		        
		$em->remove($offer);
		$em->flush();
		
		$this->addFlash('warning', 'Aanbod is verwijderd!');
		
		return $this->redirectToRoute('app_service_offer', array('id' => $id));	
	}   
}
