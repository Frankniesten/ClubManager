<?php

namespace App\Controller;

use App\Entity\Donation;
use App\Entity\Funds;
use App\Form\FundsFormType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class FundsController extends AbstractController
{
    /**
     * @Route("/funds", name="funds")
     * @IsGranted("ROLE_SERVICES_VIEW")
     */
    public function index(): Response
    {

        $data = $this->getDoctrine()
            ->getRepository(Funds::class)
            ->findAll();

        return $this->render('funds/funds.html.twig', [
            'data' => $data,
            'club_name' => getenv('CLUB_NAME'),
        ]);
    }

    /**
     * @Route("/funds/create", name="funds_create")
     * @IsGranted("ROLE_SERVICES_CREATE")
     */
    public function create(EntityManagerInterface $em, Request $request, TranslatorInterface $translator)
    {
        $form = $this->createForm(FundsFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $em->persist($data);
            $em->flush();
            $id = $data->getId();

            $this->addFlash('success', $data->getFundName().' ' . $translator->trans('flash_message_create'));

            return $this->redirectToRoute('funds');
        }

        return $this->render('funds/fundsForm.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/funds/{id}/edit", name="funds_edit")
     * @IsGranted("ROLE_SERVICES_EDIT")
     */
    public function edit(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Funds::class)->find($id);

        if (!$data) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(FundsFormType::class, $data);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $em->persist($data);
            $em->flush();
            $id = $data->getId();

            $this->addFlash('success', $data->getFundName(). ' ' . $translator->trans('flash_message_edit'));

            return $this->redirectToRoute('funds');
        }

        return $this->render('funds/fundsForm.html.twig', [
            'form' => $form->createView(),
            'data' => $data,
            'id' => $id
        ]);
    }

    /**
     * @Route("/funds/{id}", name="funds_view")
     * @IsGranted("ROLE_SERVICES_VIEW")
     */
    public function view(EntityManagerInterface $em, Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Funds::class)->find($id);

        if (!$data) {
            throw $this->createNotFoundException();
        }

        return $this->render('funds/fund.html.twig', [
            'data' => $data,
            'club_name' => getenv('CLUB_NAME'),
        ]);
    }

    /**
     * @Route("/funds/{id}/delete", name="funds_delete")
     * @IsGranted("ROLE_SERVICES_DELETE")
     */
    public function delete(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
    {

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Funds::class)->find($id);

        if (!$data) {
            throw $this->createNotFoundException();
        }

        $em->remove($data);
        $em->flush();

        $this->addFlash('warning', $data->getFundName(). ' ' . $translator->trans('flash_message_delete'));

        return $this->redirectToRoute('funds');
    }

}
