<?php

namespace App\Controller;

use App\Entity\ProgramMembership;
use App\Form\ProgramMembershipAddFormType;
use App\Form\ProgramMembershipFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;
 
class ProgramMembershipController extends AbstractController
{
	
    /**
     * @Route("/programmemberships", name="program_memberships")
     * @IsGranted("ROLE_SETTINGS_VIEW")
     */
	public function list(EntityManagerInterface $em, Request $request)
	{
		$programMembership = $this->getDoctrine()
        ->getRepository(ProgramMembership::class)
        ->findAll();
		
				
		return $this->render('programMemberships/programMemberships.html.twig', [
        	'data' => $programMembership
		]);
	}
	
	
	/**
     * @Route("/settings/programmembership/create", name="program_membership_create")
     * @IsGranted("ROLE_SETTINGS_CREATE")
     */
	public function new(EntityManagerInterface $em, Request $request, TranslatorInterface $translator)
	{
		
		$form = $this->createForm(ProgramMembershipFormType::class);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$programMembership = $form->getData();
						
			$em->persist($programMembership);
			$em->flush();

            $this->addFlash('success', $programMembership->getProgramName().' '. $translator->trans('flash_message_create'));
			
			return $this->redirectToRoute('program_memberships');
		}
		
		return $this->render('programMemberships/programMembershipsForm.html.twig', [
        	'form' => $form->createView()
		]);
	}
	
	
	/**
     * @Route("/settings/programmembership/{id}/edit", name="program_membership_edit")
     * @IsGranted("ROLE_SETTINGS_EDIT")
     */
	public function edit(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
	{
		$em = $this->getDoctrine()->getManager();
		$programMembership = $em->getRepository(ProgramMembership::class)->find($id);
		        
        if (!$programMembership) {
        	throw $this->createNotFoundException();
    	}
    	
		$form = $this->createForm(ProgramMembershipFormType::class, $programMembership);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$programMembership = $form->getData();
			
			$em->persist($programMembership);
			$em->flush();

            $this->addFlash('success', $programMembership->getProgramName().' '. $translator->trans('flash_message_edit'));
			
			return $this->redirectToRoute('program_memberships');
		}
		
		return $this->render('programMemberships/programMembershipsForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $programMembership
		]);
	}


    /**
     * @Route("/settings/programmembership/{id}/add", name="program_membership_add")
     * @IsGranted("ROLE_SETTINGS_EDIT")
     */
    public function add(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
    {
        $em = $this->getDoctrine()->getManager();
        $programMembership = $em->getRepository(ProgramMembership::class)->find($id);

        if (!$programMembership) {
            throw $this->createNotFoundException();
        }



        $form = $this->createForm(ProgramMembershipAddFormType::class, $programMembership);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $programMembership = $form->getData();

            $em->persist($programMembership);
            $em->flush();

            $this->addFlash('success', $programMembership->getProgramName().' '. $translator->trans('flash_message_edit'));

            return $this->redirectToRoute('program_memberships');
        }

        return $this->render('programMemberships/programMembershipsAddForm.html.twig', [
            'form' => $form->createView(),
            'data' => $programMembership
        ]);
    }
	
	
	/**
     * @Route("/settings/programmembership/{id}/delete", name="program_membership_delete")
     * @IsGranted("ROLE_SETTINGS_DELETE")
     */
	public function delete(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
	{
		$em = $this->getDoctrine()->getManager();
		$programMembership = $em->getRepository(ProgramMembership::class)->find($id);
		
		if (!$programMembership) {
        	throw $this->createNotFoundException();
    	}

			$em->remove($programMembership);
			$em->flush();

        $this->addFlash('warning', $programMembership->getProgramName().' '. $translator->trans('flash_message_delete'));
			
			return $this->redirectToRoute('program_memberships');
	}
}
