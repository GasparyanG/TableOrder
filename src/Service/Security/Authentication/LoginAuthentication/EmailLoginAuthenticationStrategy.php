<?php

namespace App\Service\Security\Authentication\LoginAuthentication;

use App\Service\ConfigurationFetcher\Keys\KeysFetcherInterface;
use App\Service\Security\Cookie\CookieManipulatorInterface;
use App\Service\Security\Hashing\HashingManipulatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Request;

// entity
use App\Entity\User;

class EmailLoginAuthenticationStrategy implements LoginAuthenticationStrategyInterface
{
    private $request;
    private $keysFetcher;
    private $hashingManipulator;
    private $cookieManipulator;

    // db
    private $em;
    private $userRepo;

    public function __construct(RegistryInterface $registry,
                                KeysFetcherInterface $keysFetcher,
                                HashingManipulatorInterface $hashingManipulator,
                                CookieManipulatorInterface $cookieManipulator)
    {
        $this->request = Request::createFromGlobals();
        $this->keysFetcher = $keysFetcher;
        $this->hashingManipulator = $hashingManipulator;
        $this->cookieManipulator = $cookieManipulator;

        //db
        $this->em = $registry->getEntityManager();
        $this->userRepo = $this->em->getRepository(User::class);
    }

    public function isValid(): bool
    {
        $formParam = $this->request->request->all();

        // email: prev method checks whether email and password exists or not!
        $email = $formParam[$this->keysFetcher->getUsername()];

        // fetching user from database and checking to see whether user exists or not
        $user = $this->userRepo->findOneBy(["email" => $email]);

        if (!$user) {
            return false;
        }

        // password checking
        $passedPassword = $formParam[$this->keysFetcher->getPassword()];
        // hashing
        $passedPasswordHashed = $this->hashingManipulator->hash_sha256($passedPassword);

        // comparision
        if ($passedPasswordHashed !== $user->getPassword()){
            return false;
        }

        return true;
    }

    public function renewCookie(): void
    {
        $formParam = $this->request->request->all();
        $email = $formParam[$this->keysFetcher->getUsername()];
        $user = $this->userRepo->findOneBy(["email" => $email]);

        $userCookie = $user->getCookieId();

        // set cookie
        $this->cookieManipulator->setCookie($userCookie);
    }
}