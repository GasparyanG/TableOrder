<?php

namespace App\Service\Security\Cookie;

interface CookieManipulatorInterface
{
    /*
     * while this method is called new cookie will be created and returned
     *
     * @return  string|null
     * */
    public function createCookie(): ?string;

    public function setCookie(string $cookie): void;
}