<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppCategorie extends Fixture
{
    public function load(ObjectManager $manager)
    {
	    //Person Fixtures
      	$categorie = new Categorie();
      	$categorie->setName('Lid');
      	$categorie->setDescription('Persoon met lidmaatschap van de vereniging');
      	$categorie->setAdditionalType('personen');
        $manager->persist($categorie);
        
        $categorie = new Categorie();
      	$categorie->setName('Relatie');
      	$categorie->setDescription('Persoon die product of dienst afneemt van de vereniging.');
      	$categorie->setAdditionalType('personen');
        $manager->persist($categorie);
        
        $categorie = new Categorie();
      	$categorie->setName('Abonnee');
      	$categorie->setDescription('Persoon die belangstelling heeft in product of dienst van de vereniging.');
      	$categorie->setAdditionalType('personen');
        $manager->persist($categorie);
        
        $categorie = new Categorie();
      	$categorie->setName('Potentional');
      	$categorie->setDescription('Persoon die mogelijk belangstelling heeft in product of dienst van de vereniging.');
      	$categorie->setAdditionalType('personen');
        $manager->persist($categorie);
        
        $categorie = new Categorie();
      	$categorie->setName('Prospect');
      	$categorie->setDescription('Persoon die mogelijk belangstelling heeft in lidmaatschap van de vereniging.');
      	$categorie->setAdditionalType('personen');
        $manager->persist($categorie);
        
        //Organization Fixtures
        $categorie = new Categorie();
      	$categorie->setName('Relatie');
      	$categorie->setDescription('Organisatie die product of dienst afneemt van de vereniging.');
      	$categorie->setAdditionalType('Organisaties');
        $manager->persist($categorie);
        
        $categorie = new Categorie();
      	$categorie->setName('Potentional');
      	$categorie->setDescription('Organisatie die mogelijk belangstelling heeft in product of dienst van de vereniging.');
      	$categorie->setAdditionalType('Organisaties');
        $manager->persist($categorie);
        
        //Product Fixtures
        $categorie = new Categorie();
      	$categorie->setName('Assets');
      	$categorie->setDescription('Bezittingen van de vereniging.');
      	$categorie->setAdditionalType('Producten');
        $manager->persist($categorie);
        
        $categorie = new Categorie();
      	$categorie->setName('Instrumenturium');
      	$categorie->setDescription('Instrumenten en assesoires die in het bezit zijn van de vereniging.');
      	$categorie->setAdditionalType('Producten');
        $manager->persist($categorie);
        
        $categorie = new Categorie();
      	$categorie->setName('Partituren');
      	$categorie->setDescription('Bladmuziek die in het bezit is van de vereniging.');
      	$categorie->setAdditionalType('Producten');
        $manager->persist($categorie);
        
        $manager->flush();
    }
}
