<?php

namespace App\Service\DatabaseHighLvlManipulation\Insertion\Comment\Products;

use App\Service\Augmention\TimeAndDate\TimeAndDateSupplierInterface;
use App\Service\DatabaseHighLvlManipulation\Insertion\Comment\CommentInsertionInterface;
use App\Service\User\UserSupporterInterface;

// DB
use App\Entity\Restaurant;
use App\Entity\Comment;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CommentInserter implements CommentInsertionInterface
{
    private $em;
    private $commentRepo;
    private $userSupporter;
    private $restaurantRepo;
    private $timeAndDateSupplier;

    public function __construct(RegistryInterface $registry,
                                UserSupporterInterface $userSupporter,
                                TimeAndDateSupplierInterface $timeAndDateSupplier)
    {
        $this->userSupporter = $userSupporter;
        $this->timeAndDateSupplier = $timeAndDateSupplier;

        // db
        // deprecated instead use getManager()
        $this->em = $registry->getEntityManager();
        $this->commentRepo = $this->em->getRepository(Comment::class);
        $this->restaurantRepo = $this->em->getRepository(Restaurant::class);
    }

    public function insertToDatabase(string $comment, int $restaurantId): void
    {
        $commentObj = new Comment();

        // comment
        $commentObj->setComment($comment);

        // user
        $user = $this->userSupporter->getUser();
        $commentObj->setUser($user);

        // restaurant
        $restaurant = $this->restaurantRepo->find($restaurantId);
        $commentObj->setRestaurant($restaurant);

        // time
        $currentTime = $this->timeAndDateSupplier->getTime();
        $commentObj->setCommentTime($currentTime);

        $this->em->persist($commentObj);
        $this->em->flush();
    }
}