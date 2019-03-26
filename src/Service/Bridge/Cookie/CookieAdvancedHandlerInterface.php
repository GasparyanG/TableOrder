<?php

namespace App\Service\Bridge\Cookie;

interface CookieAdvancedHandlerInterface
{
    public function setCookie(string $email, bool $changeCookie = false): void;
}