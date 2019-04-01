<?php

namespace App\Repository;

use App\Entity\Bookmark;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\User;

/**
 * @method Bookmark|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bookmark|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bookmark[]    findAll()
 * @method Bookmark[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookmarkRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Bookmark::class);
    }

    // /**
    //  * @return Bookmark[] Returns an array of Bookmark objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bookmark
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getUserBookmarks(User $user, int $limit)
    {
       $qb = $this->createQueryBuilder("b");

       return $qb->where("b.user = :user")
           ->setMaxResults($limit)
           ->setParameter("user", $user)
           ->getQuery()
           ->getResult();
    }

    public function getAmountOfUserBookmarks(User $user): int
    {
        $qb = $this->createQueryBuilder("b");

        $amountOfBookmarks = $qb->select("count(b.user) as amountOfBookmarks")
            ->where("b.user = :user")
            ->setParameter("user", $user)
            ->getQuery()
            ->getResult();

        $amount = $amountOfBookmarks[0]["amountOfBookmarks"];

        return $amount;
    }
}
