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
      	$user->setRoles(array (
		  0 => 'ROLE_PERSON_VIEW',
		  1 => 'ROLE_PERSON_EDIT',
		  2 => 'ROLE_PERSON_CREATE',
		  3 => 'ROLE_PERSON_DELETE',
		  4 => 'ROLE_ORGANIZATION_VIEW',
		  5 => 'ROLE_ORGANIZATION_EDIT',
		  6 => 'ROLE_ORGANIZATION_CREATE',
		  7 => 'ROLE_ORGANIZATION_DELETE',
		  8 => 'ROLE_EVENT_VIEW',
		  9 => 'ROLE_EVENT_EDIT',
		  10 => 'ROLE_EVENT_CREATE',
		  11 => 'ROLE_EVENT_DELETE',
		  12 => 'ROLE_PRODUCT_VIEW',
		  13 => 'ROLE_PRODUCT_EDIT',
		  14 => 'ROLE_PRODUCT_CREATE',
		  15 => 'ROLE_PRODUCT_DELETE',
		  16 => 'ROLE_SERVICES_VIEW',
		  17 => 'ROLE_SERVICES_EDIT',
		  18 => 'ROLE_SERVICES_CREATE',
		  19 => 'ROLE_SERVICES_DELETE',
		  20 => 'ROLE_SETTINGS_VIEW',
		  21 => 'ROLE_SETTINGS_EDIT',
		  22 => 'ROLE_SETTINGS_CREATE',
		  23 => 'ROLE_SETTINGS_DELETE',
		  24 => 'ROLE_USERS_VIEW',
		  25 => 'ROLE_USERS_EDIT',
		  26 => 'ROLE_REVIEW_EDIT',
		  27 => 'ROLE_USERS_DELETE',
		  29 => 'ROLE_REVIEW_VIEW',
		  30 => 'ROLE_REVIEW_CREATE',
		  31 => 'ROLE_REVIEW_DELETE',
		));

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