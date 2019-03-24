<?php

namespace App\Service\Security\Authentication\Verification;

use App\Entity\Verification;

interface VerificationHandlerInterface
{
    public function requiresToBeVerified(string $email): bool;

    public function setTries(Verification $verification): void;

    public function isVerified(Verification $verification, string $verificationCode): bool;
}