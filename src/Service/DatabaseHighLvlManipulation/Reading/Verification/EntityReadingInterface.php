<?php

namespace App\Service\DatabaseHighLvlManipulation\Reading\Verification;

use App\Entity\Verification;

interface EntityReadingInterface
{
    public function findVerification(string $email): ?Verification;
}