<?php

namespace App\Controller;

use App\Entity\Donation;
use App\Entity\Funds;
use App\Entity\Organization;
use App\Form\DonationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

class DonationController extends AbstractController
{
    /**
     * @Route("/funds/{id}/donation/create", name="funds_donation_create")
     * @IsGranted("ROLE_SERVICES_CREATE")
     */
    public function new(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Funds::class)->find($id);


        $form = $this->createForm(DonationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            $donation = $form->getData();
            $data->addDonation($donation);


            $em = $this->getDoctrine()->getManager();
            $em->persist($donation);
            $em->persist($data);
            $em->flush();
            $donationId = $donation->getId();

            $this->addFlash('success', $translator->trans('Donation').' '.$translator->trans('flash_message_create'));
            return $this->redirectToRoute('funds_donation_view', array('id' => $id, 'donationId' => $donationId, '_fragment' => 'order'));
        }

        return $this->render('funds/funds-donationForm.html.twig', [
            'data' => $data,
            'form' => $form->createView(),
            'id' => $donationId,
        ]);
    }

    /**
     * @Route("/funds/{id}/donation/{donationId}", name="funds_donation_view")
     * @IsGranted("ROLE_SERVICES_VIEW")
     */
    public function view(EntityManagerInterface $em, Request $request, $id, $donationId, TranslatorInterface $translator)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Donation::class)->find($donationId);




        if (!$data) {
            throw $this->createNotFoundException();
        }



        return $this->render('funds/funds-donation.html.twig', [
            'data' => $data,
            'club_name' => getenv('CLUB_NAME'),
            'id' => $id,
        ]);
    }

    /**
     * @Route("/funds/{id}/donation/{donationId}/invoice", name="funds_donation_invoice")
     * @IsGranted("ROLE_SERVICES_VIEW")
     */
    public function invoice(EntityManagerInterface $em, Request $request, $id, $donationId, TranslatorInterface $translator)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Donation::class)->find($donationId);

        //$em = $this->getDoctrine()->getManager();
        $organization = $em->getRepository(Organization::class)->find(1);


        if (!$data) {
            throw $this->createNotFoundException();
        }
        return $this->render('funds/funds-donation-invoice.html.twig', [
            'data' => $data,
            'organization' => $organization,
            'club_name' => getenv('CLUB_NAME'),
            'id' => $id,
        ]);
    }

    /**
     * @Route("/funds/{id}/donation/{donationId}/edit", name="funds_donation_edit")
     * @IsGranted("ROLE_SERVICES_EDIT")
     */
    public function edit(EntityManagerInterface $em, Request $request, $id, $donationId, TranslatorInterface $translator)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Donation::class)->find($donationId);


        if (!$data) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(DonationFormType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $donation = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($donation);
            $em->flush();
            $donationId = $donation->getId();

            $this->addFlash('success', $translator->trans('Donation').' '.$translator->trans('flash_message_edit'));
            return $this->redirectToRoute('funds_donation_view', array('id' => $id, 'donationId' => $donationId, '_fragment' => 'order'));
        }

        return $this->render('funds/funds-donationForm.html.twig', [
            'data' => $data,
            'form' => $form->createView(),
            'id' => $donationId,
        ]);
    }

    /**
     * @Route("/funds/{id}/donation/{donationId}/delete", name="funds_donation_delete")
     * @IsGranted("ROLE_SERVICES_DELETE")
     */
    public function delete(EntityManagerInterface $em, Request $request, $id, $donationId, TranslatorInterface $translator)
    {

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Donation::class)->find($donationId);

        if (!$data) {
            throw $this->createNotFoundException();
        }

        $em->remove($data);
        $em->flush();

        $this->addFlash('warning', $translator->trans('Donation').' '. $translator->trans('flash_message_delete'));

        return $this->redirectToRoute('funds_view', array('id' => $id, '_fragment' => 'order'));
    }
}