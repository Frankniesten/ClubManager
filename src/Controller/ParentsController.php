<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\ParentsFormType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

class ParentsController extends AbstractController
{
    /**
    * @Route("/person/{id}/parents/edit", name="person_parents_edit")
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
	    $form = $this->createForm(ParentsFormType::class, $person, array('personId' => $id));
		
		//Handle form.
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$person = $form->getData();
			$person->setUpdatedAt(new DateTime());
			$em->persist($person);
			$em->flush();
			
			$this->addFlash('success', $translator->trans('Parents').' '.$translator->trans('flash_message_edit'));

            return $this->redirectToRoute('person_id', array('id' => $id, '_fragment' => 'parents'));
		}

		return $this->render('person/person-parentsForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);	
	}
	
}
