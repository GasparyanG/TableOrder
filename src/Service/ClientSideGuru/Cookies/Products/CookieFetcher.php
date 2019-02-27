<?php

namespace App\Service\ClientSideGuru\Cookies\Products;

use App\Service\ClientSideGuru\Cookies\CookieFetcherInterface;
use Symfony\Component\Yaml\Yaml;

class CookieFetcher implements CookieFetcherInterface
{
    public function __construct()
    {
        $this->cookieConf = Yaml::parseFile(__DIR__ . "/../../../../../config/packages/client_side_guru/cookies.yaml");
    }

    public function getUserCookieIdKey(): string
    {
        return $this->cookieConf['key']['user']['cookieId'];
    }
}