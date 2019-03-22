<?php

namespace App\Service\Security\Authentication\Validation\Components\Username\Products;

use App\Service\ClientSideGuru\DefaultErrors\DefaultErrorMessageFetcherInterface;
use App\Service\ClientSideGuru\Post\Authentication\SignUp\SignUpFormFetcherInterface;
use App\Service\Security\Authentication\Validation\Components\Username\UsernameCheckerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

// entities
use App\Entity\User;


class UsernameChecker implements UsernameCheckerInterface
{
    private $authenticationFetcher;
    private $defaultErrorMessageFetcher;

    public function __construct(SignUpFormFetcherInterface $authenticationFetcher, RegistryInterface $registry, DefaultErrorMessageFetcherInterface $defaultErrorMessageFetcher, LoggerInterface $logger)
    {
        $this->authenticationFetcher = $authenticationFetcher;
        $this->defaultErrorMessageFetcher = $defaultErrorMessageFetcher;

        // db configuration
        $this->em = $registry->getEntityManager();
        $this->userRepo = $this->em->getRepository(User::class);

        // dev
        $this->logger = $logger;

    }

    public function checkUsername(array $arrayOfFormData): ?string
    {
        $username = $this->authenticationFetcher->getUsername($arrayOfFormData);

        if ($this->usernameAlreadyExists($username)) {
            return $this->defaultErrorMessageFetcher->getEmailAlreadyInUse();
        }

        if (!$this->isEmail($username)) {
            return $this->defaultErrorMessageFetcher->getEmailFormatIsWrong();
        }

        // checking is passed!
        return null;
    }

    private function usernameAlreadyExists(?string $email): bool
    {
        $user = $this->userRepo->findOneBy(["email" => $email]);

        if ($user) {
            $this->logger->info("email exists");

            return true;
        }

        $this->logger->info("email doesn't exists");

        return false;
    }

    private function isEmail(string $username): bool
    {
        if(filter_var($username, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        else {
            return false;
        }
    }
}

