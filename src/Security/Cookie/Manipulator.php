<?php
namespace App\Security\Cookie;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;

class Manipulator
{
    public function __construct()
    {
        $this->cookieTime = [
            // one year
            "cookieId" => 60 * 60 * 24 * 30 * 12,
        ];
    }

    public function setCookie(string $cookieToSet): void
    {
        $response = new Response();
        $cookie = new Cookie("cookieId", $cookieToSet, $this->cookieTime['cookieId']);
        $response->headers->setCookie($cookie);
        
        $response->send();
    }
}