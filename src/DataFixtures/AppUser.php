<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AppUser extends Fixture implements DependentFixtureInterface
{
		
    public function load(ObjectManager $manager)
    {
	    //Person Fixtures
      	$user = new User();
      	$user->setUsername('beheerder');
      	$user->setDisplayName('beheerder');
      	$user->setPerson($this->getReference(AppPerson::PERSON));
      	$user->setRoles(array());

        $manager->persist($user);
        
        $manager->flush();
    }
    
    public function getDependencies()
    {
        return array(
            AppPerson::class,
        );
    }
}