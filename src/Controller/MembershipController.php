<?php

namespace App\Controller;

use App\Entity\Membership;
use App\Entity\Person;
use App\Form\MembershipFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MembershipYears;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

class MembershipController extends AbstractController
{
	
	
    /**
    * @Route("/person/{id}/membership/create", name="person_membership_create")
    * @IsGranted("ROLE_PERSON_CREATE")
    */
    public function new(EntityManagerInterface $em, Request $request, $id, MembershipYears $MembershipYears, TranslatorInterface $translator)
    {
	    //get person object.
	    $em = $this->getDoctrine()->getManager();
		$person = $em->getRepository(Person::class)->find($id);
		
		if (!$person) {
        	throw $this->createNotFoundException();
    	}
	    
		//generate Form.
	    $form = $this->createForm(MembershipFormType::class);
		
		//Handle form.
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$membership = $form->getData();
			$person->addMembership($membership);
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($membership);
			$em->persist($person);
			$em->flush();

			$this->addFlash('success', $translator->trans('Membership').' '. $translator->trans('flash_message_create'));
			
			//Call function to calculate total years and store it in the DB.
			$totalYears = $MembershipYears->MembershipYears($id);

            return $this->redirectToRoute('person_id', array('id' => $id, '_fragment' => 'membership'));
		}

		return $this->render('person/person-membershipForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);	
	}

	
	/**
	* @Route("/person/{id}/membership/{membershipID}/edit", name="person_membership_edit")
	* @IsGranted("ROLE_PERSON_EDIT")
	*/
	public function edit(EntityManagerInterface $em, Request $request, $id, $membershipID, MembershipYears $MembershipYears, TranslatorInterface $translator)
	{
		$em = $this->getDoctrine()->getManager();
		$membership = $em->getRepository(Membership::class)->find($membershipID);
		
		if (!$membership) {
        	throw $this->createNotFoundException();
    	}
		        
        
		$form = $this->createForm(MembershipFormType::class, $membership);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$membership = $form->getData();
			
			$em->persist($membership);
			$em->flush();
           
			$this->addFlash('success',$translator->trans('Membership').' '. $translator->trans('flash_message_edit'));
			
			//Call function to calculate total years and store it in the DB.
			$totalYears = $MembershipYears->MembershipYears($id);
			
			return $this->redirectToRoute('person_id', array('id' => $id, '_fragment' => 'membership'));
		}

		return $this->render('person/person-membershipForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $membership,
        	'id' => $id
		]);
	}


	/**
	* @Route("/person/{id}/membership/{membershipID}/delete", name="person_membership_delete")
	* @IsGranted("ROLE_PERSON_DELETE")
	*/
	public function delete(EntityManagerInterface $em, Request $request, $id, $membershipID, MembershipYears $MembershipYears, TranslatorInterface $translator)
	{
		
		$em = $this->getDoctrine()->getManager();
		$membership = $em->getRepository(Membership::class)->find($membershipID);
		
		if (!$membership) {
        	throw $this->createNotFoundException();
    	}
		        
		$em->remove($membership);
		$em->flush();
		
		$this->addFlash('warning', $translator->trans('Membership').' '. $translator->trans('flash_message_delete'));
		
		//Call function to calculate total years and store it in the DB.
		$totalYears = $MembershipYears->MembershipYears($id);

        return $this->redirectToRoute('person_id', array('id' => $id, '_fragment' => 'membership'));
	}    
}
