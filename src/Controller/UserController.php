<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Person;
use App\Form\UserCreateFormType;
use App\Form\UserEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class UserController extends AbstractController
{
    /**
     * @Route("/users", name="app_users")
     * @IsGranted("ROLE_USERS_VIEW")
     */
	public function list(EntityManagerInterface $em, Request $request)
	{
		$users = $this->getDoctrine()
        ->getRepository(User::class)
        ->findAll();
				
		return $this->render('user/users.html.twig', [
        	'data' => $users,
		]);
	}
	
	/**
     * @Route("/user/create", name="app_user_create")
     * @IsGranted("ROLE_USERS_EDIT")
     */
	public function new(EntityManagerInterface $em, Request $request)
	{
		$form = $this->createForm(UserCreateFormType::class);
		$form->handleRequest($request);
				
		if ($form->isSubmitted() && $form->isValid()) {

			$user = $form->getData();			
			$user->setUsername(strtolower($user->getPerson()->getGivenName().$user->getPerson()->getFamilyName()));
			$user->setDisplayName($user->getPerson()->getFamilyName().', '.$user->getPerson()->getGivenName().' '.$user->getPerson()->getAdditionalName());
			
			$em->persist($user);
			$em->flush();
			$id = $user->getId();

			$this->addFlash('success', 'Gebruiker '.$user->getPerson()->getFamilyName().', '.$user->getPerson()->getGivenName().' '.$user->getPerson()->getAdditionalName().' is aangemaakt!');
			
			return $this->redirectToRoute('app_user_edit', array('id' => $id));			
		}

		return $this->render('user/userCreateForm.html.twig', [
        	'form' => $form->createView()
		]);
	}
	
	/**
     * @Route("/user/{id}/edit", name="app_user_edit")
     * @IsGranted("ROLE_USERS_EDIT")
     */
	public function edit(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$user = $em->getRepository(User::class)->find($id);

		          
		$form = $this->createForm(UserEditFormType::class, $user);
		
		
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$user = $form->getData();
			
			$em->persist($user);
			$em->flush();
           
			$this->addFlash('success', 'Gebruiker '.$user->getPerson()->getFamilyName().', '.$user->getPerson()->getGivenName().' '.$user->getPerson()->getAdditionalName().' is bijgewerkt!');
			
			return $this->redirectToRoute('app_users');			
		}
		
		return $this->render('user/userEditForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $user
		]);
	}
	
	/**
     * @Route("/user/{id}/delete", name="user_delete")
     * @IsGranted("ROLE_USERS_DELETE")
     */
	public function delete(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$user = $em->getRepository(User::class)->find($id);

			$em->remove($user);
			$em->flush();
           
			$this->addFlash('warning', 'gebruiker is verwijderd!');
			
			return $this->redirectToRoute('app_users');			
	}
}
