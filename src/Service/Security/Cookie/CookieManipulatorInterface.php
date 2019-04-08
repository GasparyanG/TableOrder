<?php

namespace App\Service\Security\Cookie;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

interface CookieManipulatorInterface
{
    /*
     * while this method is called new cookie will be created and returned
     *
     * @return  string|null
     * */
    public function createCookie(): ?string;

    public function setCookie(string $cookie): void;

    public function prepareCookie(string $cookieValue): Cookie;

    public function setUserCookieAndReturnResponse(string $cookieValue, Response $responseToAddCookiesTo): Response;
}