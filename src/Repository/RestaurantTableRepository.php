<?php

namespace App\Repository;

use App\Entity\RestaurantTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RestaurantTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method RestaurantTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method RestaurantTable[]    findAll()
 * @method RestaurantTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurantTableRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RestaurantTable::class);
    }

    // /**
    //  * @return RestaurantTable[] Returns an array of RestaurantTable objects
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
    public function findOneBySomeField($value): ?RestaurantTable
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findRestaurantTables(array $restaurantIdArray, int $personAmount)
    {
        $qb = $this->createQueryBuilder('r');

        return $qb->Where($qb->expr()->andX('r.restaurant IN (:arrayOfId)', $qb->expr()->orX(
            "r.personAmount = :personAmount", $qb->expr()->andX('r.personAmount > :personAmount', 'r.personAmount <= :personAmountTwo')
        )))
        ->setParameter('arrayOfId', $restaurantIdArray)
        ->setParameter('personAmount', $personAmount)
        ->setParameter('personAmountTwo', $personAmount + 2)
        ->getQuery()
        ->getResult();
    }

    public function findNotReservedTables(array $notReservedTablesId)
    {
        return $this->createQueryBuilder('r')
            ->where('r.id IN (:arrayOfTableId)')
            ->setParameter('arrayOfTableId', $notReservedTablesId)
            ->getQuery()
            ->getResult();
    }
}
