<?php

namespace App\Service\NotificationCenter\Notifier;

use App\Entity\Reservation;
use App\Service\NotificationCenter\NotificationSupplierFactory\Factory\NotificationSupplierFactoryInterface;
use App\Service\User\UserSupporterInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

// DEV
use Psr\Log\LoggerInterface;

class CasualNotifierStrategy implements NotifierInterface
{
    private $em;
    private $userSupporter;
    private $notificationSupplierFactory;

    // DEV
    private $logger;

    public function __construct(RegistryInterface $registry,
                                UserSupporterInterface $userSupporter,
                                NotificationSupplierFactoryInterface $notificationSupplierFactory,
                                LoggerInterface $logger)
    {
        $this->em = $registry->getEntityManager();
        $this->userSupporter = $userSupporter;
        $this->notificationSupplierFactory = $notificationSupplierFactory;

        // DEV
        $this->logger = $logger;
    }

    public function notify($notification): void
    {
        $className = get_class($notification);

        // instantiate required object with factory method
        $notificationSupplier = $this->notificationSupplierFactory->create($notification);
        if ($notificationSupplier) {
            $notificationSupplier->notify($notification);
        }

        else {
            throw new \RuntimeException("Null is returned while NotificationSupplierInterface is required!");
        }
    }
}