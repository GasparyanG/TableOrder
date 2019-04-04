<?php

namespace App\Service\NotificationCenter\NotificationSupplierFactory\Factory;

use App\Service\NotificationCenter\NotificationSupplierFactory\Products\NotificationSupplierInterface;

interface NotificationSupplierFactoryInterface
{
    public function create($notification): ?NotificationSupplierInterface;
}