<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Category;
use App\Form\EventFormType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;


class EventController extends AbstractController
{
	    
    /**
     * @Route("/event", name="event")
     * @IsGranted("ROLE_EVENT_VIEW")
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
		    $startDate = $session->get('startDate', date_format(new \DateTime(), 'Y-m-d'));
	    }
	    
	    //Check endDate:       
	    if ($endDate = $request->query->get('endDate'))
	    {
		    $session->set('endDate', $endDate);
	    }
	    else 
	    {
		    $endDate = $session->get('endDate', date_format(new \DateTime('+1 year'), 'Y-m-d'));
	    }
	    
	    //Check categorie:       
	    if ($query = $request->query->get('category'))
	    {
		    $session->set('event_category', $query);
	    }
	    else 
	    {
		    $query = $session->get('event_category', 'all');
	    }
	    
    	//Query
    	if ($query == 'all') 
    	{
			$datas = $this->getDoctrine()
	        ->getRepository(Event::class)->findByDate($startDate, $endDate); 
	    }
	    
	    else 
	    { 
		    $query = $session->get('event_category', 'all');
		    
		    $em = $this->getDoctrine()->getManager();
			$datas = $em->getRepository(Event::class)->findByCategegory($query, $startDate, $endDate);   
	    }
        
		$em = $this->getDoctrine()->getManager();
		$category = $em->getRepository(Category::class)->findCategoryType('event');
	    
        
        return $this->render('event/events.html.twig', [
	        'data' => $datas,
	        'club_name' => getenv('CLUB_NAME'),
            'category' => $category,
        	'query' => $query,
        	'startDate' => $startDate,
        	'endDate' => $endDate,
        ]);
    }

    /**
     * @Route("/event/feed", name="event_feed")
     */
    public function feed(EntityManagerInterface $em, Request $request)
    {
        $data = array();

        if ($search = $request->query->get('search'))
        {
            $category = explode("-", $search);
            array_pop($category);

            dump($category);


            foreach ($category as $key => $value) {

                $feed = $this->getDoctrine()
                    ->getRepository(Event::class)
                    ->findByFeed($value);

                $data = array_merge($data, $feed);
            }
        }

        else {
            $data = $this->getDoctrine()
                ->getRepository(Event::class)
                ->findAll();
        }

        return $this->render('event/event-feed.html.twig', [
            'data' => $data,
        ]);
    }

    /**
     * @Route("/event/feed/config", name="event_feed_config")
     */
    public function feedConfig(EntityManagerInterface $em, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Category::class)->findCategoryType('event');
dump($data);
        return $this->render('event/event-feed-config.html.twig', [
            'data' => $data,
        ]);
    }

    /**
     * @Route("/event/create", name="event_create")
     * @IsGranted("ROLE_EVENT_CREATE")
     */
    public function new(EntityManagerInterface $em, Request $request, TranslatorInterface $translator)
    {
        $form = $this->createForm(EventFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $em->persist($data);
            $em->flush();
            $id = $data->getId();

            $this->addFlash('success', $data->getAbout().' ' . $translator->trans('flash_message_create'));
            return $this->redirectToRoute('event_id', array('id' => $id));
        }

        return $this->render('event/eventForm.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/event/{id}", name="event_id")
     * @IsGranted("ROLE_EVENT_VIEW")
     */
    public function show(EntityManagerInterface $em, Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Event::class)->find($id);

        if (!$data) {
            throw $this->createNotFoundException();
        }

        //Call Log File:
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry');
        $log = $em->find('App\Entity\Event', $id);
        $logs = $repo->getLogEntries($log);

        return $this->render('event/event.html.twig', [
            'data' => $data,
            'logs' => $logs
        ]);
    }


	
	/**
     * @Route("/event/{id}/copy", name="event_copy")
     * @IsGranted("ROLE_EVENT_CREATE")
     */
	public function copy(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
	{
		$em = $this->getDoctrine()->getManager();
		$data = $em->getRepository(Event::class)->find($id);
		
		if (!$data) {
        	throw $this->createNotFoundException();
    	}

		$form = $this->createForm(EventFormType::class, clone $data);
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			unset($data);
			$data = $form->getData();
			
			$em->persist($data);
			$em->flush();
			$id = $data->getId();

            $this->addFlash('success', $data->getAbout().' ' . $translator->trans('flash_message_create'));
			
			return $this->redirectToRoute('event_id', array('id' => $id));
		}
		
		return $this->render('event/eventForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $data
		]);
	}
	
	/**
     * @Route("/event/{id}/edit", name="event_edit")
     * @IsGranted("ROLE_EVENT_EDIT")
     */
	public function edit(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
	{
		$em = $this->getDoctrine()->getManager();
		$data = $em->getRepository(Event::class)->find($id);
		
		if (!$data) {
        	throw $this->createNotFoundException();
    	}

		$form = $this->createForm(EventFormType::class, $data);
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
		
			$data = $form->getData();
			$em->persist($data);
			$em->flush();

            $this->addFlash('success', $data->getAbout() . ' ' . $translator->trans('flash_message_edit'));
			return $this->redirectToRoute('event_id', array('id' => $id));
		}
		
		return $this->render('event/eventForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $data
		]);
	}
	
	
	/**
     * @Route("/event/{id}/delete", name="event_delete")
     * @IsGranted("ROLE_EVENT_DELETE")
     */
	public function del(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
	{
		$em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Event::class)->find($id);
		
		if (!$data) {
        	throw $this->createNotFoundException();
    	}

        $em->remove($data);
        $em->flush();

        $this->addFlash('warning', $data->getAbout() .' '. $translator->trans('flash_message_delete'));
        return $this->redirectToRoute('event');
	}

}
