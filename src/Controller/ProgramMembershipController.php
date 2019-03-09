<?php

namespace App\Controller;

use App\Entity\ProgramMembership;
use App\Form\ProgramMembershipFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
 
class ProgramMembershipController extends AbstractController
{
	
    /**
     * @Route("/programmemberships", name="program_memberships")
     * @IsGranted("ROLE_SETTINGS_VIEW")
     */
	public function list(EntityManagerInterface $em, Request $request)
	{
		$programMembership = $this->getDoctrine()
        ->getRepository(ProgramMembership::class)
        ->findAll();
		
				
		return $this->render('programMemberships/programMemberships.html.twig', [
        	'data' => $programMembership
		]);
	}
	
	
	/**
     * @Route("/settings/programmembership/create", name="program_memberships_create")
     * @IsGranted("ROLE_SETTINGS_CREATE")
     */
	public function new(EntityManagerInterface $em, Request $request)
	{
		
		$form = $this->createForm(ProgramMembershipFormType::class);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$programMembership = $form->getData();
						
			$em->persist($programMembership);
			$em->flush();
           
			$this->addFlash('success', 'Rol: '.$programMembership->getProgramName().' is toegevoegd!');
			
			return $this->redirectToRoute('app_settings_program_memberships');			
		}
		
		return $this->render('programMemberships/programMembershipsForm.html.twig', [
        	'form' => $form->createView()
		]);
	}
	
	
	/**
     * @Route("/settings/programmembership/{id}/edit", name="programmembership_edit")
     * @IsGranted("ROLE_SETTINGS_EDIT")
     */
	public function edit(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$programMembership = $em->getRepository(ProgramMembership::class)->find($id);
		        
        
		$form = $this->createForm(ProgramMembershipFormType::class, $programMembership);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$programMembership = $form->getData();
			
			$em->persist($programMembership);
			$em->flush();
           
			$this->addFlash('success', 'Rol: '.$programMembership->getProgramName().' is bijgewerkt!');
			
			return $this->redirectToRoute('app_settings_program_memberships');			
		}
		
		return $this->render('programMemberships/programMembershipsForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $programMembership
		]);
	}
	
	
	/**
     * @Route("/settings/programmembership/{id}/delete", name="programmembership_delete")
     * @IsGranted("ROLE_SETTINGS_DELETE")
     */
	public function del(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$programMembership = $em->getRepository(ProgramMembership::class)->find($id);

			$em->remove($programMembership);
			$em->flush();
           
			$this->addFlash('warning', 'De rol is verwijderd!');
			
			return $this->redirectToRoute('app_settings_program_memberships');			
	}


}
