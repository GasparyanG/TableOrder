<?php

namespace App\Service\Bridge\LoginAuthentication;

interface LoginAuthenticationInterface
{
    public function validateInputs(): array;

    public function isValid(): bool;

    public function renewCookie(): void;
}