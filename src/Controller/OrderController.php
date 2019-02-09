<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\Person;
use App\Entity\Organization;
use App\Form\OrderFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class OrderController extends AbstractController
{
	/**
     * @Route("/orders", name="app_orders")
     */
	public function list(EntityManagerInterface $em, Request $request)
	{
		$orders = $this->getDoctrine()
        ->getRepository(Orders::class)
        ->findAll();
				
		return $this->render('orders/orders.html.twig', [
        	'data' => $orders,
		]);
	}
	
	
	/**
     * @Route("/{entity}/{id}/order/{orderID}", name="app_order")
     */
	public function show(EntityManagerInterface $em, Request $request, $entity, $id, $orderID)
	{
		$em = $this->getDoctrine()->getManager();
		$order = $em->getRepository(Orders::class)->find($orderID);
        
		return $this->render('orders/orderDetails.html.twig', [
        	'data' => $order,
        	'entity' => $entity,
        	'id' => $id
		]);
	}
	
	
	/**
     * @Route("/{entity}/{id}/order/create", name="app_order_create")
     */
	public function new(EntityManagerInterface $em, Request $request, $entity, $id)
	{
		$em = $this->getDoctrine()->getManager();
		
		if ($entity == 'person') 
	    {
		    $data = $em->getRepository(Person::class)->find($id);    
	    }
		
		$form = $this->createForm(OrderFormType::class);
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$order = $form->getData();
			$data->addCustomer($order);
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($order);
			$em->persist($data);
			$em->flush();
					
			$this->addFlash('success', 'Nieuw product in bruikleen is aangemaakt!');
		
			
			if ($entity == 'person') 
		    {
			    return $this->redirectToRoute('app_person_customer', array('id' => $id));    
		    }		
		}
		
		return $this->render('orders/orderForm.html.twig', [
        	
        	'data' => $data,
        	'form' => $form->createView(),
        	'id' => $id,
		]);
	}
	
	/**
	* @Route("/{entity}/{id}/order/{orderID}/edit", name="app_order_edit")
	*/
	public function edit(EntityManagerInterface $em, Request $request, $entity, $id, $orderID)
	{
		$em = $this->getDoctrine()->getManager();
		$order = $em->getRepository(Orders::class)->find($orderID);
	    
		$form = $this->createForm(OrderFormType::class, $order);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$order = $form->getData();
			
			$em->persist($order);
			$em->flush();
           
			$this->addFlash('success', 'Order is bijgewerkt!');
			
			if ($entity == 'person') 
		    {
			    return $this->redirectToRoute('app_person_customer', array('id' => $id));    
		    }
		    if ($entity == 'order') 
		    {
			    return $this->redirectToRoute('app_orders');    
		    }				
		}
		
		return $this->render('orders/orderEditForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $order,
        	'id' => $id,
        	'entity' => $entity
		]);
	}
	
	/**
	* @Route("/{entity}/{id}/order/{orderID}/delete", name="app_order_delete")
	*/
	public function delete(EntityManagerInterface $em, Request $request, $entity, $id, $orderID)
	{
		
		$em = $this->getDoctrine()->getManager();
		$order = $em->getRepository(Orders::class)->find($orderID);
		        
		$em->remove($order);
		$em->flush();
		
		
		$this->addFlash('warning', 'Order is verwijderd!');
		
		if ($entity == 'person') 
	    {
		    return $this->redirectToRoute('app_person_customer', array('id' => $id));    
	    }
	    if ($entity == 'order') 
	    {
		    return $this->redirectToRoute('app_orders', array('id' => $id));    
	    }		
	} 

	
	

	
    

}
