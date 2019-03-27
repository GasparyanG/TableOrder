<?php

namespace App\Service\User\Products;

use App\Service\User\Data\Composed\UserDataComposerInterface;
use App\Service\User\Data\Separate\UserDataFetcherInterface;
use App\Service\User\UserSupporterInterface;
use App\Service\ClientSideGuru\Cookies\Products\CookieFetcher;
// entities
use App\Entity\User;
use Symfony\Bridge\Doctrine\RegistryInterface;

// component
use Symfony\Component\HttpFoundation\Request;

class UserSupporter implements UserSupporterInterface
{
    private $request;
    private $cookieFetcher;
    private $doctrine;
    private $userRepo;
    private $userDataFetcher;
    private $userDataComposer;

    public function __construct(RegistryInterface $doctrine,
                                CookieFetcher $cookieFetcher,
                                UserDataFetcherInterface $userDataFetcher, UserDataComposerInterface $userDataComposer)
    {
        $this->request = Request::createFromGlobals();
        $this->cookieFetcher = $cookieFetcher;
        $this->userDataFetcher = $userDataFetcher;
        $this->userDataComposer = $userDataComposer;

        $this->doctrine = $doctrine;
        $em = $this->doctrine->getManager();
        $this->userRepo = $em->getRepository(User::class);
    }

    public function getUser(): ?User
    {
        return $this->userDataFetcher->getUser();
    }

    public function isAuthenticated(): bool
    {
        $cookieId = $this->request->cookies->get($this->cookieFetcher->getUserCookieIdKey());

        if ($cookieId) {
            return true;
        }

        return false;
    }

    public function getUserData(): array
    {
        return $this->userDataComposer->composeData();
    }
}