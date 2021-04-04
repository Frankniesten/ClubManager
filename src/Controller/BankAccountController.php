<?php

namespace App\Controller;

use App\Entity\BankAccount;
use App\Form\BackAccountFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Request;

class BankAccountController extends AbstractController
{
    /**
     * @Route("/bankaccount", name="bank_account")
     * @IsGranted("ROLE_PERSON_VIEW")
     */
    public function index(): Response
    {
        $data = $this->getDoctrine()
            ->getRepository(BankAccount::class)
            ->findAll();

        return $this->render('bank_account/bankAccount.twig', [
            'data' => $data,
            'club_name' => getenv('CLUB_NAME'),
        ]);
    }

    /**
     * @Route("/bankaccount/create", name="bank_account_create")
     * @IsGranted("ROLE_PERSON_CREATE")
     */
    public function create(EntityManagerInterface $em, Request $request, TranslatorInterface $translator)
    {
        $form = $this->createForm(BackAccountFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $em->persist($data);
            $em->flush();
            $id = $data->getId();

            //$this->addFlash('success', $data->getFamilyName() . ', ' . $data->getGivenName() . ' ' . $data->getAdditionalName() . ' ' . $translator->trans('flash_message_create'));
            return $this->redirectToRoute('bank_account');
        }

        return $this->render('bank_account/bankAccountForm.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/bankaccount/{id}/edit", name="bank_account_edit")
     * @IsGranted("ROLE_PERSON_EDIT")
     */
    public function edit(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(BankAccount::class)->find($id);

        if (!$data) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(BackAccountFormType::class, $data);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $em->persist($data);
            $em->flush();

            $this->addFlash('success', $data->getConsumerName().' ' . $translator->trans('flash_message_edit'));

            return $this->redirectToRoute('bank_account');
        }

        return $this->render('bank_account/bankAccountForm.twig', [
            'form' => $form->createView(),
            'data' => $data
        ]);
    }

    /**
     * @Route("/bankaccount/{id}/delete", name="bank_account_delete")
     * @IsGranted("ROLE_PERSON_DELETE")
     */
    public function del(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(BankAccount::class)->find($id);
        if (!$data) {
            throw $this->createNotFoundException();
        }

        $em->remove($data);
        $em->flush();

        $this->addFlash('warning', $data->getConsumerName() . ' ' . $translator->trans('flash_message_delete'));

        return $this->redirectToRoute('bank_account');
    }
}
