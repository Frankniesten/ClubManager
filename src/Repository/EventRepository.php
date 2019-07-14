<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Validator\Constraints\DateTime;

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
    //  * @return Person[] Returns an array of Event objects in specific category
    //  */
    public function findByDate($startDate, $endDate)
    {
        return $this->createQueryBuilder('p')
            ->Where('p.startDate >= :startDate AND p.endDate <= :endDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->orderBy('p.startDate', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    
    
    
    // /**
    //  * @return Person[] Returns an array of Event objects in specific category
    //  */
    public function findByCategegory($value, $startDate, $endDate)
    {
        return $this->createQueryBuilder('p')
        	->leftJoin('p.category', 'i')
            ->Where('i.id = :val AND p.startDate >= :startDate AND p.endDate <= :endDate')
            ->setParameter('val', $value)
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->getQuery()
            ->getResult()
        ;
    }
    
    // /**
    //  * @return Person[] Returns an array of upcoming events.
    //  */
    public function UpcomingEvents()
    {

		$startDate = new \DateTime('-1 day');
	    
	    $endDate = new \DateTime('+15 day');

        return $this->createQueryBuilder('p')
        	->select('p')
            ->andWhere('p.startDate >= :startDate AND p.endDate <= :endDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->orderBy('p.startDate', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
                
}
