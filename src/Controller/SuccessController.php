<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

class SuccessController extends AbstractController
{
    public function showSuccessMessage(LoggerInterface $logger, SessionInterface $session, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(["cookie_id" => $request->cookies->get('cookieId')]);
        $userId = $user->getId();

        if (in_array("ROLE_ADMIN", $user->getRoles())) {
            return $this->redirectToRoute("admin_page");
        }

        return $this->redirectToRoute("user_page", ["user_id" => $userId]);
    }
}
