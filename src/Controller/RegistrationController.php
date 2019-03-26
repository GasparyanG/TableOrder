<?php

namespace App\Controller;

use App\Service\BaseLayout\BaseLayoutSupplierInterface;
# use App\Service\BaseLayout\Products\BaseLayoutSupplier;
use App\Service\Bridge\SignUpAuthentication\SignUpAuthenticationInterface;
use App\Service\ClientSideGuru\Post\Authentication\SignUp\SignUpFormFetcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends AbstractController
{
    public function getPage(BaseLayoutSupplierInterface $baseLayoutSupplier)
    {
        $arrayOfData = $this->getBaseLayoutComponents($baseLayoutSupplier);

        return $this->render("registration/register.html.twig", $arrayOfData);
    }

    public function signUp(Request $request, LoggerInterface $logger, SignUpAuthenticationInterface $signUpAuthentication, BaseLayoutSupplierInterface $baseLayoutSupplier, SignUpFormFetcherInterface $signUpFormFetcher)
    {
        $arrayOfData = $this->getBaseLayoutComponents($baseLayoutSupplier);

        $userCredentials = $request->request->all();

        if ($signUpAuthentication->requiresToBeVerified($userCredentials)) {
            return $this->redirect($this->generateUrl("verification", array("username" => $signUpFormFetcher->getUsername($userCredentials))));
        }

        // $userCredentials = $jsonNerd->convertToAssocArray($userCredentialsImproperFormat);
        $errors = $signUpAuthentication->validateForm($userCredentials);

        $wrongEmail = $signUpAuthentication->checkUsername($userCredentials);

        if (!$wrongEmail && count($errors) === 0) {
            // user insertion
            $signUpAuthentication->insertUserToDatabase($userCredentials);
            $signUpAuthentication->insertVerificationToDatabase($userCredentials);

            $signUpAuthentication->sendVerificationCode($userCredentials);

            // 1
            return $this->redirect($this->generateUrl("verification", array("username" => $signUpFormFetcher->getUsername($userCredentials))));
        }

        else {
            $errors[] = $wrongEmail;
        }

        $arrayOfData["errors"] = $errors;

        return $this->render("registration/register.html.twig", $arrayOfData);
    }

    private function getBaseLayoutComponents($baseLayoutSupplier): array
    {
        $arrayOfData = [];

        $arrayOfData["cities"] = $baseLayoutSupplier->getLocation();
        $arrayOfData["arrayOfPersonAmounts"] = $baseLayoutSupplier->getPersonAmount();
        $arrayOfData["errors"] = [];

        return $arrayOfData;
    }
}