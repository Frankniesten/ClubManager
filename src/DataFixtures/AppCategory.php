<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppCategory extends Fixture
{

	public const CATEGORY = 'category';
	
    public function load(ObjectManager $manager)
    {
	    //Person Fixtures
      	$category = new Category();
      	$category->setName('Lid');
      	$category->setDescription('Persoon met lidmaatschap van de vereniging');
      	$category->setAdditionalType('person');
        $manager->persist($category);
        
        $this->addReference(self::CATEGORY, $category);
        
        $category = new Category();
      	$category->setName('Relatie');
      	$category->setDescription('Persoon die product of dienst afneemt van de vereniging.');
      	$category->setAdditionalType('person');
        $manager->persist($category);
        
        $category = new Category();
      	$category->setName('Abonnee');
      	$category->setDescription('Persoon die belangstelling heeft in product of dienst van de vereniging.');
      	$category->setAdditionalType('person');
        $manager->persist($category);
        
        $category = new Category();
      	$category->setName('Potentional');
      	$category->setDescription('Persoon die mogelijk belangstelling heeft in product of dienst van de vereniging.');
      	$category->setAdditionalType('person');
        $manager->persist($category);
        
        $category = new Category();
      	$category->setName('Prospect');
      	$category->setDescription('Persoon die mogelijk belangstelling heeft in lidmaatschap van de vereniging.');
      	$category->setAdditionalType('person');
        $manager->persist($category);
        
        //Organization Fixtures
        $category = new Category();
      	$category->setName('Relatie');
      	$category->setDescription('Organisatie die product of dienst afneemt van de vereniging.');
      	$category->setAdditionalType('organization');
        $manager->persist($category);
        
        $category = new Category();
      	$category->setName('Potentional');
      	$category->setDescription('Organisatie die mogelijk belangstelling heeft in product of dienst van de vereniging.');
      	$category->setAdditionalType('organization');
        $manager->persist($category);
        
        //Product Fixtures
        $category = new Category();
      	$category->setName('Assets');
      	$category->setDescription('Bezittingen van de vereniging.');
      	$category->setAdditionalType('product');
        $manager->persist($category);
        
        $category = new Category();
      	$category->setName('Instrumentarium');
      	$category->setDescription('Instrumenten en assesoires die in het bezit zijn van de vereniging.');
      	$category->setAdditionalType('product');
        $manager->persist($category);
        
        $category = new Category();
      	$category->setName('Partituren');
      	$category->setDescription('Bladmuziek die in het bezit is van de vereniging.');
      	$category->setAdditionalType('product');
        $manager->persist($category);
        
        $category = new Category();
      	$category->setName('Sponsoring');
      	$category->setDescription('Sponsor producten van de vereniging.');
      	$category->setAdditionalType('service');
        $manager->persist($category);
        
        $manager->flush();
    }
}
