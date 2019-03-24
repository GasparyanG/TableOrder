<?php

namespace App\Service\Security\Authentication\Validation\Objects\Verification;

class LessPropertyVerification
{
    private $username;
    private $verificationCode;

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getVerificationCode(): int
    {
        return $this->verificationCode;
    }

    public function setVerificationCode(int $verificationCode): self
    {
        $this->verificationCode = $verificationCode;

        return $this;
    }
}