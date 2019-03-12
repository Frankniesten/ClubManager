<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Category::class);
    }
    
    // /**
    //  * @return Category[] Returns an array of Category objects
    //  */
    public function findByAdditionalType($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.additionalType = :additionalType')
            ->setParameter('additionalType', $value)
            ->orderBy('a.id', 'ASC')
            ->getQuery()
        ;
    }
    
    

 

    /**
    //  * @return Category[] Returns an array of Category objects
    //  */
    
    public function findCategoryType($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.additionalType = :val')
            ->setParameter('val', $value)
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
