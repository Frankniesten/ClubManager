<?php

namespace App\Controller;

use App\Entity\Organization;
use App\Entity\Category;
use App\Form\OrganizationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;


class OrganizationController extends AbstractController
{
    /**
     * @Route("/organization", name="organization")
     * @IsGranted("ROLE_PERSON_VIEW")
     */
    public function list(SessionInterface $session, EntityManagerInterface $em, Request $request, TranslatorInterface $translator)
    {
        $query = null;

	    //Check categorie:       
	    if ($query = $request->query->get('category'))
	    {
		    $session->set('organization_query', $query);
	    }
	    
	    else 
	    {
		    $query = $session->get('organization_query', 'all');
	    }
    	
    	if ($query == 'all') 
    	{
			$data = $this->getDoctrine()
	        ->getRepository(Organization::class)
	        ->findAll();     
	    }
	    
	    else 
	    {
		    $query = $session->get('organization_query', 'all');
		    $em = $this->getDoctrine()->getManager();
			$data = $em->getRepository(Organization::class)->findByCategegory($query);		        
	    }
	    
		$em = $this->getDoctrine()->getManager();
		$category = $em->getRepository(Category::class)->findCategoryType('organization');
        
        return $this->render('organization/organizations.html.twig', [
            'data' => $data,
            'club_name' => getenv('CLUB_NAME'),
        	'category' => $category,
        	'query' => $query
        ]);
    }
    
    /**
     * @Route("/organization/create", name="organization_create")
     * @IsGranted("ROLE_PERSON_CREATE")
     */
	public function create(EntityManagerInterface $em, Request $request, TranslatorInterface $translator)
	{
		$form = $this->createForm(OrganizationFormType::class);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
			
			$em->persist($data);
			$em->flush();
			$id = $data->getId();

            $this->addFlash('success', $data->getLegalName(). ' ' . $translator->trans('flash_message_create'));
			
			return $this->redirectToRoute('organization', array('id' => $id));
		}
		
		return $this->render('organization/organizationForm.html.twig', [
        	'form' => $form->createView()
		]);
	}
	
	/**
     * @Route("/organization/{id}", name="organization_id")
     * @IsGranted("ROLE_PERSON_VIEW")
     */
	public function show(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
	{
		$em = $this->getDoctrine()->getManager();
		$organization = $em->getRepository(Organization::class)->find($id);
		
		if (!$organization) {
        	throw $this->createNotFoundException();
    	}

        //Call Log File:
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry');
        $log = $em->find('App\Entity\Organization', $id);
        $logs = $repo->getLogEntries($log);
		        
		return $this->render('organization/organization.html.twig', [
        	'data' => $organization,
            'logs' => $logs
		]);
	}
	
	/**
     * @Route("/organization/{id}/edit", name="organization_edit")
     * @IsGranted("ROLE_PERSON_EDIT")
     */
	public function edit(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
	{
		$em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Organization::class)->find($id);
		    
		if (!$data) {
        	throw $this->createNotFoundException();
    	}     
        
		$form = $this->createForm(OrganizationFormType::class, $data);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
			$em->persist($data);
			$em->flush();

            $this->addFlash('success', $data->getLegalName(). ' ' . $translator->trans('flash_message_edit'));
			
			return $this->redirectToRoute('organization_id', array('id' => $id));
		}
		
		return $this->render('organization/organizationForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $data
		]);
	}
	
	/**
     * @Route("/organization/{id}/delete", name="organization_delete")
     * @IsGranted("ROLE_PERSON_DELETE")
     */
	public function del(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
	{
		$em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Organization::class)->find($id);
		
		if (!$data) {
        	throw $this->createNotFoundException();
    	} 

			$em->remove($data);
			$em->flush();

        $this->addFlash('warning', $data->getLegalName().' ' . $translator->trans('flash_message_delete'));
			
			return $this->redirectToRoute('organization');
	}
}