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
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class EventsController extends AbstractController
{
	    
    /**
     * @Route("/events", name="app_events")
     * @IsGranted("ROLE_PRODUCT_VIEW")
     */
    public function list(SessionInterface $session, EntityManagerInterface $em, Request $request)
    {
	    //Check startDate:       
	    if ($startDate = $request->query->get('startDate'))
	    {
		    $session->set('startDate', $startDate);
	    }
	    else 
	    {
		    $startDate = $session->get('startDate', new \DateTime());
	    }
	    
	    //Check endDate:       
	    if ($endDate = $request->query->get('endDate'))
	    {
		    $session->set('endDate', $endDate);
	    }
	    else 
	    {
		    $endDate = $session->get('endDate', new \DateTime('+1 year'));
	    }
	    
	    //Check categorie:       
	    if ($query = $request->query->get('query'))
	    {
		    $session->set('event_query', $query);
	    }
	    else 
	    {
		    $query = $session->get('event_query', 'all');
	    }
	    
    	//Query
    	if ($query == 'all') 
    	{
			$events = $this->getDoctrine()
	        ->getRepository(Event::class)->findByDate($startDate, $endDate); 
	    }
	    
	    else 
	    { 
		    $query = $session->get('event_query', 'all');
		    
		    $em = $this->getDoctrine()->getManager();
			$events = $em->getRepository(Event::class)->findByCategegory($query, $startDate, $endDate);   
	    }
        
		$em = $this->getDoctrine()->getManager();
		$category = $em->getRepository(Category::class)->findCategoryType('event');
	    
        
        return $this->render('events/events.html.twig', [
	        'data' => $events,
	        'club_name' => getenv('CLUB_NAME'),
            'category' => $category,
        	'query' => $query,
        	'startDate' => $startDate,
        	'endDate' => $endDate,
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
     * @Route("/event/{id}/clone", name="app_event_clone")
     * @IsGranted("ROLE_EVENT_CREATE")
     */
	public function clone(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$event = $em->getRepository(Event::class)->find($id);
		
		if (!$event) {
        	throw $this->createNotFoundException('Dit event bestaat niet.');
    	}
		        
        
		$form = $this->createForm(EventFormType::class, clone $event);
		
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			unset($event);

  
			$event = $form->getData();
			
			$em->persist($event);
			$em->flush();
			$id = $event->getId();
           
			$this->addFlash('success', $event->getAbout(). ' is nieuw toegevoegd!');
			
			return $this->redirectToRoute('app_event', array('id' => $id));			
		}
		
		return $this->render('events/eventForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $event
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
