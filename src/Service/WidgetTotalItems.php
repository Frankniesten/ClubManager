<?php
// src/Service/WidgetTotalItems.php

namespace App\Service;

use App\Entity\Organization;
use App\Entity\Person;
use App\Entity\Category;
use App\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WidgetTotalItems extends AbstractController
{
	public function WidgetTotalItems($query)
    {
	    $countMembers = array();
	    
	    //Get all categories:
	    $category = $this->getDoctrine()
	    ->getRepository(Category::class)->findCategoryType($query);
	    
	    //Count number of members per category:
	    foreach ($category as $key => $value)
	    {
		   $members = $value->getId();

           if ($query == 'person') {
                $count = $this->getDoctrine()
                   ->getRepository(Person::class)->CountByCategegory($members);
           }
           if ($query == 'organization') {
                $count = $this->getDoctrine()
                    ->getRepository(Organization::class)->CountByCategegory($members);
           }

            if ($query == 'product') {
                $count = $this->getDoctrine()
                    ->getRepository(Products::class)->CountByCategegory($members);
            }


		   $countMembers[$key]['name'] = $value->getName();
		   $countMembers[$key]['description'] = $value->getDescription();
		   $countMembers[$key]['count'] = $count;		    
	    }
	    
		return $countMembers;
	}
}