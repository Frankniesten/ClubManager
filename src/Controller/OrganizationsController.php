<?php

namespace App\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MessageGenerator;

class OrganizationsController extends AbstractController
{
    /**
     * @Route("/organizations", name="organizations")
     */
    public function index()
    {
        return $this->render('organizations/index.html.twig', [
            'controller_name' => 'OrganizationsController',
        ]);
    }



}