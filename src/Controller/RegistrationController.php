<?php

namespace App\Controller;

use App\Service\BaseLayout\Products\BaseLayoutSupplier;
use App\Service\ClientSideGuru\Json\JsonNerd\JsonNerdInterface;
use App\Service\ClientSideGuru\Post\Authentication\SignUp\SignUpFormFetcherInterface;
use App\Service\DatabaseHighLvlManipulation\Insertion\User\UserInsertionInterface;
use App\Service\DatabaseHighLvlManipulation\Insertion\Verification\VerificationInsertionInterface;
use App\Service\Mailer\MailerInterface;
use App\Service\Security\Authentication\Validation\SignUpValidation\SignUpFormValidationInterface;
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

    public function signUp(Request $request, JsonNerdInterface $jsonNerd, LoggerInterface $logger, SignUpFormValidationInterface $signUpFormValidation, UserInsertionInterface $userInsertion, VerificationInsertionInterface $verificationInsertion, SignUpFormFetcherInterface $signUpFormFetcher, MailerInterface $mailer)
    {
        $userCredentials = $request->request->all();

        // $userCredentials = $jsonNerd->convertToAssocArray($userCredentialsImproperFormat);
        $errors = $signUpFormValidation->validateForm($userCredentials);


        $wrongEmail = $signUpFormValidation->checkUsername($userCredentials);

        if (!$wrongEmail && count($errors) === 0) {
            // user insertion
            $userInsertion->InsertToDatabase($userCredentials);
            $verificationInsertion->insertToDatabase($userCredentials);

            $username = $signUpFormFetcher->getUsername($userCredentials);
            $mailer->sendVerificationCode($username);

            return $this->redirectToRoute("verification");
        }

        else {
            $errors[] = $wrongEmail;
        }


        // for testing only
        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($errors));

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