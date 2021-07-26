<?php

namespace App\Repository;

use App\Entity\OwnershipInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OwnershipInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method OwnershipInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method OwnershipInfo[]    findAll()
 * @method OwnershipInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OwnershipInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OwnershipInfo::class);
    }

    // /**
    //  * @return OwnershipInfo[] Returns an array of OwnershipInfo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OwnershipInfo
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
