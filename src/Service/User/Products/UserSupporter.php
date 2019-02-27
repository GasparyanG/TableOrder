<?php

/**
 * []- find out why Request can't be wired with service from constructer
 */

namespace App\Service\User\Products;

use App\Service\User\UserSupporterInterface;
use App\Service\ClientSideGuru\Cookies\Products\CookieFetcher;
// entities
use App\Entity\User;
use Symfony\Bridge\Doctrine\RegistryInterface;

// component
use Symfony\Component\HttpFoundation\Request;

class UserSupporter implements UserSupporterInterface
{
    public function __construct(RegistryInterface $doctrine, CookieFetcher $cookieFetcher)
    {
        $this->request = Request::createFromGlobals();
        $this->cookieFetcher = $cookieFetcher;

        $this->doctrine = $doctrine;
        $em = $this->doctrine->getManager();
        $this->userRepo = $em->getRepository(User::class);
    }

    public function getUser(): User
    {
        $cookieId = $this->request->cookies->get($this->cookieFetcher->getUserCookieIdKey());
        $user = $this->userRepo->findOneBy(["cookie_id" => $cookieId]);

        return $user;
    }
}