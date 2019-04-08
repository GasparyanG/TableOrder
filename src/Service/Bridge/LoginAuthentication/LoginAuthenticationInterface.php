<?php

namespace App\Service\Bridge\LoginAuthentication;

use Symfony\Component\HttpFoundation\Response;

interface LoginAuthenticationInterface
{
    public function validateInputs(): array;

    public function isValid(): bool;

    public function renewCookie(Response $responseToAddCookiesTo): Response;
}