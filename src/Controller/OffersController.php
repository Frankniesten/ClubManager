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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

class OffersController extends AbstractController
{
    /**
     * @Route("/service/{id}/offer/create", name="offer_create")
     * @IsGranted("ROLE_SERVICES_CREATE")
     */
	public function new(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
	{
		$em = $this->getDoctrine()->getManager();
		$data = $em->getRepository(Service::class)->find($id);   
		
		if (!$data) {
        	throw $this->createNotFoundException();
    	} 

		$form = $this->createForm(OfferFormType::class);
		
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$offer = $form->getData();
			$data->addOffer($offer);
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($offer);
			$em->persist($data);
			$em->flush();

            $this->addFlash('succes', $offer->getItemOffered(). ' ' . $translator->trans('flash_message_create'));
			
			return $this->redirectToRoute('service_id', array('id' => $id));
		}
		
		return $this->render('services/service-offerForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);
	}
	
	/**
	* @Route("/service/{id}/offer/{offerID}/edit", name="offer_edit")
	* @IsGranted("ROLE_SERVICES_EDIT")
	*/
	public function edit(EntityManagerInterface $em, Request $request, $id, $offerID, TranslatorInterface $translator)
	{
		$em = $this->getDoctrine()->getManager();
		$offer = $em->getRepository(Offer::class)->find($offerID);
		        
        if (!$offer) {
        	throw $this->createNotFoundException();
    	}
    	
		$form = $this->createForm(OfferFormType::class, $offer);
		
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$offer = $form->getData();
			
			$em->persist($offer);
			$em->flush();

            $this->addFlash('succes', $offer->getItemOffered(). ' ' . $translator->trans('flash_message_edit'));
			
			return $this->redirectToRoute('service_id', array('id' => $id));
		}
		
		return $this->render('services/service-offerForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $offer,
        	'id' => $id
		]);	
	}
		
	/**
	* @Route("/service/{id}/offer/{offerID}/delete", name="offer_delete")
	* @IsGranted("ROLE_SERVICES_DELETE")
	*/
	public function delete(EntityManagerInterface $em, Request $request, $id, $offerID, TranslatorInterface $translator)
	{
		
		$em = $this->getDoctrine()->getManager();
		$offer = $em->getRepository(Offer::class)->find($offerID);
		
		if (!$offer) {
        	throw $this->createNotFoundException();
    	}
		        
		$em->remove($offer);
		$em->flush();

        $this->addFlash('warning', $offer->getItemOffered(). ' ' . $translator->trans('flash_message_delete'));
		
		return $this->redirectToRoute('service_id', array('id' => $id));
	}   
}
