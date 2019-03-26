<?php

namespace App\Controller;

use App\Service\BaseLayout\BaseLayoutSupplierInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

class SuccessController extends AbstractController
{
    public function showSuccessMessage(LoggerInterface $logger, SessionInterface $session, Request $request, BaseLayoutSupplierInterface $baseLayoutSupplier)
    {
        $arrayOfData = $this->getBaseLayoutComponents($baseLayoutSupplier);

        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(["cookie_id" => $request->cookies->get('cookieId')]);
        $userId = $user->getId();

        $arrayOfData["user"] = $user;

        return $this->render("success/index.html.twig", $arrayOfData);
    }

    private function getBaseLayoutComponents($baseLayoutSupplier): array
    {
        $arrayOfData = [];

        $arrayOfData["cities"] = $baseLayoutSupplier->getLocation();
        $arrayOfData["arrayOfPersonAmounts"] = $baseLayoutSupplier->getPersonAmount();

        return $arrayOfData;
    }
}
