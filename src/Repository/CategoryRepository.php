<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }
    
    // /**
    //  * @return Category[] Returns an array of Category objects
    //  */
    public function findByAdditionalType()
    {
        return $this->createQueryBuilder('a')
        	->select('a.additionalType')
            ->distinct()
            ->orderBy('a.additionalType', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
 
//SELECT DISTINCT `additional_type` FROM `category`
    /**
    //  * @return Category[] Returns an array of Category objects
    //  */
    
    public function findCategoryType($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.additionalType = :val')
            ->setParameter('val', $value)
            ->orderBy('c.additionalType', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Category
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
