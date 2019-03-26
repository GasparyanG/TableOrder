<?php

namespace App\Service\Bridge\Cookie\Products;

use App\Service\Bridge\Cookie\CookieAdvancedHandlerInterface;
use App\Service\Security\Cookie\CookieManipulatorInterface;

// entity
use App\Entity\User;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CookieAdvancedHandler implements CookieAdvancedHandlerInterface
{
    private $em;
    private $userRepo;
    private $cookieManipulator;

    public function __construct(RegistryInterface $registry, CookieManipulatorInterface $cookieManipulator)
    {
        $this->cookieManipulator = $cookieManipulator;

        // db
        $this->em = $registry->getEntityManager();
        $this->userRepo = $this->em->getRepository(User::class);
    }

    public function setCookie(string $email, bool $changeCookie = false): void
    {
        $user = $this->userRepo->findOneBy(["email" => $email]);

        $cookie = null;

        // change cookie: e.g. this will be used at login
        if ($changeCookie) {
            $cookie = $this->cookieManipulator->createCookie();
            $user->setCookieId($cookie);

            $this->em->persist($user);
            $this->em->flush();
        }

        else {
            $cookie = $user->getCookieId();
        }

        $this->cookieManipulator->setCookie($cookie);
    }
}