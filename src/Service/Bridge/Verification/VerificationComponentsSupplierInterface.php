<?php

namespace App\Service\Bridge\Verification;

use App\Entity\Verification;

interface VerificationComponentsSupplierInterface
{
    public function validateVerification(): array;

    public function findVerification(string $email): ?Verification;

    public function isVerified(Verification $verification, string $verificationCode): bool;

    public function setCookie(string $email, bool $changeCookie = false): void;

    public function setTries(Verification $verification): void;
}