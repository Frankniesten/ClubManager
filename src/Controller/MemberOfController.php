<?php

namespace App\Controller;

use App\Entity\ProgramMembership;
use App\Entity\Person;
use App\Form\MemberOfFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class MemberOfController extends AbstractController
{
    /**
    * @Route("/person/{id}/memberof/create", name="app_person_memberOf_edit")
    * @IsGranted("ROLE_PERSON_EDIT")
    */
    public function edit(EntityManagerInterface $em, Request $request, $id)
    {
	    //get person object.
	    $em = $this->getDoctrine()->getManager();
		$person = $em->getRepository(Person::class)->find($id);
	    
		//generate Form.
	    $form = $this->createForm(MemberOfFormType::class, $person);
		
		//Handle form.
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$person = $form->getData();
			
			$em->persist($person);
			$em->flush();
           
			$this->addFlash('success', 'Rol bij: '.$person->getFamilyName().', '.$person->getGivenName().' '.$person->getAdditionalName().'aangepast!');
					
			return $this->redirectToRoute('app_person_memberOf', array('id' => $id));			
		}

		return $this->render('member_of/memberofForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);	
	}
}
