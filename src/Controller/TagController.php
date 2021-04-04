<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Person;
use App\Form\TagFormType;
use DateTime;
use App\Form\TagAddFormType;
use App\Form\TagEditFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class TagController extends AbstractController
{
    /**
     * @Route("/tag", name="tag")
     * @IsGranted("ROLE_PERSON_VIEW")
     */
    public function index(): Response
    {
        $data = $this->GetDoctrine()
            ->getRepository(Tag::class)
            ->findAll();



        return $this->render('tag/tags.html.twig', [
            'data' => $data,
        ]);
    }


    /**
     * @Route("/tag/create", name="tag_create")
     * @IsGranted("ROLE_PERSON_CREATE")
     */
    public function create(EntityManagerInterface $em, Request $request, TranslatorInterface $translator)
    {
        $form = $this->createForm(TagFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $em->persist($data);
            $em->flush();

            $this->addFlash('success', $data->getTag().' '.$translator->trans('flash_message_create'));
            return $this->redirectToRoute('tag');
        }

        return $this->render('tag/tagForm.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/tag/{id}/add", name="tag_add")
     * @IsGranted("ROLE_PERSON_EDIT")
     */
    public function add(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
    {
        $em = $this->getDoctrine()->getManager();
        $tag = $em->getRepository(Tag::class)->find($id);

        if (!$tag) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(TagAddFormType::class, $tag);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $tag = $form->getData();

            $em->persist($tag);
            $em->flush();

            //$this->addFlash('success', $programMembership->getProgramName().' '. $translator->trans('flash_message_edit'));

            return $this->redirectToRoute('tag');
        }

        return $this->render('tag/tagAddForm.html.twig', [
            'form' => $form->createView(),
            'data' => $tag
        ]);
    }

    /**
     * @Route("/tag/{id}/edit", name="tag_edit")
     * @IsGranted("ROLE_PERSON_EDIT")
     */
    public function edit(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Tag::class)->find($id);

        if (!$data) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(TagFormType::class, $data);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $em->persist($data);
            $em->flush();

            $this->addFlash('success', $data->getTag().' '.$translator->trans('flash_message_edit'));

            return $this->redirectToRoute('tag');
        }

        return $this->render('tag/tagForm.html.twig', [
            'form' => $form->createView(),
            'data' => $data
        ]);
    }

    /**
     * @Route("/tag/{id}/delete", name="tag_delete")
     * @IsGranted("ROLE_PERSON_DELETE")
     */
    public function del(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Tag::class)->find($id);
        if (!$data) {
            throw $this->createNotFoundException();
        }

        $em->remove($data);
        $em->flush();

        $this->addFlash('warning', $data->getTag().' '.$translator->trans('flash_message_delete'));

        return $this->redirectToRoute('tag');
    }


    /**
     * @Route("/person/{id}/tag/edit", name="person_tag")
     * @IsGranted("ROLE_PERSON_EDIT")
     */
    public function editTags(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
    {
        //get person object.
        $em = $this->getDoctrine()->getManager();
        $person = $em->getRepository(Person::class)->find($id);

        if (!$person) {
            throw $this->createNotFoundException();
        }

        //generate Form.
        $form = $this->createForm(TagEditFormType::class, $person);

        //Handle form.
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $person = $form->getData();
            $person->setUpdatedAt(new DateTime());
            $em->persist($person);
            $em->flush();

            $this->addFlash('success', $translator->trans('MemberOf_updated'));

            return $this->redirectToRoute('person_id', array('id' => $id, '_fragment' => 'tag'));
        }

        return $this->render('person/person-tagForm.html.twig', [
            'form' => $form->createView(),
            'id' => $id
        ]);
    }
}