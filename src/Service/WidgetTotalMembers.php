<?php
// src/Service/WidgetTotalMembers.php

namespace App\Service;

use App\Entity\Person;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WidgetTotalMembers extends AbstractController
{
	public function WidgetTotalMembers()
    {
	    $countMembers = array();
	    
	    //Get all categories:
	    $category = $this->getDoctrine()
	    ->getRepository(Category::class)->findCategoryType('person');
	    
	    //Count number of members per category:
	    foreach ($category as $key => $value)
	    {
		   $members = $value->getId();
		    
		   $count = $this->getDoctrine()
		   ->getRepository(Person::class)->CountByCategegory($members);

		   $countMembers[$key]['name'] = $value->getName();
		   $countMembers[$key]['description'] = $value->getDescription();
		   $countMembers[$key]['count'] = $count;		    
	    }
	    
		return $countMembers;
	}
}