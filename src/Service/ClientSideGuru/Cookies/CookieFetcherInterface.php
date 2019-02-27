<?php

namespace App\Service\ClientSideGuru\Cookies;

interface CookieFetcherInterface
{
    public function getUserCookieIdKey(): string;
}