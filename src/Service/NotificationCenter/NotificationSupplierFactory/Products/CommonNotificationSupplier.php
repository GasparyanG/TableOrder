<?php

namespace App\Service\NotificationCenter\NotificationSupplierFactory\Products;

use App\Service\Augmention\TimeAndDate\TimeAndDateSupplierInterface;
use App\Service\ConfigurationFetcher\Database\DatabaseNames\DatabaseNameFetcherInterface;

// DEV
use App\Service\ConfigurationFetcher\Notification\NotificationFetcherInterface;
use App\Service\User\UserSupporterInterface;
use Psr\Log\LoggerInterface;
use App\Entity\Notification;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CommonNotificationSupplier
{
    // hero of this class
    protected $notification;

    protected $databaseNameFetcher;
    protected $em;
    protected $timeAndDateSupplier;
    protected $userSupporter;
    protected $notificationFetcher;

    // DEV
    protected $logger;

    public function __construct(DatabaseNameFetcherInterface $databaseNameFetcher,
                                RegistryInterface $registry,
                                TimeAndDateSupplierInterface $timeAndDateSupplier,
                                UserSupporterInterface $userSupporter,
                                NotificationFetcherInterface $notificationFetcher,
                                LoggerInterface $logger)
    {
        $this->notification = new Notification();

        $this->timeAndDateSupplier = $timeAndDateSupplier;
        $this->userSupporter = $userSupporter;
        $this->notificationFetcher = $notificationFetcher;

        //db
        $this->databaseNameFetcher = $databaseNameFetcher;
        $this->em = $registry->getEntityManager();

        // DEV
        $this->logger = $logger;
    }

    // template pattern: call methods and let child to override desired method to change behavior!
    public function notify($notificationObject): void
    {
        $this->addTime();
        $this->addUser();
        $this->addTableId($notificationObject);
        $this->addTableName($notificationObject);
        // this method will be implemented in successors
        $this->addMessage();

        // make record to notification table!
        $this->em->persist($this->notification);
        $this->em->flush();
    }

    protected function addTime(): void
    {
        $time = $this->timeAndDateSupplier->getTime();
        $this->notification->setTime($time);
    }

    protected function addUser(): void
    {
        $user = $this->userSupporter->getUser();
        $this->notification->setUser($user);
    }

    protected function addTableId($notificationObject): void
    {
        $tableId = $notificationObject->getId();
        $this->notification->setTableId($tableId);
    }

    protected function addTableName($notificationObject): void
    {
        $tableName = get_class($notificationObject);
        $this->notification->setTableName($tableName);
    }

    protected function addMessage(): void
    {
        // leave this method abstract to let child override it
    }
}