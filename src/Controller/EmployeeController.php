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

class EmployeeController extends AbstractController
{
    /**
    * @Route("/organization/{id}/employee/create", name="app_organization_employee_create")
    */
    public function edit(EntityManagerInterface $em, Request $request, $id)
    {
	    //get person object.
	    $em = $this->getDoctrine()->getManager();
		$organization = $em->getRepository(Organization::class)->find($id);
	    
		//generate Form.
	    $form = $this->createForm(EmployeeFormType::class, $organization);
		
		//Handle form.
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$employee = $form->getData();
			$em->persist($employee);
			$em->flush();
			
			$this->addFlash('success', 'Medewerker: toegevoegd!');
					
			return $this->redirectToRoute('app_organization_employee', array('id' => $id));			
		}

		return $this->render('employee/employeeForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);	
	}
}
