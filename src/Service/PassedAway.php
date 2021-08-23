<?php

// src/Service/PassedAway.php
namespace App\Service;


use App\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PassedAway extends AbstractController
{

    public function processPassedAway($id)
    {
        //Get passed away person:
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Person::class)->find($id);

        //End membership
        $membership = $data->getMembership();
        foreach ($membership as $key => $value) {

            if (!$value->getEndDate()) {

                $value = $value->setEndDate($data->getDeathDate());
                $data->addMembership($value);
                $em->flush();
            }
        }

        //Delete employment
        $employee = $data->getOrganizations();
        foreach ($employee as $key => $value) {

            $data->removeOrganization($value);
            $em->flush();
        }

        //Delete memberOf
        $memberOf = $data->getMemberOf();
        foreach ($memberOf as $key => $value) {

            $data->removeMemberOf($value);
            $em->flush();
        }

        //Delete tags
        $tag = $data->getTag();
        foreach ($tag as $key => $value) {

            $data->removeTag($value);
            $em->flush();
        }
    }

}