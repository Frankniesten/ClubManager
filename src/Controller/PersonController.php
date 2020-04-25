<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Person;
use App\Form\PersonFormType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class PersonController extends AbstractController
{
    /**
     * @Route("/person", name="person")
     * @IsGranted("ROLE_PERSON_VIEW")
     */
    public function list(SessionInterface $session, EntityManagerInterface $em, Request $request)
    {
        $query = null;
        $roles = null;

        //Check memberOf query:
        if ($query = $request->query->get('category')) {
            $session->set('people_query', $query);
        }
        else {
            $query = $session->get('people_query', 'all');
        }

        //Get all persons:
        if ($query == 'all') {
            $query = $session->get('people_query', 'all');
            $data = $this->getDoctrine()
                ->getRepository(Person::class)
                ->findAll();
        }

        //Get persons from specific memberOf:
        else {
            $em = $this->getDoctrine()->getManager();
            $data = $em->getRepository(Person::class)->findByCategegory($query);
        }

        //Check for roles query:
        if ($roles = $request->query->get('roles')) {
            $em = $this->getDoctrine()->getManager();
            $data = $em->getRepository(Person::class)->findByMemberOfProgramName($roles);
        }

        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(Category::class)->findCategoryType('person');

        return $this->render('person/people.html.twig', [
            'data' => $data,
            'club_name' => getenv('CLUB_NAME'),
            'category' => $category,
            'query' => $query,
            'roles' => $roles
        ]);
    }


    /**
     * @Route("/person/create", name="person_create")
     * @IsGranted("ROLE_PERSON_CREATE")
     */
    public function create(EntityManagerInterface $em, Request $request, TranslatorInterface $translator)
    {
        $form = $this->createForm(PersonFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $em->persist($data);
            $em->flush();
            $id = $data->getId();

            $this->addFlash('success', $data->getFamilyName() . ', ' . $data->getGivenName() . ' ' . $data->getAdditionalName() . ' ' . $translator->trans('flash_message_create'));

            return $this->redirectToRoute('person_id', array('id' => $id));
        }

        return $this->render('person/personForm.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/person/{id}", name="person_id")
     * @IsGranted("ROLE_PERSON_VIEW")
     */
    public function show(EntityManagerInterface $em, Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Person::class)->find($id);

        if (!$data) {
            throw $this->createNotFoundException();
        }

        //Call Log File:
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry');
        $log = $em->find('App\Entity\Person', $id);
        $logs = $repo->getLogEntries($log);

        return $this->render('person/person.html.twig', [
            'data' => $data,
            'logs' => $logs
        ]);
    }

    /**
     * @Route("/person/{id}/edit", name="person_edit")
     * @IsGranted("ROLE_PERSON_EDIT")
     */
    public function edit(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Person::class)->find($id);

        if (!$data) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(PersonFormType::class, $data);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $em->persist($data);
            $em->flush();

            $this->addFlash('success', $data->getFamilyName() . ', ' . $data->getGivenName() . ' ' . $data->getAdditionalName() . ' ' . $translator->trans('flash_message_edit'));

            return $this->redirectToRoute('person_id', array('id' => $id));
        }

        return $this->render('person/personForm.html.twig', [
            'form' => $form->createView(),
            'data' => $data
        ]);
    }


    /**
     * @Route("/person/{id}/delete", name="person_delete")
     * @IsGranted("ROLE_PERSON_DELETE")
     */
    public function del(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Person::class)->find($id);
        if (!$data) {
            throw $this->createNotFoundException();
        }

        $em->remove($data);
        $em->flush();

        $this->addFlash('warning', $data->getFamilyName() . ', ' . $data->getGivenName() . ' ' . $data->getAdditionalName() . ' ' . $translator->trans('flash_message_delete'));

        return $this->redirectToRoute('person');
    }
}