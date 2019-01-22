<?php
// src/Service/ProductsOnLoan.php

namespace App\Service;

use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductsOnLoan extends AbstractController
{
    public function processAllProducts()
    {
	    $products = $this->getDoctrine()
        ->getRepository(Products::class)
        ->findUniqueProducts();
	    	    	    
	    	    	 
	    	    	    
	    foreach ($products as $key => $value)
		{
			$loan = false;
			
			
		
			
			foreach ($value->getOwnershipInfos() as $k => $v)
			{
				if ( $v->getOwnedFrom() > new \DateTime()) {
					
					$loan = false;
					break;
				}
				else 
				{
					if ($v->getOwnedTrough() == null) 
					{
						$loan = true;
						break;
					}
					else
					{
						if ( $v->getOwnedTrough() > new \DateTime()) 
						{
							$loan = true;
						}
						else 
						{
							$loan = false;
						}
						
					}			
				}		
			}
			
			$em = $this->getDoctrine()->getManager();
			$data = $em->getRepository(Products::class)->find($value->getId());
			$data->setLoan($loan);
			$em->flush();	
		}
    }
    
    
    public function processProduct (string $productID)
    {			
		$product = $this->getDoctrine()
			->getRepository(Products::class)
			->find($productID);
			
		$loan = false;
		
		if ($product->getuniqueProduct() == true) 
		{
			
			foreach ($product->getOwnershipInfos() as $k => $v)
			{
				if ( $v->getOwnedFrom() > new \DateTime()) {
					
					$loan = false;
					break;
				}
				else 
				{
					if ($v->getOwnedTrough() == null) 
					{
						$loan = true;
						break;
					}
					else
					{
						if ( $v->getOwnedTrough() > new \DateTime()) 
						{
							$loan = true;
						}
						else 
						{
							$loan = false;
						}
						
					}			
				}		
			}
			
			$em = $this->getDoctrine()->getManager();
			$data = $em->getRepository(Products::class)->find($productID);
			$data->setLoan($loan);
			$em->flush();	
		}	
	} 
}

	
	
	
	
	
	
	
	
	
	
	
	