<?php

namespace App\Service\Bridge\LoginAuthentication;

use App\Service\Security\Authentication\LoginAuthentication\LoginAuthenticationStrategyInterface;
use App\Service\Security\Validation\ObjectHandling\LoginObjectHandlingStrategy;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EmailLoginAuthenticationBridge implements LoginAuthenticationInterface
{
    private $request;
    private $loginObjectHandlingStrategy;
    private $loginAuthenticationStrategy;

    public function __construct(LoginObjectHandlingStrategy $loginObjectHandlingStrategy,
                                LoginAuthenticationStrategyInterface $loginAuthenticationStrategy)
    {
        $this->request = Request::createFromGlobals();
        $this->loginObjectHandlingStrategy = $loginObjectHandlingStrategy;
        $this->loginAuthenticationStrategy = $loginAuthenticationStrategy;
    }

    public function validateInputs(): array
    {
        return $this->loginObjectHandlingStrategy->validate();
    }

    public function isValid(): bool
    {
        return $this->loginAuthenticationStrategy->isValid();
    }

    public function renewCookie(Response $responseToAddCookiesTo): Response
    {
        return $this->loginAuthenticationStrategy->renewCookie($responseToAddCookiesTo);
    }
}