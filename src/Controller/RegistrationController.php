<?php

namespace App\Controller;

use App\Service\BaseLayout\Products\BaseLayoutSupplier;
use App\Service\ClientSideGuru\Json\JsonNerd\JsonNerdInterface;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends AbstractController
{
    public function getPage(BaseLayoutSupplier $baseLayoutSupplier)
    {
        $arrayOfData = $this->getBaseLayoutComponents($baseLayoutSupplier);

        return $this->render("registration/register.html.twig", $arrayOfData);
    }

    public function signUp(Request $request, JsonNerdInterface $jsonNerd, LoggerInterface $logger)
    {
        $userCredentialsImproperFormat = $request->request->all();

        $userCredentials = $jsonNerd->convertToAssocArray($userCredentialsImproperFormat);


        // for testing only
        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($userCredentialsImproperFormat));

        return $response;
    }

    private function getBaseLayoutComponents($baseLayoutSupplier): array
    {
        $arrayOfData = [];

        $arrayOfData["cities"] = $baseLayoutSupplier->getLocation();
        $arrayOfData["arrayOfPersonAmounts"] = $baseLayoutSupplier->getPersonAmount();

        return $arrayOfData;
    }
}