<?php

namespace App\Service\NotificationCenter\NotificationSupplierFactory\Factory;

use App\Service\NotificationCenter\NotificationSupplierFactory\Products\NotificationSupplierInterface;
use Psr\Container\ContainerInterface;

class NotificationSupplierFactory implements NotificationSupplierFactoryInterface
{
    private $notificationSuppliers;
    private $baseDirectory;
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        // notification supplier namespace configuration
        $this->baseDirectory = "App\Service\NotificationCenter\NotificationSupplierFactory\Products\\";
        $this->notificationSuppliers = [
            "ReservationNotificationSupplier"
        ];
    }

    public function create($notification): ?NotificationSupplierInterface
    {
        foreach($this->notificationSuppliers as $notificationSupplier) {
            $fullyQualifiedNamespace = $this->baseDirectory . $notificationSupplier;

            // checking to see whether current notification supplier required or not.
            $currentNotificationSupplier = $this->container->get($fullyQualifiedNamespace);
            if ($currentNotificationSupplier->isValid($notification)) {
                return $currentNotificationSupplier;
            }
        }

        return null;
    }
}