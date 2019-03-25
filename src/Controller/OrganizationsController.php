<?php

namespace App\Controller;

use App\Entity\Organization;
use App\Entity\Category;
use App\Form\OrganizationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class OrganizationsController extends AbstractController
{
    /**
     * @Route("/organizations", name="organizations")
     * @IsGranted("ROLE_ORGANIZATION_VIEW")
     */
    public function list(EntityManagerInterface $em, Request $request)
    {
	    $query = $request->query->get('query');
    	
    	if ($query == null) {
    
			$organizations = $this->getDoctrine()
	        ->getRepository(Organization::class)
	        ->findAll();    
	    }
	    
	    else {
		    
		    $em = $this->getDoctrine()->getManager();
			$organizations = $em->getRepository(Organization::class)->findByCategegory($query);
		        
	    }
        
		$em = $this->getDoctrine()->getManager();
		$category = $em->getRepository(Category::class)->findCategoryType('organization');
        
        return $this->render('organizations/organizations.html.twig', [
            'data' => $organizations,
        	'category' => $category,
        	'query' => $query
        ]);
    }
    
    
    /**
     * @Route("/organization/create", name="app_organization_create")
     * @IsGranted("ROLE_ORGANIZATION_CREATE")
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
		
		return $this->render('organizations/organizationForm.html.twig', [
        	'form' => $form->createView()
		]);
	}
	
	
	/**
     * @Route("/organization/{id}", name="app_organization")
     * @IsGranted("ROLE_ORGANIZATION_VIEW")
     */
	public function show(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$organization = $em->getRepository(Organization::class)->find($id);
		
		if (!$organization) {
        	throw $this->createNotFoundException('The product does not exist');
    	} 
		        
		return $this->render('organizations/organization.html.twig', [
        	'data' => $organization
		]);
	}
	
	
	/**
     * @Route("/organization/{id}/edit", name="app_organization_edit")
     * @IsGranted("ROLE_ORGANIZATION_EDIT")
     */
	public function edit(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$organization = $em->getRepository(Organization::class)->find($id);
		    
		if (!$organization) {
        	throw $this->createNotFoundException('The product does not exist');
    	}     
        
		$form = $this->createForm(OrganizationFormType::class, $organization);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$organization = $form->getData();
			
			$em->persist($organization);
			$em->flush();
           
			$this->addFlash('success', $organization->getLegalName(). ' is bijgewerkt!');
			
			return $this->redirectToRoute('app_organization', array('id' => $id));			
		}
		
		return $this->render('organizations/organizationForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $organization
		]);
	}
	
	/**
     * @Route("/organization/{id}/delete", name="organization_delete")
     * @IsGranted("ROLE_ORGANIZATION_DELETE")
     */
	public function del(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$organization = $em->getRepository(Organization::class)->find($id);
		
		if (!$organization) {
        	throw $this->createNotFoundException('The product does not exist');
    	} 

			$em->remove($organization);
			$em->flush();
           
			$this->addFlash('success', 'De organisatie is verwijderd!');
			
			return $this->redirectToRoute('app_organizations');			
	}



}