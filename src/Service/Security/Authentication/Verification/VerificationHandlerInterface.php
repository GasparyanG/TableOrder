<?php

namespace App\Service\Security\Authentication\Verification;

interface VerificationHandlerInterface
{
    public function requiresToBeVerified(string $email): bool;
}