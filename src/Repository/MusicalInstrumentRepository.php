<?php

namespace App\Repository;

use App\Entity\MusicalInstrument;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MusicalInstrument|null find($id, $lockMode = null, $lockVersion = null)
 * @method MusicalInstrument|null findOneBy(array $criteria, array $orderBy = null)
 * @method MusicalInstrument[]    findAll()
 * @method MusicalInstrument[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MusicalInstrumentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MusicalInstrument::class);
    }

    // /**
    //  * @return MusicalInstrument[] Returns an array of MusicalInstrument objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MusicalInstrument
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
