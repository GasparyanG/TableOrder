<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    // /**
    //  * @return Reservation[] Returns an array of Reservation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reservation
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    // add to second param if sth goes wrong >>> array $restaurantIds, <<<
    public function findReservedTables(array $tableIds, string $reservationDate, string $reservationTime)
    {
        $qb = $this->createQueryBuilder('r');
        
        return $qb->where($qb->expr()->andX('r.table IN (:arrayOfTableId)',
            // uncomment below line to get previouse behaviour
            // 'r.restauran IN (:arrayOfRestaurantId)', 
            'r.reservationDate = :reservationDate',
            'r.reservationTime = :reservationTime'))
            ->setParameter('arrayOfTableId', $tableIds)
            // ->setParameter('arrayOfRestaurantId', $restaurantIds)
            ->setParameter('reservationDate', $reservationDate)
            ->setParameter('reservationTime', $reservationTime)
            ->getQuery()
            ->getResult();
    }

    public function findPreviouseReservation(string $reservationTime,  string $reservationDate, $table)
    {
        $qb = $this->createQueryBuilder('r');

        return $qb->where($qb->expr()->andX('r.table = :tableId',
            "r.reservationDate = :reservationDate", 
            "r.reservationTime < :reservationTime"))
            ->orderBy('r.reservationTime', 'DESC')
            ->setMaxResults(1)
            ->setParameter("reservationTime", $reservationTime)
            ->setParameter("reservationDate", $reservationDate)
            ->setParameter("tableId", $table)
            ->getQuery()
            ->getResult();
    }

    public function findNextReservation(string $reservationTime,  string $reservationDate, $table)
    {
        $qb = $this->createQueryBuilder('r');

        return $qb->where($qb->expr()->andX('r.table = :tableId',
            "r.reservationDate = :reservationDate", 
            "r.reservationTime > :reservationTime"))
            ->orderBy('r.reservationTime', 'ASC')
            ->setMaxResults(1)
            ->setParameter("reservationTime", $reservationTime)
            ->setParameter("reservationDate", $reservationDate)
            ->setParameter("tableId", $table)
            ->getQuery()
            ->getResult();
    }
}
