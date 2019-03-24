<?php

namespace App\Service\Security\Authentication\Validation\Verification;

interface VerificationValidationInterface
{
    public function validateVerification(): array;
}