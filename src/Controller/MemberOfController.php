<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\MemberOfFormType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

class MemberOfController extends AbstractController
{
    /**
    * @Route("/person/{id}/memberof/create", name="person_memberOf")
    * @IsGranted("ROLE_PERSON_EDIT")
    */
    public function edit(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
    {
	    //get person object.
	    $em = $this->getDoctrine()->getManager();
		$person = $em->getRepository(Person::class)->find($id);
		
		if (!$person) {
        	throw $this->createNotFoundException();
    	}
	    
		//generate Form.
	    $form = $this->createForm(MemberOfFormType::class, $person);
		
		//Handle form.
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$person = $form->getData();
			$person->setUpdatedAt(new DateTime());
			$em->persist($person);
			$em->flush();
           
			$this->addFlash('success', $translator->trans('MemberOf_updated'));
					
			return $this->redirectToRoute('person_id', array('id' => $id, '_fragment' => 'memberOf'));
		}

		return $this->render('person/person-memberofForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);	
	}
}
