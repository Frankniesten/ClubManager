<?php

namespace App\Repository;

use App\Entity\ProgramMembership;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method ProgramMembership|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProgramMembership|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProgramMembership[]    findAll()
 * @method ProgramMembership[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgramMembershipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProgramMembership::class);
    }

    // /**
    //  * @return ProgramMembership[] Returns an array of ProgramMembership objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProgramMembership
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
