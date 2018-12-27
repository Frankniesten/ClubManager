<?php

namespace App\Controller;

use App\Entity\Membership;
use App\Entity\Person;
use App\Form\MembershipFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Utils\MembershipYears;

class MembershipController extends AbstractController
{
	
	
    /**
    * @Route("/person/{id}/membership/create", name="app_person_membership_create")
    */
    public function newMembership(EntityManagerInterface $em, Request $request, $id, MembershipYears $MembershipYears)
    {
	    //get person object.
	    $em = $this->getDoctrine()->getManager();
		$person = $em->getRepository(Person::class)->find($id);
	    
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

			$this->addFlash('success', 'Lidmaatschap aan: '.$person->getFamilyName().', '.$person->getGivenName().' '.$person->getAdditionalName().' toegevoegd!');
			
			//Call function to calculate total years and store it in the DB.
			$totalYears = $MembershipYears->MembershipYears($id);
			
			return $this->redirectToRoute('app_person_membership', array('id' => $id));			
		}

		return $this->render('membership/membershipForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);	
	}

	
	/**
	* @Route("/person/{$id}/membership/{membershipID}/edit", name="app_person_membership_edit")
	*/
	public function editMembership(EntityManagerInterface $em, Request $request, $id, $membershipID, MembershipYears $MembershipYears)
	{
		$em = $this->getDoctrine()->getManager();
		$membership = $em->getRepository(Membership::class)->find($membershipID);
		        
        
		$form = $this->createForm(MembershipFormType::class, $membership);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$membership = $form->getData();
			
			$em->persist($membership);
			$em->flush();
           
			$this->addFlash('success', 'Lidmaatschap is bijgewerkt!');
			
			//Call function to calculate total years and store it in the DB.
			$totalYears = $MembershipYears->MembershipYears($id);
			
			return $this->redirectToRoute('app_person_membership', array('id' => $id));			
		}
		
		return $this->render('membership/membershipForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $membership,
        	'id' => $id
		]);
	}


	/**
	* @Route("/person/{id}/membership/{membershipID}/delete", name="app_person_membership_delete")
	*/
	public function deleteMembership(EntityManagerInterface $em, Request $request, $id, $membershipID, MembershipYears $MembershipYears)
	{
		
		$em = $this->getDoctrine()->getManager();
		$membership = $em->getRepository(Membership::class)->find($membershipID);
		        
		$em->remove($membership);
		$em->flush();
		
		$this->addFlash('warning', 'Lidmaatschap is verwijderd!');
		
		//Call function to calculate total years and store it in the DB.
		$totalYears = $MembershipYears->MembershipYears($id);
		
		return $this->redirectToRoute('app_person', array('id' => $id));	
	}    
}
