<?php

namespace App\Repository;

use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;


/**
 * @method Person|null find($id, $lockMode = null, $lockVersion = null)
 * @method Person|null findOneBy(array $criteria, array $orderBy = null)
 * @method Person[]    findAll()
 * @method Person[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Person::class);
    }

    // /**
    //  * @return Person[] Returns an array of Person objects in specific category
    //  */
    public function findByCategegory($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.category = :val')
            ->andWhere('p.deathDate is NULL')
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
            ->andWhere('p.deathDate is NULL')
            ->setParameter('val', $value)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
    
    // /**
    //  * @return Person[] Returns an array of people wich birthday is this week.
    //  */
    public function Birthday()
    {
	    $currentDate = new \DateTime();
	    $CurrentDayOfYear = $currentDate->format('z');
	    $TwoWeeksBeforeDayOfYear = $CurrentDayOfYear - 7;
	    $TwoWeeksDayOfYear = $CurrentDayOfYear + 14;
	    
        return $this->createQueryBuilder('p')
        	->select('p')
            ->Where('dayofyear(p.birthDate) >= :CurrentDayOfYear AND dayofyear(p.birthDate) <= :TwoWeeksDayOfYear')
            ->andWhere('p.deathDate is NULL')
            ->setParameter('CurrentDayOfYear', $TwoWeeksBeforeDayOfYear)
            ->setParameter('TwoWeeksDayOfYear', $TwoWeeksDayOfYear)
            ->orderBy('month(p.birthDate)', 'ASC')
            ->getQuery()
            ->getResult()
        ;   
    }
     
    // /**
    //  * @return Person[] Returns an array of people wich have an jubilee this year.
    //  */
    public function Jubilee()
    {
        return $this->createQueryBuilder('p')
        	->select('p')
            ->andWhere('p.alumni = 0')
            ->andWhere('p.deathDate is NULL')
            ->andWhere('
            	p.membershipYears = 5 OR 
            	p.membershipYears = 10 OR 
            	p.membershipYears = 15 OR 
            	p.membershipYears = 20 OR
            	p.membershipYears = 25 OR
            	p.membershipYears = 30 OR
            	p.membershipYears = 40 OR
            	p.membershipYears = 50 OR
            	p.membershipYears = 60 OR
            	p.membershipYears = 65 OR
            	p.membershipYears = 70 OR
            	p.membershipYears = 75 OR
            	p.membershipYears = 80 OR
            	p.membershipYears = 85
            ')
            ->orderBy('p.membershipYears', 'ASC')
            ->getQuery()
            ->getResult()
        ;   
    }  
    
    // /**
    //  * @return Person[] Returns an array of Person objects in specific role.
    //  */
    public function findByMemberOf($value)
    {
        return $this->createQueryBuilder('p')
        	->innerJoin('p.memberOf', 'i')
            ->andWhere('i.id = :val')
            ->andWhere('p.deathDate is NULL')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getArrayResult()
        ;
    }  
    
    
    // /**
    //  * @return Person[] Returns an array of Person objects in specific role.
    //  */
    public function findByMemberOfProgramName($value)
    {
        return $this->createQueryBuilder('p')
        	->innerJoin('p.memberOf', 'i')
            ->andWhere('i.programName = :val')
            ->andWhere('p.deathDate is NULL')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    // /**
    //  * @return Person[] Returns an array of Person objects in specific role.
    //  */
    public function findByTag($value)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.tag', 'i')
            ->andWhere('i.tag = :val')
            ->andWhere('p.deathDate is NULL')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}

