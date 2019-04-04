<?php

namespace App\Service\DatabaseHighLvlManipulation\Deletion\Notification;

use App\Service\User\UserSupporterInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

// entity
use App\Entity\Notification;

class NotificationCasualDeletionStrategy implements NotificationDeletionInterface
{
    private $userSupporter;
    private $em;
    private $notificationRepo;

    public function __construct(UserSupporterInterface $userSupporter,
                                RegistryInterface $registry)
    {
        $this->userSupporter = $userSupporter;

        // db
        $this->em = $registry->getEntityManager();
        $this->notificationRepo = $this->em->getRepository(Notification::class);
    }

    public function deleteUserAllNotifications(): void
    {
        $user = $this->userSupporter->getUser();
        $notifications = $this->notificationRepo->findAll(["user" => $user]);

        foreach($notifications as $notification) {
            $this->em->remove($notification);
            $this->em->flush();
        }
    }
}