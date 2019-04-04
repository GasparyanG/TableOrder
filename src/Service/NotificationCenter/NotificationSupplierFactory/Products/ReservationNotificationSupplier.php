<?php

namespace App\Service\NotificationCenter\NotificationSupplierFactory\Products;

class ReservationNotificationSupplier extends CommonNotificationSupplier implements NotificationSupplierInterface
{
    public function isValid($notification): bool
    {
        return $this->databaseNameFetcher->getReservationTableName() === get_class($notification);
    }

    // overriding
    protected function addMessage(): void
    {
        $message = $this->notificationFetcher->getReservationSuccess();
        $this->notification->setMessage($message);
    }
}