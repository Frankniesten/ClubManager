<?php

namespace App\Controller;

use App\Entity\PostalAddress;
use App\Form\PostalAddressFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

class PostalAddressController extends AbstractController
{
    /**
     * @Route("/postaladdress", name="postaladdress")
     * @IsGranted("ROLE_EVENT_VIEW")
     */
	public function list(EntityManagerInterface $em, Request $request)
	{
		$data = $this->getDoctrine()
        ->getRepository(PostalAddress::class)
        ->findAll();
		
		return $this->render('postal_address/postaladdresses.html.twig', [
        	'data' => $data
		]);
	}

	/**
     * @Route("/postaladdress/create", name="postaladdress_create")
     * @IsGranted("ROLE_EVENT_CREATE")
     */
	public function new(EntityManagerInterface $em, Request $request, TranslatorInterface $translator)
	{
		
		$form = $this->createForm(PostalAddressFormType::class);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$data = $form->getData();
						
			$em->persist($data);
			$em->flush();

            $this->addFlash('success', $data->getVenue() . ' ' . $translator->trans('flash_message_create'));
			
			return $this->redirectToRoute('postaladdress');
		}
		
		return $this->render('postal_address/postaladdressForm.html.twig', [
        	'form' => $form->createView()
		]);
	}
	
	/**
     * @Route("/postaladdress/{id}/edit", name="postaladdress_edit")
     * @IsGranted("ROLE_EVENT_EDIT")
     */
	public function edit(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
	{
		$em = $this->getDoctrine()->getManager();
		$data = $em->getRepository(PostalAddress::class)->find($id);
		
		if (!$data) {
        	throw $this->createNotFoundException();
    	}

		$form = $this->createForm(PostalAddressFormType::class, $data);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$data = $form->getData();
			
			$em->persist($data);
			$em->flush();

            $this->addFlash('success', $data->getVenue() . ' ' . $translator->trans('flash_message_edit'));
			
			return $this->redirectToRoute('postaladdress');
		}
		
		return $this->render('postal_address/postaladdressForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $data
		]);
	}
	
	/**
     * @Route("/postaladdress/{id}/delete", name="postaladdress_delete")
     * @IsGranted("ROLE_EVENT_DELETE")
     */
	public function delete(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
	{
		$em = $this->getDoctrine()->getManager();
		$data = $em->getRepository(PostalAddress::class)->find($id);
		
		if (!$data) {
        	throw $this->createNotFoundException();
    	}
			$em->remove($data);
			$em->flush();

        $this->addFlash('warning', $data->getVenue() . ' ' . $translator->trans('flash_message_delete'));
			
			return $this->redirectToRoute('postaladdress');
	}
}
