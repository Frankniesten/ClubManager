<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\OrderItem;
use App\Entity\Person;
use App\Entity\Organization;
use App\Form\OrderItemFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderItemController extends AbstractController
{
    /**
     * @Route("/person/{id}/order/{orderID}/orderitem/create", name="app_orderItem_create")
     */
	public function new(EntityManagerInterface $em, Request $request, $id, $orderID)
	{
		$em = $this->getDoctrine()->getManager();
		
		$data = $em->getRepository(Orders::class)->find($orderID);    
		
		$form = $this->createForm(OrderItemFormType::class);
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$order = $form->getData();
			$data->addOrderItem($order);
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($order);
			$em->persist($data);
			$em->flush();
			$orderID = $data->getId();
			

					
			$this->addFlash('success', 'Artikel is toegevoegd aan order #'.$orderID.'!');		

			return $this->redirectToRoute('app_order', array('id' => $id, 'orderID' => $orderID));    	
		}
		
		return $this->render('order_item/orderItemForm.html.twig', [
        	
        	'data' => $data,
        	'form' => $form->createView(),
        	'id' => $id,
        	'orderID' => $orderID
		]);
	}
	
	
	/**
	* @Route("/person/{id}/order/{orderID}/orderitem/{orderItemID}/edit", name="app_orderItem_edit")
	*/
	public function edit(EntityManagerInterface $em, Request $request, $id, $orderID, $orderItemID)
	{
		$em = $this->getDoctrine()->getManager();
		$order = $em->getRepository(OrderItem::class)->find($orderItemID);
	    
		$form = $this->createForm(OrderItemFormType::class, $order);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$orderItem = $form->getData();
			
			$em->persist($orderItem);
			$em->flush();
           
			$this->addFlash('success', 'Artikel is bijgewerkt!');
			
			return $this->redirectToRoute('app_order', array('id' => $id, 'orderID' => $orderID)); 			
		}
		
		return $this->render('order_item/orderItemForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $order,
        	'id' => $id,
        	'orderID' => $orderID
		]);
	}
	
	
	/**
	* @Route("/person/{id}/order/{orderID}/orderitem/{orderItemID}/delete", name="app_orderItem_delete")
	*/
	public function delete(EntityManagerInterface $em, Request $request, $id, $orderID, $orderItemID)
	{
		
		$em = $this->getDoctrine()->getManager();
		$orderItem = $em->getRepository(OrderItem::class)->find($orderItemID);
		        
		$em->remove($orderItem);
		$em->flush();
		
		$this->addFlash('warning', 'Artikel is verwijderd!');
		
		return $this->redirectToRoute('app_order', array('id' => $id, 'orderID' => $orderID));
	}
	
	
	
	
	
}
