<?php

namespace App\Controller;

use App\Entity\MusicalInstrument;
use App\Form\MusicalInstrumentFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

class MusicalInstrumentsController extends AbstractController
{
	/**
     * @Route("/settings/musicalinstrument", name="musical_instrument")
     * @IsGranted("ROLE_SETTINGS_VIEW")
     */
	public function list(EntityManagerInterface $em, Request $request)
	{
		$musicalInstrument = $this->getDoctrine()
        ->getRepository(MusicalInstrument::class)
        ->findAll();

		return $this->render('musical_instruments/musicalInstruments.html.twig', [
        	'data' => $musicalInstrument
		]);
	}
		
	/**
     * @Route("/settings/musicalinstrument/create", name="musical_instrument_create")
     * @IsGranted("ROLE_SETTINGS_CREATE")
     */
	public function new(EntityManagerInterface $em, Request $request, TranslatorInterface $translator)
	{
		$form = $this->createForm(MusicalInstrumentFormType::class);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
						
			$em->persist($data);
			$em->flush();

            $this->addFlash('success', $data->getMusicalInstrument()  . ' ' . $translator->trans('flash_message_create'));
			return $this->redirectToRoute('musical_instrument');
		}
		
		return $this->render('musical_instruments/musicalInstrumentsForm.html.twig', [
        	'form' => $form->createView()
		]);
	}
	
	/**
     * @Route("/settings/musicalinstrument/{id}/edit", name="musical_instrument_edit")
     * @IsGranted("ROLE_SETTINGS_EDIT")
     */
	public function edit(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
	{
		$em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(MusicalInstrument::class)->find($id);
		
		if (!$data) {
        	throw $this->createNotFoundException();
    	}
        
		$form = $this->createForm(MusicalInstrumentFormType::class, $data);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
			$em->persist($data);
			$em->flush();

            $this->addFlash('success', $data->getMusicalInstrument()  . ' ' . $translator->trans('flash_message_edit'));
			
			return $this->redirectToRoute('musical_instrument');
		}
		
		return $this->render('musical_instruments/musicalInstrumentsForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $data
		]);
	}
	
	/**
     * @Route("/settings/musicalinstrument/{id}/delete", name="musical_instrument_delete")
     * @IsGranted("ROLE_SETTINGS_DELETE")
     */
	public function del(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
	{
		$em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(MusicalInstrument::class)->find($id);
		
		if (!$data) {
        	throw $this->createNotFoundException();
    	}

			$em->remove($data);
			$em->flush();

        $this->addFlash('warning', $data->getMusicalInstrument()  . ' ' . $translator->trans('flash_message_delete'));
			
			return $this->redirectToRoute('musical_instrument');
	}
}
