<?php

namespace App\Service\DatabaseHighLvlManipulation\Insertion\User\Products;

use App\Service\ClientSideGuru\Post\Authentication\SignUp\SignUpFormFetcherInterface;
use App\Service\DatabaseHighLvlManipulation\Insertion\User\UserInsertionInterface;
use App\Service\Security\Cookie\CookieManipulatorInterface;
use App\Service\Security\Hashing\HashingManipulatorInterface;
use App\Service\User\Authority\Roles\RoleManipulationInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

// entities
use App\Entity\User;

class UserInserter implements UserInsertionInterface
{
    private $signUpFormFetcher;
    private $em;
    private $hashingManipulator;
    private $cookieManipulator;
    private $roleManipulation;

    public function __construct(SignUpFormFetcherInterface $signUpFormFetcher, RegistryInterface $registry, HashingManipulatorInterface $hashingManipulator, CookieManipulatorInterface $cookieManipulator, RoleManipulationInterface $roleManipulation)
    {
        $this->signUpFormFetcher = $signUpFormFetcher;
        $this->hashingManipulator = $hashingManipulator;
        $this->cookieManipulator = $cookieManipulator;
        $this->roleManipulation = $roleManipulation;

        // database section
        $this->em = $registry->getEntityManager();
    }

    public function InsertToDatabase(array $userCredentials): void
    {
        $user = new User();

        // first name
        $firstName = $this->signUpFormFetcher->getFirstName($userCredentials);
        $user->setFirstName($firstName);

        // last name
        $lastName = $this->signUpFormFetcher->getLastName($userCredentials);
        $user->setLastName($lastName);

        // registration time: int
        $registrationTime = time();
        $user->setRegistrationTime($registrationTime);

        // username: email
        $username = $this->signUpFormFetcher->getUsername($userCredentials);
        $user->setEmail($username);

        // HASHING
        // password
        $password = $this->signUpFormFetcher->getPassword($userCredentials);
        $hashedPassword = $this->hashingManipulator->hash_sha256($password);
        $user->setPassword($hashedPassword);

        // cookie_id
        $cookie = $this->cookieManipulator->createCookie();
        $user->setCookieId($cookie);

        // roles
        // other authority lvl will be defined manually!
        $roles = $this->roleManipulation->getRegularUserRoles();
        $user->setRoles($roles);

        $this->em->persist($user);
        $this->em->flush();
    }
}