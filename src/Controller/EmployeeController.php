<?php

namespace App\Controller;

use App\Entity\Organization;
use App\Entity\Person;
use App\Form\EmployeeFormType;
use App\Form\OrganizationsFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

class EmployeeController extends AbstractController
{
    /**
    * @Route("/organization/{id}/employee/edit", name="organization_employee_edit")
    * @IsGranted("ROLE_PERSON_EDIT")
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

    /**
     * @Route("/person/{id}/organizations/edit", name="person_organization_edit")
     * @IsGranted("ROLE_PERSON_EDIT")
     */
    public function edit_person(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
    {

        //get person object.
        $em = $this->getDoctrine()->getManager();
        $person = $em->getRepository(Person::class)->find($id);

        if (!$person) {
            throw $this->createNotFoundException();
        }

        //generate Form.
        $form = $this->createForm(OrganizationsFormType::class, $person);

        //Handle form.
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            //$person->AddOrganization($data->getOrganizations());

            $em->persist($data);
            $em->flush();

            $this->addFlash('success', $translator->trans('organizations').' '.$translator->trans('flash_message_edit'));

            return $this->redirectToRoute('person_id', array('id' => $id, '_fragment' => 'organizations'));
        }


        return $this->render('person/person-organizationsForm.html.twig', [
            'form' => $form->createView(),
            'id' => $id
        ]);

    }

}
