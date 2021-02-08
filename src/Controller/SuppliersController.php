<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\SuppliersFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

class SuppliersController extends AbstractController
{
    /**
    * @Route("/event/{id}/suppliers/edit", name="suppliers_edit")
    * @IsGranted("ROLE_EVENT_EDIT")
    */
    public function edit(EntityManagerInterface $em, Request $request, $id, TranslatorInterface $translator)
    {
	    //get person object.
	    $em = $this->getDoctrine()->getManager();
		$data = $em->getRepository(Event::class)->find($id);

		if (!$data) {
        	throw $this->createNotFoundException();
    	}

		//generate Form.
	    $form = $this->createForm(SuppliersFormType::class, $data);

		//Handle form.
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			$suppliers = $form->getData();
			$em->persist($suppliers);
			$em->flush();

			$this->addFlash('success', $translator->trans('Supplier_updated'));

            return $this->redirectToRoute('event_id', array('id' => $id, '_fragment' => 'suppliers'));
		}

		return $this->render('event/event-suppliersForm.html.twig', [
        	'form' => $form->createView(),
        	'id' => $id
		]);
	}
}
