<?php

namespace App\Controller;

use App\Entity\OwnershipInfo;
use App\Entity\Products;
use App\Form\OwnershipFormType;
use App\Service\ProductsOnLoan;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;


class OwnershipInfoController extends AbstractController
{
    /**
     * @Route("/product/{id}/ownershipinfo/create", name="ownership_info_create")
     * @IsGranted("ROLE_PERSON_CREATE")
     * @param $id
     * @param ProductsOnLoan $productsOnLoan
     * @param Request $request
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function create($id, ProductsOnLoan $productsOnLoan, Request $request, TranslatorInterface $translator)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Products::class)->find($id);

        $form = $this->createForm(OwnershipFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $owns = $form->getData();
            $data->addOwnershipInfo($owns);

            $em = $this->getDoctrine()->getManager();
            $em->persist($owns);
            $em->persist($data);
            $em->flush();

            $this->addFlash('success', $translator->trans('Product_lease_lend').' '. $translator->trans('flash_message_create'));

            //Process products in loan
            $productsOnLoan->processProduct($owns->getTypeofGood()->getId());

            return $this->redirectToRoute('product_id', array('id' => $id, '_fragment' => 'ownershipInfos'));
        }

        return $this->render('products/product-ownershipInfoForm.html.twig', [
            'form' => $form->createView(),
            'id' => $id
        ]);
    }

    /**
     * @Route("/product/{id}/ownershipinfo/{ownershipID}/edit", name="ownership_info_edit")
     * @IsGranted("ROLE_PERSON_EDIT")
     * @param $id
     * @param $ownershipID
     * @param Request $request
     * @param ProductsOnLoan $productsOnLoan
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function edit($id, $ownershipID, Request $request, ProductsOnLoan $productsOnLoan, TranslatorInterface $translator)
    {
        $em = $this->getDoctrine()->getManager();
        $owns = $em->getRepository(OwnershipInfo::class)->find($ownershipID);

        if (!$owns) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(OwnershipFormType::class, $owns);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $owns = $form->getData();

            $em->persist($owns);
            $em->flush();

            //Process products in loan
            $productID = $owns->getTypeofGood()->getId();
            $productsOnLoan->processProduct($productID);

            $this->addFlash('success', $translator->trans('Product_lease_lend').' '. $translator->trans('flash_message_edit'));
            return $this->redirectToRoute('product_id', array('id' => $id, '_fragment' => 'ownershipInfos'));
        }

        return $this->render('products/product-ownershipInfoForm.html.twig', [
            'form' => $form->createView(),
            'data' => $owns,
            'id' => $id
        ]);
    }

    /**
     * @Route("/product/{id}/ownershipinfo/{ownershipID}/delete", name="ownership_info_delete")
     * @IsGranted("ROLE_PRODUCT_DELETE")
     * @param $id
     * @param $ownershipID
     * @param ProductsOnLoan $productsOnLoan
     * @param TranslatorInterface $translator
     * @return RedirectResponse
     */
    public function delete($id, $ownershipID, ProductsOnLoan $productsOnLoan, TranslatorInterface $translator)
    {
        $em = $this->getDoctrine()->getManager();
        $owns = $em->getRepository(OwnershipInfo::class)->find($ownershipID);

        if (!$owns) {
            throw $this->createNotFoundException();
        }

        $em->remove($owns);
        $em->flush();

        //Process products in loan
        $owns->getTypeofGood()->getId();
        $productsOnLoan->processProduct($id);

        $this->addFlash('warning', $translator->trans('Product_lease_lend').' '. $translator->trans('flash_message_delete'));

        return $this->redirectToRoute('product_id', array('id' => $id, '_fragment' => 'ownershipInfos'));
    }
}
