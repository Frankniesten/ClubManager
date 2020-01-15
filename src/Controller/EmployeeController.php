<?php

namespace App\Controller;

use App\Entity\Organization;
use App\Entity\Person;
use App\Form\EmployeeFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

class EmployeeController extends AbstractController
{
    /**
    * @Route("/organization/{id}/employee/edit", name="organization_employee_edit")
    * @IsGranted("ROLE_ORGANIZATION_EDIT")
    */
    public function edit(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
    {
	    //get person object.
	    $em = $this->getDoctrine()->getManager();
		$organization = $em->getRepository(Organization::class)->find($id);
		
		if (!$organization) {
        	throw $this->createNotFoundException();
    	}
	    
		//generate Form.
	    $form = $this->createForm(EmployeeFormType::class, $organization);
		
		//Handle form.
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$employee = $form->getData();
			$em->persist($employee);
			$em->flush();

            $this->addFlash('success', $translator->trans('Employees').' '.$translator->trans('flash_message_edit'));

            return $this->redirectToRoute('organization_id', array('id' => $id, '_fragment' => 'employee'));
		}

		return $this->render('organization/organization-employeeForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);	
	}
}
