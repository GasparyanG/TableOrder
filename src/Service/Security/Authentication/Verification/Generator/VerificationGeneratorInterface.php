<?php

namespace App\Service\Security\Authentication\Verification\Generator;

interface VerificationGeneratorInterface
{
    public function getVerificationCode(): string;
}