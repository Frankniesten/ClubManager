<?php

namespace App\DataFixtures;

use App\Entity\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AppPerson extends Fixture implements DependentFixtureInterface
{
	public const PERSON = 'person';
		
    public function load(ObjectManager $manager)
    {
	    //Person Fixtures
      	$person = new Person();
      	$person->setGivenName('Beheerder');
      	$person->setAdditionalName('');
      	$person->setFamilyName('Beheerder');
      	$person->setEmail('beheerder@clubmanager.nl');
      	$person->setCategory($this->getReference(AppCategory::CATEGORY));

        $manager->persist($person);
        
        $this->addReference(self::PERSON, $person);
        
        $manager->flush();
    }
    
    public function getDependencies()
    {
        return array(
            AppProgramMemberships::class,
        );
    }
}
