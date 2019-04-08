<?php

namespace App\Service\Security\Authentication\LoginAuthentication;

use Symfony\Component\HttpFoundation\Response;

interface LoginAuthenticationStrategyInterface
{
    public function isValid(): bool;

    public function renewCookie(Response $responseToAddCookiesTo): Response;
}