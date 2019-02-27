<?php
namespace App\Security\Cookie\Creation\Implementors;

use App\Security\Cookie\Creation\Interfaces\HashMakingInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Security\Hashing\Interfaces\HasherInterface;

class HashMaker implements HashMakingInterface
{
    private $request;

    public function __construct(HasherInterface $hasher)
    {
        $this->request = Request::createFromGlobals();
        $this->hasher = $hasher;
    }

    public function makeCookie(): string
    {
        $userIp = $this->request->getClientIp();
        $currentTime = $this->getTime();

        return $this->hasher->hash($userIp . $currentTime);
    }

    public function getTime(): int
    {
        return time();
    }
}