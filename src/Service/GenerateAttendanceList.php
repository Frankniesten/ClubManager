<?php

// src/Service/GenerateAttendanceList.php
namespace App\Service;


use App\Entity\AttendanceList;
use App\Entity\Presence;
use App\Entity\ProgramMembership;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class GenerateAttendanceList extends AbstractController
{
    public function GenerateAttendanceList($id)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(AttendanceList::class)->find($id);

        if (!$data) {
            throw $this->createNotFoundException();
        }

        //Get all people from the programMembership.
        $people = $em->getRepository(ProgramMembership::class)->find($data->getProgramMembership()->getId());

        foreach ($people->getPeople() as $key => $value)
        {
            $presence = new Presence();
            $presence->setPerson($value);
            $presence->setAttendanceList($data);

            // tell Doctrine you want to (eventually) save the Presence (no queries yet)
            $em->persist($presence);

            // actually executes the queries (i.e. the INSERT query)
            $em->flush();
        }
    }
}