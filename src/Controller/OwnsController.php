<?php

namespace App\Controller;

use App\Entity\OwnershipInfo;
use App\Entity\Person;
use App\Form\OwnsFormType;
use App\Form\OwnsEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ProductsOnLoan;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;


class OwnsController extends AbstractController
{
    /**
     * @Route("/person/{id}/owns/create", name="owns_create")
     * @IsGranted("ROLE_PRODUCT_CREATE")
     * @param EntityManagerInterface $em
     * @param ProductsOnLoan $productsOnLoan
     * @param Request $request
     * @param $id
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
	public function new(EntityManagerInterface $em, ProductsOnLoan $productsOnLoan, Request $request, $id, TranslatorInterface $translator)
	{
		$em = $this->getDoctrine()->getManager();
		$data = $em->getRepository(Person::class)->find($id);

		$form = $this->createForm(OwnsFormType::class);
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$owns = $form->getData();
			$data->addOwn($owns);
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($owns);
			$em->persist($data);
			$em->flush();
					
			$this->addFlash('success', $translator->trans('Product').' '. $translator->trans('flash_message_create'));
			
			//Process products in loan
			$productsOnLoan->processProduct($owns->getTypeofGood()->getId());

            return $this->redirectToRoute('person_id', array('id' => $id, '_fragment' => 'owns'));
		}
		
		return $this->render('person/person-ownsForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);
	}

    /**
     * @Route("/person/{id}/owns/{ownershipInfoID}/edit", name="owns_edit")
     * @IsGranted("ROLE_PRODUCT_EDIT")
     * @param EntityManagerInterface $em
     * @param ProductsOnLoan $productsOnLoan
     * @param Request $request
     * @param $id
     * @param $ownershipInfoID
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
	public function edit(EntityManagerInterface $em, ProductsOnLoan $productsOnLoan, Request $request, $id, $ownershipInfoID, TranslatorInterface $translator)
	{
		$em = $this->getDoctrine()->getManager();
		$owns = $em->getRepository(OwnershipInfo::class)->find($ownershipInfoID);
		
		if (!$owns) {
        	throw $this->createNotFoundException();
    	} 
		        
        
		$form = $this->createForm(OwnsEditFormType::class, $owns);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$owns = $form->getData();
			
			$em->persist($owns);
			$em->flush();
			
			//Process products in loan
			$productID = $owns->getTypeofGood()->getId();
			$productsOnLoan->processProduct($productID);
           
			$this->addFlash('success', $translator->trans('Product').' '. $translator->trans('flash_message_edit'));

            return $this->redirectToRoute('person_id', array('id' => $id, '_fragment' => 'owns'));
		}

		return $this->render('person/person-ownsForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $owns,
        	'id' => $id
		]);
	}


    /**
     * @Route("/person/{id}/owns/{ownershipInfoID}/delete", name="owns_delete")
     * @IsGranted("ROLE_PRODUCT_DELETE")
     * @param EntityManagerInterface $em
     * @param ProductsOnLoan $productsOnLoan
     * @param $id
     * @param $ownershipInfoID
     * @param TranslatorInterface $translator
     * @return RedirectResponse
     */
	public function delete(EntityManagerInterface $em, ProductsOnLoan $productsOnLoan, $id, $ownershipInfoID, TranslatorInterface $translator)
	{
		
		$em = $this->getDoctrine()->getManager();
		$owns = $em->getRepository(OwnershipInfo::class)->find($ownershipInfoID);
		
		if (!$owns) {
        	throw $this->createNotFoundException();
    	} 
		        
		$em->remove($owns);
		$em->flush();
		
		//Process products in loan
		$productID = $owns->getTypeofGood()->getId();
		$productsOnLoan->processProduct($productID);
		
		$this->addFlash('warning', $translator->trans('Product').' '. $translator->trans('flash_message_delete'));

        return $this->redirectToRoute('person_id', array('id' => $id, '_fragment' => 'owns'));
	} 
}