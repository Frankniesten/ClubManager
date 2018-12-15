<?php

namespace App\Controller;

use App\Entity\Organization;
use App\Form\OrganizationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MessageGenerator;


class OrganizationsController extends AbstractController
{
    /**
     * @Route("/organizations", name="organizations")
     */
    public function list(EntityManagerInterface $em, Request $request)
    {
	    $organizations = $this->getDoctrine()
        ->getRepository(Organization::class)
        ->findAll();
        
        return $this->render('organizations/organizations.html.twig', [
            'controller_name' => 'OrganizationsController',
            'data' => $organizations
        ]);
    }
    
    
    /**
     * @Route("/porganization/create", name="app_organization_create")
     */
	public function new(EntityManagerInterface $em, Request $request)
	{
		$form = $this->createForm(OrganizationFormType::class);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$organization = $form->getData();
			
			$em->persist($organization);
			$em->flush();
			$id = $organization->getId();
           
			$this->addFlash('success', $organization->getLegalName(). ' is nieuw toegevoegd!');
			
			return $this->redirectToRoute('app_organization', array('id' => $id));			
		}
		
		return $this->render('organizations/organizationCreate.html.twig', [
        	'form' => $form->createView()
		]);
	}
	
	
	/**
     * @Route("/organization/{id}", name="app_organization")
     */
	public function show(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$organization = $em->getRepository(Organization::class)->find($id);
		        
		return $this->render('organizations/organization.html.twig', [
        	'data' => $organization
		]);
	}
	
	
	/**
     * @Route("/organization/{id}/edit", name="app_organization_edit")
     */
	public function edit(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$organization = $em->getRepository(Organization::class)->find($id);
		        
        
		$form = $this->createForm(OrganizationFormType::class, $organization);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$organization = $form->getData();
			
			$em->persist($organization);
			$em->flush();
           
			$this->addFlash('success', $organization->getLegalName(). ' is bijgewerkt!');
			
			return $this->redirectToRoute('app_organization', array('id' => $id));			
		}
		
		return $this->render('organizations/organizationEdit.html.twig', [
        	'form' => $form->createView(),
        	'data' => $organization
		]);
	}
	
	/**
     * @Route("/organization/{id}/delete", name="organization_delete")
     */
	public function del(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$organization = $em->getRepository(Organization::class)->find($id);

			$em->remove($organization);
			$em->flush();
           
			$this->addFlash('success', 'De organisatie is verwijderd!');
			
			return $this->redirectToRoute('app_organizations');			
	}



}