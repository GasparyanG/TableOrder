<?php

namespace App\Service\Mailer;

use App\Service\Mailer\Authentication\Verification\VerificationMailerInterface;

class Mailer implements MailerInterface
{
    private $verificationMailer;

    public function __construct(VerificationMailerInterface $verificationMailer)
    {
        $this->verificationMailer = $verificationMailer;
    }

    public function sendVerificationCode(string $email): void
    {
        $this->verificationMailer->sendVerificationCode($email);
    }
}