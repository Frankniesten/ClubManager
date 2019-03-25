<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Event::class);
    }

    // /**
    //  * @return Person[] Returns an array of Person objects in specific category
    //  */
    public function findByCategegory($value)
    {
        return $this->createQueryBuilder('p')
        	->leftJoin('p.category', 'i')
            ->Where('i.id = :val')
            ->setParameter('val', $value)
            //->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
   /// ->leftJoin('p.user', 'u')
					        //->where('u.id IS NULL AND p.email IS NOT NULL');
   
    /*
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
