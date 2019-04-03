<?php

namespace App\Service\ConfigurationFetcher\Notification;

interface NotificationFetcherInterface
{
    public function getReservationSuccess(): string;
}