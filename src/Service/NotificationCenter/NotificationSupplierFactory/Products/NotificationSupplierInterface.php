<?php

namespace App\Service\NotificationCenter\NotificationSupplierFactory\Products;

interface NotificationSupplierInterface
{
    public function isValid($notification): bool;

    public function notify($notification): void;
}