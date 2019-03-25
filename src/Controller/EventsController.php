<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Category;
use App\Form\EventFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class EventsController extends AbstractController
{
    /**
     * @Route("/events", name="app_events")
     * @IsGranted("ROLE_PRODUCT_VIEW")
     */
    public function list(EntityManagerInterface $em, Request $request)
    {
	    $query = $request->query->get('query');
    	
    	if ($query == null) {
    
			$events = $this->getDoctrine()
	        ->getRepository(Event::class)
	        ->findAll();    
	    }
	    
	    else {
		    
		    $em = $this->getDoctrine()->getManager();
			$events = $em->getRepository(Event::class)->findByCategegory($query);
		        
	    }
        
		$em = $this->getDoctrine()->getManager();
		$category = $em->getRepository(Category::class)->findCategoryType('event');
	    
        
        return $this->render('events/events.html.twig', [
            'data' => $events,
            'category' => $category,
        	'query' => $query
        ]);
    }
    
    
    /**
     * @Route("/event/create", name="app_event_create")
     * @IsGranted("ROLE_EVENT_CREATE")
     */
	public function new(EntityManagerInterface $em, Request $request)
	{
		$form = $this->createForm(EventFormType::class);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			
			$event = $form->getData();
			
			$em->persist($event);
			$em->flush();
			$id = $event->getId();
           
			$this->addFlash('success', $event->getAbout(). ' is nieuw toegevoegd!');
			
			return $this->redirectToRoute('app_event', array('id' => $id));			
		}
		
		return $this->render('events/eventForm.html.twig', [
        	'form' => $form->createView()
		]);
	}
	
	
	/**
     * @Route("/event/{id}", name="app_event")
     * @IsGranted("ROLE_EVENT_VIEW")
     */
	public function show(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$event = $em->getRepository(Event::class)->find($id);
		
		if (!$event) {
        	throw $this->createNotFoundException('Dit event bestaat niet.');
    	}
    			        
		return $this->render('events/event.html.twig', [
        	'data' => $event
		]);
	}
	
	
	/**
     * @Route("/event/{id}/edit", name="app_event_edit")
     * @IsGranted("ROLE_EVENT_EDIT")
     */
	public function edit(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$event = $em->getRepository(Event::class)->find($id);
		
		if (!$event) {
        	throw $this->createNotFoundException('Dit event bestaat niet.');
    	}
		        
        
		$form = $this->createForm(EventFormType::class, $event);
		
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
		
			$event = $form->getData();
			$em->persist($event);
			$em->flush();
           
			$this->addFlash('success', $event->getAbout(). ' is bijgewerkt!');
			
			return $this->redirectToRoute('app_event', array('id' => $id));			
		}
		
		return $this->render('events/eventForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $event
		]);
	}
	
	
	/**
     * @Route("/event/{id}/delete", name="product_event")
     * @IsGranted("ROLE_EVENT_DELETE")
     */
	public function del(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$event = $em->getRepository(Event::class)->find($id);
		
		if (!$event) {
        	throw $this->createNotFoundException('Dit event bestaat niet.');
    	}

			$em->remove($event);
			$em->flush();
           
			$this->addFlash('success', 'Het event is verwijderd!');
			
			return $this->redirectToRoute('app_events');			
	}
	
	
	
	/**
     * @Route("/events/feed", name="app_events_feed")
     */
    public function feed(EntityManagerInterface $em, Request $request)
    {

    
			$events = $this->getDoctrine()
	        ->getRepository(Event::class)
	        ->findAll();    
	    
	    
        
        return $this->render('events/feed.html.twig', [
            'data' => $events,
        ]);
    }
}
