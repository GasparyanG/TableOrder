<?php

namespace App\Service\NotificationCenter\Preparing;

interface NotificationPreparingInterface
{
    public function getNotifications(): ?array;
}