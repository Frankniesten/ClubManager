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
		$memberOf->setProgramName('Beheerder');
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
       	
       	$memberOf = new ProgramMembership();
		$memberOf->setProgramName('Fanfare-Orkest');
		$memberOf->setDescription('Lid van het fanfare-orkest.');
       	$manager->persist($memberOf);
       	
	   	$memberOf = new ProgramMembership();
		$memberOf->setProgramName('jeugdfanfare-Orkest');
		$memberOf->setDescription('Lid van het jeugdfanfare-orkest.');
       	$manager->persist($memberOf);
       	
       	$memberOf = new ProgramMembership();
		$memberOf->setProgramName('Kapel');
		$memberOf->setDescription('Lid van de kapel.');
       	$manager->persist($memberOf);
       	
       	$memberOf = new ProgramMembership();
		$memberOf->setProgramName('Leerling');
		$memberOf->setDescription('Persoon die muziekles volgt via de vereniging.');
       	$manager->persist($memberOf);
       	
       	$memberOf = new ProgramMembership();
		$memberOf->setProgramName('Uithulp');
		$memberOf->setDescription('Relaties die de vereniging muzikaal uithelpen.');
       	$manager->persist($memberOf);

        $manager->flush();
    }
}
