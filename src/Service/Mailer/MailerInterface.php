<?php

namespace App\Service\Mailer;

interface MailerInterface
{
    public function sendVerificationCode(string $email): void;
}