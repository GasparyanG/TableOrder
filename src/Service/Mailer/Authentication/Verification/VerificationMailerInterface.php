<?php

namespace App\Service\Mailer\Authentication\Verification;

interface VerificationMailerInterface
{
    public function sendVerificationCode(string $email): void;
}