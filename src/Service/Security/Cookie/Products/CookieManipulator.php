<?php

namespace App\Service\Security\Cookie\Products;

use App\Service\Security\Cookie\CookieManipulatorInterface;
use App\Service\Security\Hashing\HashingManipulatorInterface;
use Symfony\Component\HttpFoundation\Request;

class CookieManipulator implements CookieManipulatorInterface
{
    private $request;
    private $hashingManipulator;

    public function __construct(HashingManipulatorInterface $hashingManipulator)
    {
        $this->request = Request::createFromGlobals();
        $this->hashingManipulator = $hashingManipulator;
    }

    public function createCookie(): ?string
    {
        $userIp = $this->request->getClientIp();
        $currentTime = time();

        $unHashedCookie = $userIp . $currentTime;

        // hashed cookie
        return $this->hashingManipulator->hash_md5($unHashedCookie);
    }
}