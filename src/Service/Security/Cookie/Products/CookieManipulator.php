<?php

namespace App\Service\Security\Cookie\Products;

use App\Service\ClientSideGuru\Cookies\CookieFetcherInterface;
use App\Service\Security\Cookie\CookieManipulatorInterface;
use App\Service\Security\Hashing\HashingManipulatorInterface;

// HttpFoundation
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;

class CookieManipulator implements CookieManipulatorInterface
{
    private $request;
    private $hashingManipulator;
    private $cookieFetcher;

    public function __construct(HashingManipulatorInterface $hashingManipulator, CookieFetcherInterface $cookieFetcher)
    {
        $this->request = Request::createFromGlobals();
        $this->hashingManipulator = $hashingManipulator;
        $this->cookieFetcher = $cookieFetcher;
    }

    public function createCookie(): ?string
    {
        $userIp = $this->request->getClientIp();
        $currentTime = time();

        $unHashedCookie = $userIp . $currentTime;

        // hashed cookie
        return $this->hashingManipulator->hash_md5($unHashedCookie);
    }

    public function setCookie(string $cookieValue): void
    {
        $response = new Response();

        $cookie = $this->prepareCookie($cookieValue);

        $response->headers->setCookie($cookie);

        // sending response to set cookie in browser of user;
        $response->send();
    }

    public function prepareCookie(string $cookieValue): Cookie
    {
        $cookieName = $this->cookieFetcher->getUserCookieIdKey();
        $expTimeAmount = $this->cookieFetcher->getExpTime();
        $expTime = time() + $expTimeAmount;

        $cookie = new Cookie($cookieName, $cookieValue, $expTime);

        return $cookie;
    }

    public function setUserCookieAndReturnResponse(string $cookieValue, Response $responseToAddCookiesTo): Response
    {
        $cookie = $this->prepareCookie($cookieValue);

        $responseToAddCookiesTo->headers->setCookie($cookie);

        return $responseToAddCookiesTo;
    }
}