<?php

namespace App\Repository;

use App\Entity\AttendanceList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AttendanceList|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttendanceList|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttendanceList[]    findAll()
 * @method AttendanceList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttendanceListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AttendanceList::class);
    }

    // /**
    //  * @return AttendanceList[] Returns an array of AttendanceList objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AttendanceList
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
