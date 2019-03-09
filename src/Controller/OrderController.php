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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class OrderController extends AbstractController
{
	/**
     * @Route("/orders", name="app_orders")
     * @IsGranted("ROLE_SERVICES_VIEW")
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
     * @Route("/person/{id}/order/{orderID}", name="app_order")
     * @IsGranted("ROLE_SERVICES_VIEW")
     */
	public function show(EntityManagerInterface $em, Request $request, $id, $orderID)
	{
		$em = $this->getDoctrine()->getManager();
		$order = $em->getRepository(Orders::class)->find($orderID);
        
		return $this->render('orders/orderDetails.html.twig', [
        	'data' => $order,
        	'id' => $id,
        	'totalPrice' => 0
		]);
	}
	
	
	/**
     * @Route("/person/{id}/order/create", name="app_order_create")
     * @IsGranted("ROLE_SERVICES_CREATE")
     */
	public function new(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		
		$data = $em->getRepository(Person::class)->find($id);    

		
		$form = $this->createForm(OrderFormType::class);
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$order = $form->getData();
			$data->addCustomer($order);
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($order);
			$em->persist($data);
			$em->flush();
			$OrderID = $order->getId();
					
			$this->addFlash('success', 'Nieuwe order #'.$OrderID.' is aangemaakt!');
		
		
		    return $this->redirectToRoute('app_orderItem_create', array('id' => $id, 'orderID' => $OrderID));    		
		}
		
		return $this->render('orders/orderForm.html.twig', [
        	
        	'data' => $data,
        	'form' => $form->createView(),
        	'id' => $id,
		]);
	}
	
	/**
	* @Route("/person/{id}/order/{orderID}/edit", name="app_order_edit")
	* @IsGranted("ROLE_SERVICES_EDIT")
	*/
	public function edit(EntityManagerInterface $em, Request $request, $id, $orderID)
	{
		$em = $this->getDoctrine()->getManager();
		$order = $em->getRepository(Orders::class)->find($orderID);
	    
		$form = $this->createForm(OrderFormType::class, $order);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$order = $form->getData();
			
			$em->persist($order);
			$em->flush();
			$OrderID = $order->getId();
           
			$this->addFlash('success', 'Nieuwe order #'.$OrderID.' is bijgewerkt!');
			
			return $this->redirectToRoute('app_order', array('id' => $id, 'orderID' => $orderID));    			
		}
		
		return $this->render('orders/orderForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $order,
        	'id' => $id
		]);
	}
	
	/**
	* @Route("/person/{id}/order/{orderID}/delete", name="app_order_delete")
	* @IsGranted("ROLE_SERVICES_DELETE")
	*/
	public function delete(EntityManagerInterface $em, Request $request, $id, $orderID)
	{
		
		$em = $this->getDoctrine()->getManager();
		$order = $em->getRepository(Orders::class)->find($orderID);
		        
		$em->remove($order);
		$em->flush();
		
		$this->addFlash('warning', 'Order is verwijderd!');
		
		return $this->redirectToRoute('app_person_customer', array('id' => $id));    	
	} 

	
	

	
    

}
