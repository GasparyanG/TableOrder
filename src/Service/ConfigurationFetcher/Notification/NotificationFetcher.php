<?php

namespace App\Service\ConfigurationFetcher\Notification;

use Symfony\Component\Yaml\Yaml;

class NotificationFetcher implements NotificationFetcherInterface
{
    private $notificationMessageConfig;

    public function __construct()
    {
        $this->notificationMessageConfig = Yaml::parseFile(__DIR__ . "/../../../../config/packages/notification/notification-messages.yaml");
    }

    public function getReservationSuccess(): string
    {
        return $this->notificationMessageConfig["reservation"]["success"];
    }
}