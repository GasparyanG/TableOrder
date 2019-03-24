<?php

namespace App\Service\DatabaseHighLvlManipulation\EntityManipulation\Verification\Products;

use App\Service\DatabaseHighLvlManipulation\EntityManipulation\Verification\VerificationManipulatorInterface;
use App\Service\DatabaseHighLvlManipulation\Reading\Verification\EntityReadingInterface;

//entity
use App\Entity\Verification;

class VerificationManipulator implements VerificationManipulatorInterface
{
    private $reader;

    public function __construct(EntityReadingInterface $reader)
    {
        $this->reader = $reader;
    }

    public function findVerification(string $email): ?Verification
    {
        return $this->reader->findVerification($email);
    }
}