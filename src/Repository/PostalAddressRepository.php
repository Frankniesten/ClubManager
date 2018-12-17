<?php

namespace App\Repository;

use App\Entity\PostalAddress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PostalAddress|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostalAddress|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostalAddress[]    findAll()
 * @method PostalAddress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostalAddressRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PostalAddress::class);
    }

    // /**
    //  * @return PostalAddress[] Returns an array of PostalAddress objects
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
    public function findOneBySomeField($value): ?PostalAddress
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
