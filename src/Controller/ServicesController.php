<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ServicesController extends AbstractController
{
    /**
     * @Route("/services", name="app_services")
     * @IsGranted("ROLE_SERVICES_VIEW")
     */
    public function list(EntityManagerInterface $em, Request $request)
    {
	    $services = $this->getDoctrine()
        ->getRepository(Service::class)
        ->findAll();
        
        return $this->render('services/services.html.twig', [
            'data' => $services
        ]);
    }
    
    /**
     * @Route("/service/{id}", name="app_service")
     * @IsGranted("ROLE_SERVICES_VIEW")
     */
	public function show(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$service = $em->getRepository(Service::class)->find($id);
		
		if (!$service) {
        	throw $this->createNotFoundException('Dit product bestaat niet.');
    	}
    			        
		return $this->render('services/service.html.twig', [
        	'data' => $service
		]);
	}
    
    
    /**
     * @Route("/service/create", name="app_service_create")
     * @IsGranted("ROLE_SERVICES_CREATE")
     */
	public function new(EntityManagerInterface $em, Request $request)
	{
		$form = $this->createForm(ServiceFormType::class);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$service = $form->getData();
			
			$em->persist($service);
			$em->flush();
			$id = $service->getId();
           
			//$this->addFlash('success', $service->getName(). ' is nieuw toegevoegd!');
			
			return $this->redirectToRoute('app_service', array('id' => $id));			
		}
		
		return $this->render('services/serviceForm.html.twig', [
        	'form' => $form->createView()
		]);
	}
	
	/**
     * @Route("/servcie/{id}/edit", name="app_service_edit")
     * @IsGranted("ROLE_SERVICES_EDIT")
     */
	public function edit(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$service = $em->getRepository(Service::class)->find($id);
		
		if (!$service) {
        	throw $this->createNotFoundException('Deze dienst bestaat niet.');
    	}
		            
		$form = $this->createForm(ServiceFormType::class, $service);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$service = $form->getData();
			
			$em->persist($service);
			$em->flush();
           
			$this->addFlash('success', $service->getServiceType(). ' is bijgewerkt!');
			
			return $this->redirectToRoute('app_service', array('id' => $id));			
		}
		
		return $this->render('services/serviceForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $service
		]);
	}
	
	/**
     * @Route("/service/{id}/delete", name="service_delete")
     * @IsGranted("ROLE_SERVICES_DELETE")
     */
	public function del(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$service = $em->getRepository(Service::class)->find($id);
		
		if (!$service) {
        	throw $this->createNotFoundException('The product does not exist');
    	}

			$em->remove($service);
			$em->flush();
           
			$this->addFlash('success', 'Dienst is verwijderd!');
			
			return $this->redirectToRoute('app_services');			
	}


}
