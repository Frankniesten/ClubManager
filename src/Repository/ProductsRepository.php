<?php

namespace App\Repository;

use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Products|null find($id, $lockMode = null, $lockVersion = null)
 * @method Products|null findOneBy(array $criteria, array $orderBy = null)
 * @method Products[]    findAll()
 * @method Products[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Products::class);
    }
    
    /**
    * @return Products[] Returns an array of unique Products objects
    */ 
    public function findUniqueProducts()
    {
        return $this->createQueryBuilder('p')
        
            ->andWhere('p.uniqueProduct = true')
            ->getQuery()
            ->getResult()
        ;
    }
    
    
    // /**
    //  * @return Person[] Returns an array of Product objects in specific category
    //  */
    public function findByCategegory($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.category = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Person[] Returns an array of Person objects from category 1
    //  */
    public function CountByCategegory($value)
    {
        return $this->createQueryBuilder('p')
            ->select('count(p.id)')
            ->andWhere('p.category = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }
}
