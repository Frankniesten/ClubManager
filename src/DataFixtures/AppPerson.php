<?php

namespace App\DataFixtures;

use App\Entity\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppPerson extends Fixture
{
    public function load(ObjectManager $manager)
    {
	    //Person Fixtures
      	$person = new Person();
      	$person->setGivenName('Beheerder');
      	$person->setAdditionalName('');
      	$person->setFamilyName('Beheerder');
      	$person->setEmail('beheerder@sintgabriel.nl');
        $manager->persist($person);
        
        $manager->flush();
    }
}
