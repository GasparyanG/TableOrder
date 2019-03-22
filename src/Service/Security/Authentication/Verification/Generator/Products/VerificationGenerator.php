<?php

namespace App\Service\Security\Authentication\Verification\Generator\Products;

use App\Service\Security\Authentication\Verification\Generator\VerificationGeneratorInterface;

class VerificationGenerator implements VerificationGeneratorInterface
{
    public function getVerificationCode(): string
    {
        // four digit number!
        return rand(1000, 9999);
    }
}