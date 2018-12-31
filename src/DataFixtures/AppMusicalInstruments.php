<?php

namespace App\DataFixtures;

use App\Entity\MusicalInstrument;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppMusicalInstruments extends Fixture
{
    public function load(ObjectManager $manager)
    {
       $musicalInstrument = new MusicalInstrument();
       $musicalInstrument->setMusicalInstrument('Blokfluit');
       $manager->persist($musicalInstrument);

	   $musicalInstrument = new MusicalInstrument();
       $musicalInstrument->setMusicalInstrument('Saxofoon-Sopraan');
       $manager->persist($musicalInstrument);

	   $musicalInstrument = new MusicalInstrument();
       $musicalInstrument->setMusicalInstrument('Saxofoon-Alt');
       $manager->persist($musicalInstrument);

	   $musicalInstrument = new MusicalInstrument();
       $musicalInstrument->setMusicalInstrument('Saxofoon-Tenor');
       $manager->persist($musicalInstrument);

	   $musicalInstrument = new MusicalInstrument();
       $musicalInstrument->setMusicalInstrument('Saxofoon-Bariton');
       $manager->persist($musicalInstrument);

	   $musicalInstrument = new MusicalInstrument();
       $musicalInstrument->setMusicalInstrument('Bugel');
       $manager->persist($musicalInstrument);

	   $musicalInstrument = new MusicalInstrument();
       $musicalInstrument->setMusicalInstrument('Trompet');
       $manager->persist($musicalInstrument);

	   $musicalInstrument = new MusicalInstrument();
       $musicalInstrument->setMusicalInstrument('Trombone');
       $manager->persist($musicalInstrument);
       
       $musicalInstrument = new MusicalInstrument();
       $musicalInstrument->setMusicalInstrument('Bastrombone');
       $manager->persist($musicalInstrument);

	   $musicalInstrument = new MusicalInstrument();
       $musicalInstrument->setMusicalInstrument('Hoorn');
       $manager->persist($musicalInstrument);
       
       $musicalInstrument = new MusicalInstrument();
       $musicalInstrument->setMusicalInstrument('Tuba');
       $manager->persist($musicalInstrument);
       
       $musicalInstrument = new MusicalInstrument();
       $musicalInstrument->setMusicalInstrument('Bas-Bes');
       $manager->persist($musicalInstrument);
       
       $musicalInstrument = new MusicalInstrument();
       $musicalInstrument->setMusicalInstrument('Bas-Es');
       $manager->persist($musicalInstrument);
       
       $musicalInstrument = new MusicalInstrument();
       $musicalInstrument->setMusicalInstrument('Slagwerk');
       $manager->persist($musicalInstrument);

       $manager->flush();
    }
}
