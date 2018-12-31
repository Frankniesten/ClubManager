<?php

namespace App\Controller;

use App\Entity\MusicalInstrument;
use App\Form\MusicalInstrumentFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
 
class MusicalInstrumentsController extends AbstractController
{
	/**
	     * @Route("/settings/musicalinstruments", name="musical_instruments")
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
     * @Route("/settings/musicalinstrument/create", name="musical_instrument")
     */
	public function new(EntityManagerInterface $em, Request $request)
	{
		
		$form = $this->createForm(MusicalInstrumentFormType::class);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$musicalInstrument = $form->getData();
						
			$em->persist($musicalInstrument);
			$em->flush();
           
			$this->addFlash('success', 'Het nieuwe muziekinstrument is opgeslagen!');
			
			return $this->redirectToRoute('app_settings_musical_instruments');			
		}
		
		return $this->render('musical_instruments/musicalInstrumentsCreate.html.twig', [
        	'form' => $form->createView()
		]);
	}
	
	/**
     * @Route("/settings/musicalinstrument/{id}/edit", name="musical_instrument")
     */
	public function edit(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$musicalInstrument = $em->getRepository(MusicalInstrument::class)->find($id);
		        
        
		$form = $this->createForm(MusicalInstrumentFormType::class, $musicalInstrument);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$musicalInstrument = $form->getData();
			
			$em->persist($musicalInstrument);
			$em->flush();
           
			$this->addFlash('success', 'Het muziekinstrument is aangepast!');
			
			return $this->redirectToRoute('app_settings_musical_instruments');			
		}
		
		return $this->render('musical_instruments/musicalInstrumentsEdit.html.twig', [
        	'form' => $form->createView(),
        	'data' => $musicalInstrument
		]);
	}
	
	/**
     * @Route("/settings/musicalinstrument/{id}/delete", name="musical_instrument")
     */
	public function del(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$musicalInstrument = $em->getRepository(MusicalInstrument::class)->find($id);

			$em->remove($musicalInstrument);
			$em->flush();
           
			$this->addFlash('success', 'Het muziekinstrument is verwijderd!');
			
			return $this->redirectToRoute('app_settings_musical_instruments');			
	}


}
