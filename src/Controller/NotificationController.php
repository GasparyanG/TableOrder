<?php

namespace App\Controller;

use App\Service\DatabaseHighLvlManipulation\Deletion\Notification\NotificationDeletionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends AbstractController
{
    public function deleteAll(NotificationDeletionInterface $notificationDeletion)
    {
        $dataToReturn["deleted"] = false;

        // this will remove all notifications of authenticated user!
        $notificationDeletion->deleteUserAllNotifications();

        $dataToReturn["deleted"] = true;

        $response = new Response();
        $response->headers->set("Content-Type", "application/json");
        $response->setContent(json_encode($dataToReturn));

        return $response;
    }
}
