<?php
namespace App\Security\Cookie;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

class CookieSetter
{
    private $cookiesExpTime;

    public function __construct()
    {
        $this->cookiesExpTime = [
            // one month
            "userId" => 60 * 60 * 24 * 30
        ];
    }

    public function setCookieId(string $cookie): Cookie
    {
        $response = new Response();
        $cookie = new Cookie("cookieId", $cookie, time() . $this->cookiesExpTime["userId"]);
        $response->headers->setCookie($cookie);

        $response->send();
        
        return $cookie;
    }
}