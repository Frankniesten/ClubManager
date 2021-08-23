<?php

namespace App\Controller;

use App\Entity\AttendanceList;
use App\Entity\Presence;
use App\Form\AttendanceListFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\GenerateAttendanceList;

class AttendanceListController extends AbstractController
{
    /**
     * @Route("/attendance-list", name="attendance_list")
     * @IsGranted("ROLE_EVENT_VIEW")
     */
    public function index(): Response
    {
        $data = $this->GetDoctrine()
            ->getRepository(AttendanceList::class)
            ->findAll();


        return $this->render('attendance_list/attendanceLists.twig', [
            'data' => $data,
        ]);
    }

    /**
     * @Route("/attendance-list/create", name="attendance_list_create")
     * @IsGranted("ROLE_EVENT_CREATE")
     */
    public function create(EntityManagerInterface $em, Request $request, TranslatorInterface $translator, GenerateAttendanceList $generateAttendanceList )
    {

        $form = $this->createForm(AttendanceListFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $listName = $translator->trans('List name').'-'.$data->getEvent()->getAbout().' ('.$data->getEvent()->getStartDate()->format('d-m-Y').')';
            $data->setListName($listName);
            $em->persist($data);
            $em->flush();

            $listId = $data->getId();
            $generateAttendanceList->GenerateAttendanceList($listId);

            $this->addFlash('success', $data->getListName().' '.$translator->trans('flash_message_create'));
            return $this->redirectToRoute('attendance_list');

        }

        return $this->render('attendance_list/attendanceForm.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/attendance-list/{id}", name="attendance_list_id")
     * @IsGranted("ROLE_EVENT_VIEW")
     */
    public function show(EntityManagerInterface $em, Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(AttendanceList::class)->find($id);

        if (!$data) {
            throw $this->createNotFoundException();
        }

        return $this->render('attendance_list/attendanceList.twig', [
            'data' => $data
        ]);
    }

    /**
     * @Route("/attendance-list/{id}/delete", name="attendance_list_delete")
     * @IsGranted("ROLE_EVENT_DELETE")
     */
    public function del(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(AttendanceList::class)->find($id);

        if (!$data) {
            throw $this->createNotFoundException();
        }

        $em->remove($data);
        $em->flush();

        $this->addFlash('warning', $data->getListName(). ' ' . $translator->trans('flash_message_delete'));

        return $this->redirectToRoute('attendance_list');
    }

    /**
     * @Route("/attendance-list/presence/{id}", name="attendance_list_presence")
     */
    public function presence(EntityManagerInterface $em, Request $request, $id,TranslatorInterface $translator)
    {


        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {

            $em = $this->getDoctrine()->getManager();
            $data = $em->getRepository(Presence::class)->find($id);

            //Get data:
            $status = intval($request->request->get('status'));

            $data->setStatus($status);
            $em->persist($data);
            $em->flush();

            $jsonData = $data;
            return new JsonResponse($jsonData);
        }
        else {
            throw $this->createNotFoundException();
        }
    }
}
