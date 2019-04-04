<?php

namespace App\Service\DatabaseHighLvlManipulation\Deletion\Notification;

interface NotificationDeletionInterface
{
    public function deleteUserAllNotifications(): void;
}