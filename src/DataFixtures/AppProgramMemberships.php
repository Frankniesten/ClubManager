<?php

namespace App\DataFixtures;

use App\Entity\ProgramMembership;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppProgramMemberships extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $memberOf = new ProgramMembership();
		$memberOf->setProgramName('beheerder');
		$memberOf->setDescription('Beheerder van cloud Omgeving.');
       	$manager->persist($memberOf);
       	
       	$memberOf = new ProgramMembership();
		$memberOf->setProgramName('Voorzitter');
		$memberOf->setDescription('Voorzitter van de vereniging.');
       	$manager->persist($memberOf);
       	
       	$memberOf = new ProgramMembership();
		$memberOf->setProgramName('Vice-Voorzitter');
		$memberOf->setDescription('Vice-Voorzitter van de vereniging.');
       	$manager->persist($memberOf);
       	
       	$memberOf = new ProgramMembership();
		$memberOf->setProgramName('Secretaris');
		$memberOf->setDescription('Secretaris van de vereniging.');
       	$manager->persist($memberOf);
       	
       	$memberOf = new ProgramMembership();
		$memberOf->setProgramName('Penningmeester');
		$memberOf->setDescription('Penningmeester van de vereniging.');
       	$manager->persist($memberOf);
       	
       	$memberOf = new ProgramMembership();
		$memberOf->setProgramName('Creative Director');
		$memberOf->setDescription('Creative Director van de vereniging.');
       	$manager->persist($memberOf);
       	
       	$memberOf = new ProgramMembership();
		$memberOf->setProgramName('Kernteamlid');
		$memberOf->setDescription('Lid van het kernteam dat het bestuur van de vereniging vormt.');
       	$manager->persist($memberOf);

        $manager->flush();
    }
}
