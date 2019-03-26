<?php

namespace App\Controller;

use App\Service\BaseLayout\BaseLayoutSupplierInterface;
use App\Service\Bridge\Verification\VerificationComponentsSupplierInterface;
use App\Service\ClientSideGuru\Post\Authentication\SignUp\SignUpFormFetcherInterface;
use App\Service\ClientSideGuru\Post\Authentication\Verification\VerificationFetcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// http foundation
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// dev
use Psr\Log\LoggerInterface;

class VerificationController extends AbstractController
{
    public function getPage(BaseLayoutSupplierInterface $baseLayoutSupplier)
    {
        $arrayOfData = $this->getBaseLayoutComponents($baseLayoutSupplier);

        return $this->render('verification/index.html.twig', $arrayOfData);
    }

    public function verify(BaseLayoutSupplierInterface $baseLayoutSupplier,
                           VerificationComponentsSupplierInterface $verificationComponentsSupplier,
                           Request $request,
                           LoggerInterface $logger,
                           SignUpFormFetcherInterface $signUpFormFetcher, VerificationFetcherInterface $verificationFetcher)
    {
        $arrayOfData = $this->getBaseLayoutComponents($baseLayoutSupplier);

        // validate request's required data
        $errors = $verificationComponentsSupplier->validateVerification();
        $arrayOfData["errors"] = $errors;

        // getting email
        $queryParams = $request->query->all();
        $email = $signUpFormFetcher->getUsername($queryParams);

        // getting verification code
        $formData = $request->request->all();
        $verificationCode = $verificationFetcher->getVerificationCode($formData);

        // create verification object by requesting doctrine API
        $verification = $verificationComponentsSupplier->findVerification($email);

        if ($verification === null) {
            $arrayOfData["tryAgain"] = true;

            return $this->render('verification/index.html.twig', $arrayOfData);
        }

        else {
            if ($verificationComponentsSupplier->isVerified($verification, $verificationCode)) {

                // make user to be traceable: and at registration don't change cookie id, but set!
                $verificationComponentsSupplier->setCookie($email);

                // this will be changed as soon as success notification will be ready
                return $this->redirectToRoute("success");
            }

            $arrayOfData["tryAgain"] = true;

            // if tries is reached some point then verification code will be changed and sent to email given address again!
            $verificationComponentsSupplier->setTries($verification);

            return $this->render('verification/index.html.twig', $arrayOfData);
        }
    }

    private function getBaseLayoutComponents($baseLayoutSupplier): array
    {
        $arrayOfData = [];

        $arrayOfData["cities"] = $baseLayoutSupplier->getLocation();
        $arrayOfData["arrayOfPersonAmounts"] = $baseLayoutSupplier->getPersonAmount();
        $arrayOfData["tryAgain"] = false;
        $arrayOfData["errors"] = [];

        return $arrayOfData;
    }
}
