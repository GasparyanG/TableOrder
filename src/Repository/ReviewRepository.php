<?php

namespace App\Repository;

use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\User;

/**
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Review::class);
    }

    // /**
    //  * @return Review[] Returns an array of Review objects
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
    public function findOneBySomeField($value): ?Review
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @param $restaurantId
     * @return array
     */
    public function getReview($restaurantId): array
    {
        $qb = $this->createQueryBuilder("r");

        return $qb->select("avg(r.review) as avg_review")
            ->where('r.restaurant = :restaurantId')
            ->setParameter('restaurantId', $restaurantId)
            ->getQuery()
            ->getResult();
    }

    public function gerRestaurantGroupReview($restaurantName): array
    {
        $qb = $this->createQueryBuilder("r");

        return $qb->select("avg(r.review) as avg_review")
            ->where('r.restaurantName = :restaurantName')
            ->setParameter('restaurantName', $restaurantName)
            ->getQuery()
            ->getResult();
    }

    public function findAmountOfReview($restaurantId): array
    {
        $qb = $this->createQueryBuilder("r");

        return $qb->select('count(r.review) as amountOfReview')
            ->where('r.restaurant = :restaurantId')
            ->setParameter('restaurantId', $restaurantId)
            ->getQuery()
            ->getResult();
    }

    public function findRestaurantGroupAmountOfReview($restaurantName): array
    {
        $qb = $this->createQueryBuilder("r");

        return $qb->select('count(r.review) as amountOfReview')
            ->where('r.restaurantName = :restaurantName')
            ->setParameter('restaurantName', $restaurantName)
            ->getQuery()
            ->getResult();
    }

    public function findRestaurantGroupSpecificAmountOfReview($restaurantName, $rating)
    {
        $qb = $this->createQueryBuilder('r');

        return $qb->select('count(r.review) as amountOfReview')
            ->where($qb->expr()->andX('r.restaurantName = :restaurantName', 'r.review = :rating'))
            ->setParameter('restaurantName', $restaurantName)
            ->setParameter('rating', $rating)
            ->getQuery()
            ->getResult();
    }

    public function findSpecificAmountOfReview($restaurantId, $rating)
    {
        $qb = $this->createQueryBuilder('r');

        return $qb->select('count(r.review) as amountOfReview')
            ->where($qb->expr()->andX('r.restaurant = :restaurantId', 'r.review = :rating'))
            ->setParameter('restaurantId', $restaurantId)
            ->setParameter('rating', $rating)
            ->getQuery()
            ->getResult();
    }

    public function findUserRatings(User $user, $amountOfRatings)
    {
       $qb = $this->createQueryBuilder("r");

       return $qb->where('r.user = :user')
           ->setMaxResults($amountOfRatings)
           ->setParameter('user', $user)
           ->getQuery()
           ->getResult();
    }

    public function getUserAmountOfRatings(User $user): int
    {
        $qb = $this->createQueryBuilder("r");

        $amountOfRatings = $qb->select('count(r.user) as amountOfRatings')
            ->where('r.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();

        return $amountOfRatings[0]["amountOfRatings"];
    }
}
