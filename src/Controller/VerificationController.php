<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\BaseLayout\BaseLayoutSupplierInterface;
use App\Service\BaseLayout\ClientDataComposerInterface;
use App\Service\Bridge\Verification\VerificationComponentsSupplierInterface;
use App\Service\ClientSideGuru\Post\Authentication\SignUp\SignUpFormFetcherInterface;
use App\Service\ClientSideGuru\Post\Authentication\Verification\VerificationFetcherInterface;
use App\Service\Security\Cookie\CookieManipulatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// http foundation
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// dev
use Psr\Log\LoggerInterface;

class VerificationController extends AbstractController
{
    private $em;
    private $userRepo;

    public function __construct(RegistryInterface $registry)
    {
        $this->em = $registry->getEntityManager();
        $this->userRepo = $this->em->getRepository(User::class);
    }

    public function getPage(ClientDataComposerInterface $clientDataComposer)
    {
        $arrayOfData = $clientDataComposer->composeData();
        $arrayOfData["tryAgain"] = false;
        $arrayOfData["errors"] = [];

        return $this->render('verification/index.html.twig', $arrayOfData);
    }

    public function verify(ClientDataComposerInterface $clientDataComposer,
                           VerificationComponentsSupplierInterface $verificationComponentsSupplier,
                           Request $request,
                           LoggerInterface $logger,
                           SignUpFormFetcherInterface $signUpFormFetcher, VerificationFetcherInterface $verificationFetcher,
                           CookieManipulatorInterface $cookieManipulator)
    {
        $arrayOfData = $clientDataComposer->composeData();
        $arrayOfData["tryAgain"] = false;
        $arrayOfData["errors"] = [];

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

                $user = $this->userRepo->findOneBy(["email" => $email]);
                $userCookieId = $user->getCookieId();

                $redirectResponse = $this->redirectToRoute("dashboard");

                return $cookieManipulator->setUserCookieAndReturnResponse($userCookieId, $redirectResponse);
            }

            $arrayOfData["tryAgain"] = true;

            // if tries is reached some point then verification code will be changed and sent to email given address again!
            $verificationComponentsSupplier->setTries($verification);

            return $this->render('verification/index.html.twig', $arrayOfData);
        }
    }
}
