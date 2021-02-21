<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\Person;
use App\Form\OrderFormType;
use App\Form\OrderPersonFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;


class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="order")
     * @IsGranted("ROLE_SERVICES_VIEW")
     */
        public function list(EntityManagerInterface $em, Request $request)
        {
            $orders = $this->getDoctrine()
                ->getRepository(Orders::class)
                ->findAll();

            return $this->render('orders/orders.html.twig', [
                'data' => $orders,
                'club_name' => getenv('CLUB_NAME'),
            ]);
        }

    /**
     * @Route("/order/create", name="order_create")
     * @IsGranted("ROLE_SERVICES_CREATE")
     */
    public function createOrder(EntityManagerInterface $em, Request $request, TranslatorInterface $translator)
    {
        $form = $this->createForm(OrderFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $em->persist($data);
            $em->flush();
            $id = $data->getId();

            $this->addFlash('success', $data->getFamilyName() . ', ' . $data->getGivenName() . ' ' . $data->getAdditionalName() . ' ' . $translator->trans('flash_message_create'));

            return $this->redirectToRoute('order_view', array('id' => $id));
        }

        return $this->render('orders/orderForm.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/order/{id}/edit", name="order_edit")
     * @IsGranted("ROLE_SERVICES_EDIT")
     */
    public function editOrder(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
    {
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository(Orders::class)->find($id);

        if (!$order) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(OrderFormType::class, $order);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $order = $form->getData();

            $em->persist($order);
            $em->flush();
            $OrderID = $order->getId();

            $this->addFlash('success', $translator->trans('order').' #'.$OrderID. ' ' . $translator->trans('flash_message_edit'));

            return $this->redirectToRoute('order_view', array('id' => $id, ));
        }

        return $this->render('orders/orderForm.html.twig', [
            'form' => $form->createView(),
            'data' => $order,
            'id' => $id
        ]);
    }

    /**
     * @Route("/order/{id}/delete", name="order_delete")
     * @IsGranted("ROLE_SERVICES_DELETE")
     */
    public function deleteOrder(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
    {

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Orders::class)->find($id);

        if (!$data) {
            throw $this->createNotFoundException();
        }

        $em->remove($data);
        $em->flush();

        $this->addFlash('warning', $translator->trans('order').' #'.$id. ' ' . $translator->trans('flash_message_delete'));

        return $this->redirectToRoute('order');
    }

    /**
     * @Route("/order/{id}", name="order_view")
     * @IsGranted("ROLE_SERVICES_VIEW")
     */
    public function view(EntityManagerInterface $em, Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Orders::class)->find($id);

        if (!$data) {
            throw $this->createNotFoundException();
        }

        return $this->render('orders/order.html.twig', [
            'data' => $data,
            'club_name' => getenv('CLUB_NAME'),
        ]);
    }












    /**
     * @Route("/person/{id}/order/create", name="person_order_create")
     * @IsGranted("ROLE_SERVICES_CREATE")
     */
    public function new(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Person::class)->find($id);

        if (!$data) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(OrderPersonFormType::class);
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


            return $this->redirectToRoute('person_id', array('id' => $id, '_fragment' => 'order'));
        }

        return $this->render('person/person-orderForm.html.twig', [

            'data' => $data,
            'form' => $form->createView(),
            'id' => $id,
        ]);
    }

	/**
     * @Route("/person/{id}/order/{orderID}", name="person_order_id")
     * @IsGranted("ROLE_SERVICES_VIEW")
     */
	public function show(EntityManagerInterface $em, Request $request, $id, $orderID, TranslatorInterface $translator)
	{
		$em = $this->getDoctrine()->getManager();
		$order = $em->getRepository(Orders::class)->find($orderID);
		
		if (!$order) {
        	throw $this->createNotFoundException();
    	}
        
		return $this->render('orders/orderDetails.html.twig', [
        	'data' => $order,
        	'id' => $id,
        	'totalPrice' => 0
		]);
	}




	/**
	* @Route("/person/{id}/order/{orderID}/edit", name="person_order_edit")
	* @IsGranted("ROLE_SERVICES_EDIT")
	*/
    public function edit(EntityManagerInterface $em, Request $request, $id, $orderID, TranslatorInterface $translator)
    {
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository(Orders::class)->find($orderID);

        if (!$order) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(OrderPersonFormType::class, $order);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $order = $form->getData();

            $em->persist($order);
            $em->flush();
            $OrderID = $order->getId();

            $this->addFlash('success', $translator->trans('order').' #'.$OrderID. ' ' . $translator->trans('flash_message_edit'));

            return $this->redirectToRoute('person_id', array('id' => $id, 'orderID' => $orderID, '_fragment' => 'order'));
        }

        return $this->render('person/person-orderForm.html.twig', [
            'form' => $form->createView(),
            'data' => $order,
            'id' => $id
        ]);
    }
	
	/**
	* @Route("/person/{id}/order/{orderID}/delete", name="person_order_delete")
	* @IsGranted("ROLE_SERVICES_DELETE")
	*/
	public function delete(EntityManagerInterface $em, Request $request, $id, $orderID, TranslatorInterface $translator)
	{
		
		$em = $this->getDoctrine()->getManager();
		$data = $em->getRepository(Orders::class)->find($orderID);
		
		if (!$data) {
        	throw $this->createNotFoundException();
    	}

		$em->remove($data);
		$em->flush();
		
		$this->addFlash('warning', $translator->trans('order').' #'.$orderID. ' ' . $translator->trans('flash_message_delete'));
		
		return $this->redirectToRoute('person_id', array('id' => $id, '_fragment' => 'order'));
	}
}
