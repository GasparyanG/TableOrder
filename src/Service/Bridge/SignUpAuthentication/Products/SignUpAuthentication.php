<?php

namespace App\Service\Bridge\SignUpAuthentication\Products;

use App\Service\Bridge\SignUpAuthentication\SignUpAuthenticationInterface;
use App\Service\ClientSideGuru\Post\Authentication\SignUp\SignUpFormFetcherInterface;
use App\Service\DatabaseHighLvlManipulation\Insertion\User\UserInsertionInterface;
use App\Service\DatabaseHighLvlManipulation\Insertion\Verification\VerificationInsertionInterface;
use App\Service\Mailer\MailerInterface;
use App\Service\Security\Authentication\Validation\SignUpValidation\SignUpFormValidationInterface;
use App\Service\Security\Authentication\Verification\VerificationHandlerInterface;

class SignUpAuthentication implements SignUpAuthenticationInterface
{
    private $signUpFormValidation;
    private $userInsertion;
    private $verificationInsertion;
    private $signUpFormFetcher;
    private $mailer;
    private $verificationHandler;

    public function __construct(SignUpFormValidationInterface $signUpFormValidation,
                                UserInsertionInterface $userInsertion,
                                VerificationInsertionInterface $verificationInsertion,
                                SignUpFormFetcherInterface $signUpFormFetcher,
                                MailerInterface $mailer,
                                VerificationHandlerInterface $verificationHandler)
    {
        $this->signUpFormValidation = $signUpFormValidation;
        $this->userInsertion = $userInsertion;
        $this->verificationInsertion = $verificationInsertion;
        $this->signUpFormFetcher = $signUpFormFetcher;
        $this->mailer = $mailer;
        $this->verificationHandler = $verificationHandler;
    }

    public function validateForm(array $userCredentials): array
    {
        return $this->signUpFormValidation->validateForm($userCredentials);
    }

    public function checkUsername(array $userCredentials): ?string
    {
        return $this->signUpFormValidation->checkUsername($userCredentials);
    }

    public function insertUserToDatabase(array $userCredentials): void
    {
        $this->userInsertion->InsertToDatabase($userCredentials);
    }

    public function insertVerificationToDatabase(array $userCredentials): void
    {
        $this->verificationInsertion->insertToDatabase($userCredentials);
    }

    public function sendVerificationCode(array $userCredentials): void
    {
        $username = $this->signUpFormFetcher->getUsername($userCredentials);
        $this->mailer->sendVerificationCode($username);
    }

    public function requiresToBeVerified(array $userCredentials): bool
    {
        $username = $this->signUpFormFetcher->getUsername($userCredentials);

        return $this->verificationHandler->requiresToBeVerified($username);
    }
}