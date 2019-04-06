<?php

namespace App\Repository;

use App\Entity\RestaurantDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RestaurantDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method RestaurantDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method RestaurantDetails[]    findAll()
 * @method RestaurantDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurantDetailsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RestaurantDetails::class);
    }

    // /**
    //  * @return RestaurantDetails[] Returns an array of RestaurantDetails objects
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
    public function findOneBySomeField($value): ?RestaurantDetails
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findResentAdded(int $offset, int $limit)
    {
        $qb = $this->createQueryBuilder("r");

        return $qb->addOrderBy("r.registrationDate", "DESC")
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }

    public function findMostRatedRestaurants(int $offset, int $limit)
    {
        $qb = $this->createQueryBuilder("r");

        return $qb->addOrderBy("r.rating", "DESC")
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }
}
