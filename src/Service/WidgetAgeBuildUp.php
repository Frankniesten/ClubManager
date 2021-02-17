<?php
// src/Service/WidgetAgeBuildUp.php

namespace App\Service;

use App\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WidgetAgeBuildUp extends AbstractController
{
	public function WidgetAgeBuildUp()
    {
        $em = $this->getDoctrine()->getManager();
        $people = $em->getRepository(Person::class)->findByCategegory(1);

        //Calculate distribution per 5 years:
        $age00 = 0;
        $age05 = 0;
        $age10 = 0;
        $age15 = 0;
        $age20 = 0;
        $age25 = 0;
        $age30 = 0;
        $age35 = 0;
        $age40 = 0;
        $age45 = 0;
        $age50 = 0;
        $age55 = 0;
        $age60 = 0;
        $age65 = 0;
        $age70 = 0;
        $age75 = 0;
        $age80 = 0;
        $age85 = 0;
        $age90 = 0;
        $age95 = 0;


        foreach ($people as $key => $value)
        {

            $birthdate = $value->getBirthDate();
            $birthdate = $birthdate->format('Y');


            $currentDate = new \DateTime();
            $currentDate = $currentDate->format('Y');


            $age = $currentDate - $birthdate;


            if ($age >= 0 AND $age <= 5){

                ++$age00;
            }
            else if ($age >= 6 AND $age <= 10){

                ++$age05;
            }
            else if ($age >= 11 AND $age <= 15){

                ++$age10;
            }
            else if ($age >= 16 AND $age <= 20){

                ++$age15;
            }
            else if ($age >= 21 AND $age <= 25){

                ++$age20;
            }
            else if ($age >= 26 AND $age <= 30){

                ++$age25;
            }
            else if ($age >= 31 AND $age <= 35){

                ++$age30;
            }
            else if ($age >= 36 AND $age <= 40){

                ++$age35;
            }
            else if ($age >= 41 AND $age <= 45){

                ++$age40;
            }
            else if ($age >= 46 AND $age <= 50){

                ++$age45;
            }
            else if ($age >= 51 AND $age <= 55){

                ++$age50;
            }
            else if ($age >= 56 AND $age <= 60){

                ++$age55;
            }
            else if ($age >= 61 AND $age <= 65){

                ++$age60;
            }
            else if ($age >= 66 AND $age <= 70){

                ++$age65;
            }
            else if ($age >= 71 AND $age <= 75){

                ++$age70;
            }
            else if ($age >= 76 AND $age <= 80){

                ++$age75;
            }
            else if ($age >= 81 AND $age <= 85){

                ++$age80;
            }
            else if ($age >= 86 AND $age <= 90){

                ++$age85;
            }
            else if ($age >= 91 AND $age <= 95){

                ++$age90;
            }
            else if ($age >= 96 AND $age <= 100){

                ++$age95;
            }
        }

        $ageDifference = array();
        $ageDifference['0']['name'] = '1-5';
        $ageDifference['0']['count'] = $age00;

        $ageDifference['1']['name'] = '6-10';
        $ageDifference['1']['count'] = $age05;

        $ageDifference['2']['name'] = '11-15';
        $ageDifference['2']['count'] = $age10;

        $ageDifference['3']['name'] = '16-20';
        $ageDifference['3']['count'] = $age15;

        $ageDifference['4']['name'] = '21-25';
        $ageDifference['4']['count'] = $age20;

        $ageDifference['5']['name'] = '26-30';
        $ageDifference['5']['count'] = $age25;

        $ageDifference['6']['name'] = '31-35';
        $ageDifference['6']['count'] = $age30;

        $ageDifference['7']['name'] = '36-40';
        $ageDifference['7']['count'] = $age35;

        $ageDifference['8']['name'] = '41-45';
        $ageDifference['8']['count'] = $age40;

        $ageDifference['9']['name'] = '46-50';
        $ageDifference['9']['count'] = $age45;

        $ageDifference['10']['name'] = '51-55';
        $ageDifference['10']['count'] = $age50;

        $ageDifference['11']['name'] = '56-60';
        $ageDifference['11']['count'] = $age55;

        $ageDifference['12']['name'] = '61-65';
        $ageDifference['12']['count'] = $age60;

        $ageDifference['13']['name'] = '66-70';
        $ageDifference['13']['count'] = $age65;

        $ageDifference['14']['name'] = '71-75';
        $ageDifference['14']['count'] = $age70;

        $ageDifference['15']['name'] = '76-80';
        $ageDifference['15']['count'] = $age75;

        $ageDifference['16']['name'] = '81-85';
        $ageDifference['16']['count'] = $age80;

        $ageDifference['17']['name'] = '86-90';
        $ageDifference['17']['count'] = $age85;

        $ageDifference['18']['name'] = '91-95';
        $ageDifference['18']['count'] = $age90;

        $ageDifference['19']['name'] = '96-100';
        $ageDifference['19']['count'] = $age95;
	    
		return $ageDifference;
	}
}