<?php

namespace App\Controller;

use App\Entity\PostalAddress;
use App\Form\PostalAddressFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class PostalAddressController extends AbstractController
{
    /**
     * @Route("/settings/postaladdresses", name="app_settings_postaladdresses")
     * @IsGranted("ROLE_SETTINGS_VIEW")
     */
	public function list(EntityManagerInterface $em, Request $request)
	{
		$musicalInstrument = $this->getDoctrine()
        ->getRepository(PostalAddress::class)
        ->findAll();
		
				
		return $this->render('postal_address/postaladdresses.html.twig', [
        	'data' => $musicalInstrument
		]);
	}
	
	
	/**
     * @Route("/settings/postaladdress/create", name="app_settings_postaladdress_create")
     * @IsGranted("ROLE_SETTINGS_CREATE")
     */
	public function new(EntityManagerInterface $em, Request $request)
	{
		
		$form = $this->createForm(PostalAddressFormType::class);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$postalAddress = $form->getData();
						
			$em->persist($postalAddress);
			$em->flush();
           
			$this->addFlash('success', 'Event locatie: '.$postalAddress->getVenue().' is toegevoegd!');
			
			return $this->redirectToRoute('app_settings_postaladdresses');			
		}
		
		return $this->render('postal_address/postaladdressForm.html.twig', [
        	'form' => $form->createView()
		]);
	}
	
	/**
     * @Route("/settings/postaladdress/{id}/edit", name="app_settings_postaladdress_edit")
     * @IsGranted("ROLE_SETTINGS_EDIT")
     */
	public function edit(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$postalAddress = $em->getRepository(PostalAddress::class)->find($id);
		
		if (!$postalAddress) {
        	throw $this->createNotFoundException('Event locatie bestaat niet.');
    	}
		        
        
		$form = $this->createForm(PostalAddressFormType::class, $postalAddress);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$postalAddress = $form->getData();
			
			$em->persist($postalAddress);
			$em->flush();
           
			$this->addFlash('success', 'Event locatie: '.$postalAddress->getVenue().' is bijgewerkt!');
			
			return $this->redirectToRoute('app_settings_postaladdresses');			
		}
		
		return $this->render('postal_address/postaladdressForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $postalAddress
		]);
	}
	
	/**
     * @Route("/settings/postaladdress/{id}/delete", name="app_settings_postaladdress_delete")
     * @IsGranted("ROLE_SETTINGS_DELETE")
     */
	public function delete(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$postalAddress = $em->getRepository(PostalAddress::class)->find($id);
		
		if (!$postalAddress) {
        	throw $this->createNotFoundException('Event locatie bestaat niet.');
    	}

			$em->remove($postalAddress);
			$em->flush();
           
			$this->addFlash('warning', 'De event locatie is verwijderd!');
			
			return $this->redirectToRoute('app_settings_postaladdresses');			
	}
}
