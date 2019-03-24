<?php

namespace App\Service\DatabaseHighLvlManipulation\EntityManipulation\Verification;

use App\Entity\Verification;

interface VerificationManipulatorInterface
{
    public function findVerification(string $email): ?Verification;
}