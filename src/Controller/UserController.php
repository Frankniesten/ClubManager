<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserEditFormType;
use App\Form\UserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/settings/users", name="users")
     * @IsGranted("ROLE_SETTINGS_VIEW")
     */
	public function list(EntityManagerInterface $em, Request $request)
	{
        $data = $this->getDoctrine()
        ->getRepository(User::class)
        ->findAll();
				
		return $this->render('user/users.html.twig', [
        	'data' => $data,
		]);
	}
	
	/**
     * @Route("/settings/user/create", name="user_create")
     * @IsGranted("ROLE_SETTINGS_CREATE")
     */
	public function new(EntityManagerInterface $em, Request $request, TranslatorInterface $translator)
	{
		$form = $this->createForm(UserFormType::class);
		$form->handleRequest($request);
				
		if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $data->setUsername(strtolower($data->getPerson()->getGivenName().$data->getPerson()->getFamilyName()));
            $data->setDisplayName($data->getPerson()->getFamilyName().', '.$data->getPerson()->getGivenName().' '.$data->getPerson()->getAdditionalName());
			
			$em->persist($data);
			$em->flush();
			$id = $data->getId();

            $this->addFlash('success', $data->getPerson()->getFamilyName() . ', ' . $data->getPerson()->getGivenName() . ' ' . $data->getPerson()->getAdditionalName() . ' ' . $translator->trans('flash_message_create'));

			return $this->redirectToRoute('users', array('id' => $id));
		}

		return $this->render('user/userForm.html.twig', [
        	'form' => $form->createView()
		]);
	}
	
	/**
     * @Route("/settings/user/{id}/edit", name="user_edit")
     * @IsGranted("ROLE_SETTINGS_EDIT")
     */
	public function edit(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
	{
		$em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(User::class)->find($id);
		
		if (!$data) {
        	throw $this->createNotFoundException();
    	}

		$form = $this->createForm(UserEditFormType::class, $data);
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
			
			$em->persist($data);
			$em->flush();

            $this->addFlash('success', $data->getPerson()->getFamilyName() . ', ' . $data->getPerson()->getGivenName() . ' ' . $data->getPerson()->getAdditionalName() . ' ' . $translator->trans('flash_message_edit'));
			
			return $this->redirectToRoute('users');
		}
		
		return $this->render('user/userForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $data
		]);
	}
	
	/**
     * @Route("/settings/user/{id}/delete", name="user_delete")
     * @IsGranted("ROLE_SETTINGS_DELETE")
     */
	public function delete(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
	{
		$em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(User::class)->find($id);
		
		if (!$data) {
        	throw $this->createNotFoundException();
    	}

			$em->remove($data);
			$em->flush();

        $this->addFlash('warning', $data->getPerson()->getFamilyName(). ', ' . $data->getPerson()->getGivenName() . $data->getPerson()->getAdditionalName() . ' ' . $translator->trans('flash_message_delete'));
			
			return $this->redirectToRoute('users');
	}
}
