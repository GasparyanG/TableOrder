<?php

namespace App\Service\Bridge\Verification\Products;

use App\Service\Bridge\Cookie\CookieAdvancedHandlerInterface;
use App\Service\Bridge\Verification\VerificationComponentsSupplierInterface;

// entity
use App\Entity\Verification;
use App\Service\DatabaseHighLvlManipulation\EntityManipulation\Verification\VerificationManipulatorInterface;
use App\Service\Security\Authentication\Validation\Verification\VerificationValidationInterface;
use App\Service\Security\Authentication\Verification\VerificationHandlerInterface;

class VerificationComponentsSupplier implements VerificationComponentsSupplierInterface
{
    private $verificationValidation;
    private $verificationManipulator;
    private $verificationHandler;
    private $cookieAdvancedHandler;

    public function __construct(VerificationValidationInterface $verificationValidation,
                                VerificationManipulatorInterface $verificationManipulator,
                                VerificationHandlerInterface $verificationHandler,
                                CookieAdvancedHandlerInterface $cookieAdvancedHandler)
    {
        $this->verificationValidation = $verificationValidation;
        $this->verificationManipulator = $verificationManipulator;
        $this->verificationHandler = $verificationHandler;
        $this->cookieAdvancedHandler = $cookieAdvancedHandler;
    }

    public function validateVerification(): array
    {
        return $this->verificationValidation->validateVerification();
    }

    public function findVerification(string $email): ?Verification
    {
        return $this->verificationManipulator->findVerification($email);
    }

    public function isVerified(Verification $verification, string $verificationCode): bool
    {
        return $this->verificationHandler->isVerified($verification, $verificationCode);
    }

    public function setCookie(string $email, bool $changeCookie = false): void
    {
        $this->cookieAdvancedHandler->setCookie($email, $changeCookie);
    }

    public function setTries(Verification $verification): void
    {
        $this->verificationHandler->setTries($verification);
    }
}