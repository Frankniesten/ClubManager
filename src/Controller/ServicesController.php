<?php

namespace App\Controller;

use App\Entity\Service;
use App\Entity\Category;
use App\Form\ServiceFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ServicesController extends AbstractController
{
    /**
     * @Route("/service", name="service")
     * @IsGranted("ROLE_SERVICES_VIEW")
     */
    public function list(SessionInterface $session, EntityManagerInterface $em, Request $request)
    {
        $query = null;

	    //Check categorie:       
	    if ($query = $request->query->get('category'))
	    {
		    $session->set('service_query', $query);
	    }
	    else 
	    {
		    $query = $session->get('service_query', 'all');
	    }
    	
    	if ($query == 'all') {
    
			$services = $this->getDoctrine()
	        ->getRepository(Service::class)
	        ->findAll();    
	    }
	    
	    else 
	    {
		    $query = $session->get('service_query', 'all');
		    
		    $em = $this->getDoctrine()->getManager();
			$services = $em->getRepository(Service::class)->findByCategegory($query);
	    }
	        
		$em = $this->getDoctrine()->getManager();
		$category = $em->getRepository(Category::class)->findCategoryType('service');
		        
        return $this->render('services/services.html.twig', [
            'data' => $services,
            'club_name' => getenv('CLUB_NAME'),
          	'category' => $category,
        	'query' => $query
        ]);
    }

    /**
     * @Route("/service/create", name="service_create")
     * @IsGranted("ROLE_SERVICES_CREATE")
     */
	public function new(EntityManagerInterface $em, Request $request, TranslatorInterface $translator)
	{
		$form = $this->createForm(ServiceFormType::class);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$service = $form->getData();
			
			$em->persist($service);
			$em->flush();
			$id = $service->getId();

            $this->addFlash('success', $service->getServiceType(). ' ' . $translator->trans('flash_message_create'));

            return $this->redirectToRoute('service_id', array('id' => $id));
		}
		
		return $this->render('services/serviceForm.html.twig', [
        	'form' => $form->createView()
		]);
	}

    /**
     * @Route("/service/{id}", name="service_id")
     * @IsGranted("ROLE_SERVICES_VIEW")
     */
    public function show(EntityManagerInterface $em, Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $service = $em->getRepository(Service::class)->find($id);

        if (!$service) {
            throw $this->createNotFoundException();
        }

        //Call Log File:
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry');
        $log = $em->find('App\Entity\Service', $id);
        $logs = $repo->getLogEntries($log);

        return $this->render('services/service.html.twig', [
            'data' => $service,
            'logs' => $logs
        ]);
    }
	
	/**
     * @Route("/service/{id}/edit", name="service_edit")
     * @IsGranted("ROLE_SERVICES_EDIT")
     */
	public function edit(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
	{
		$em = $this->getDoctrine()->getManager();
		$service = $em->getRepository(Service::class)->find($id);
		
		if (!$service) {
        	throw $this->createNotFoundException();
    	}
		            
		$form = $this->createForm(ServiceFormType::class, $service);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$service = $form->getData();
			
			$em->persist($service);
			$em->flush();

            $this->addFlash('success', $service->getServiceType(). ' ' . $translator->trans('flash_message_edit'));
			
			return $this->redirectToRoute('service_id', array('id' => $id));
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
	public function del(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
	{
		$em = $this->getDoctrine()->getManager();
		$service = $em->getRepository(Service::class)->find($id);
		
		if (!$service) {
        	throw $this->createNotFoundException();
    	}

			$em->remove($service);
			$em->flush();

        $this->addFlash('warning', $service->getServiceType(). ' ' . $translator->trans('flash_message_delete'));
			
			return $this->redirectToRoute('service');
	}
}
