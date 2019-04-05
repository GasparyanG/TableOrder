<?php

namespace App\Service\Security\Authentication\LoginAuthentication;

interface LoginAuthenticationStrategyInterface
{
    public function isValid(): bool;

    public function renewCookie(): void;
}