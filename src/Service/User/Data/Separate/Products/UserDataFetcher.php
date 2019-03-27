<?php

namespace App\Service\User\Data\Separate\Products;

use App\Service\ClientSideGuru\Cookies\CookieFetcherInterface;
use App\Service\User\Data\Separate\UserDataFetcherInterface;

// Http Foundation
use Symfony\Component\HttpFoundation\Request;

// entity
use App\Entity\User;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserDataFetcher implements UserDataFetcherInterface
{
    private $em;
    private $userRepo;
    private $cookieFetcher;
    private $request;

    public function __construct(RegistryInterface $registry, CookieFetcherInterface $cookieFetcher)
    {
        $this->cookieFetcher = $cookieFetcher;
        $this->request = Request::createFromGlobals();

        // db section
        $this->em = $registry->getEntityManager();
        $this->userRepo = $this->em->getRepository(User::class);
    }

    public function getUser(): ?User
    {
        $cookieId = $this->request->cookies->get($this->cookieFetcher->getUserCookieIdKey());

        if (!$cookieId) {
            return null;
        }

        $user = $this->userRepo->findOneBy(["cookie_id" => $cookieId]);

        return $user;
    }
}