<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ProductIsRelatedToFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProductRelatedToController extends AbstractController
{
	
    /**
    * @Route("/product/{id}/isrelatedto/edit", name="product_isRelatedTo_edit")
    * @IsGranted("ROLE_PRODUCT_EDIT")
    */
    public function edit(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
    {

	    $em = $this->getDoctrine()->getManager();
		$data = $em->getRepository(Products::class)->find($id);
		
		if (!$data) {
        	throw $this->createNotFoundException();
    	} 

	    $form = $this->createForm(ProductIsRelatedToFormType::class, $data, array('productId' => $id));
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$data = $form->getData();
			$em->persist($data);
			$em->flush();

            $this->addFlash('success', $translator->trans('flash_message_edit_relatedProducts'));
					
			return $this->redirectToRoute('product_id', array('id' => $id));
		}

		return $this->render('products/product-isrelatedtoForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id,
            'data' => $data
		]);	
	}
}