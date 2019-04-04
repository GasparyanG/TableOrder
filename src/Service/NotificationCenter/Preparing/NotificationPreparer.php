<?php

namespace App\Service\NotificationCenter\Preparing;

use App\Service\ClientSideGuru\Keys\Search\KeysFetcherInterface;
use App\Service\User\UserSupporterInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

// entities
use App\Entity\Notification;

class NotificationPreparer implements NotificationPreparingInterface
{
    protected $userSupporter;
    protected $notificationData;
    protected $keysFetcher;

    // db
    protected $em;
    protected $notificationRepo;

    // DEV
    protected $logger;

    public function __construct(UserSupporterInterface $userSupporter,
                                RegistryInterface $registry,
                                KeysFetcherInterface $keysFetcher,
                                LoggerInterface $logger)
    {
        $this->notificationData = [];
        $this->userSupporter = $userSupporter;
        $this->keysFetcher = $keysFetcher;

        // db
        $this->em = $registry->getEntityManager();
        $this->notificationRepo = $this->em->getRepository(Notification::class);

        // DEV
        $this->logger = $logger;
    }

    public function getNotifications(): ?array
    {
        $this->addNotifications();
        $this->addNotificationsAmount();

        return $this->notificationData;
    }

    protected function addNotifications(): void
    {
        $user = $this->userSupporter->getUser();
        $notifications = $user->getNotifications();

        $notificationsKey = $this->keysFetcher->getNotifications();
        $this->notificationData[$notificationsKey] = $notifications;
    }

    protected function addNotificationsAmount(): void
    {
        $user = $this->userSupporter->getUser();

        $amountOfNotifications = $this->notificationRepo->getAmountOfNotifications($user);

        $amountOfNotificationsKey = $this->keysFetcher->getAmountOfNotifications();
        $this->notificationData[$amountOfNotificationsKey] = $amountOfNotifications;
    }
}