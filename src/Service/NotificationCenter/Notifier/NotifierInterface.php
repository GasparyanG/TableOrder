<?php

namespace App\Service\NotificationCenter\Notifier;

interface NotifierInterface
{
    public function notify($notification): void;
}