<?php

namespace App\Service\Security\Authentication\Verification;

use App\Service\ConfigurationFetcher\AppSimpleConfig\AppSimpleConfigFetcherInterface;
use App\Service\Mailer\MailerInterface;
use App\Service\Security\Authentication\Verification\Generator\VerificationGeneratorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

// entities
use App\Entity\Verification;

// DEV
use Psr\Log\LoggerInterface;

class VerificationHandler implements VerificationHandlerInterface
{
    private $em;
    private $verificationRepo;
    private $verificationGenerator;
    private $mailer;
    private $appSimpleConfigFetcher;

    public function __construct(RegistryInterface $registry, VerificationGeneratorInterface $verificationGenerator, MailerInterface $mailer, AppSimpleConfigFetcherInterface $appSimpleConfigFetcher, LoggerInterface $logger)
    {
        // DEV
        $this->logger = $logger;

        // PROD
        $this->verificationGenerator = $verificationGenerator;
        $this->mailer = $mailer;
        $this->appSimpleConfigFetcher = $appSimpleConfigFetcher;

        // db
        $this->em = $registry->getEntityManager();
        $this->verificationRepo = $this->em->getRepository(Verification::class);
    }

    public function requiresToBeVerified(string $email): bool
    {
        $verification = $this->verificationRepo->findOneBy(["email" => $email]);

        if ($verification) {
            $verificationCode = $this->verificationGenerator->getVerificationCode();
            $verification->setCode($verificationCode);

            $this->em->persist($verification);
            $this->em->flush();

            $this->mailer->sendVerificationCode($email);

            return true;
        }

        return false;
    }

    public function setTries(Verification $verification): void
    {
        $tries = $verification->getTries();

        $triesLimit = $this->appSimpleConfigFetcher->getTriesAmount();

        // TRIES = NULL
        if ($tries === null) {
            $verification->setTries(1);

            $this->em->persist($verification);
            $this->em->flush();
        }

        // TRIES < TRIES LIMIT
        elseif ($tries < $triesLimit) {
            $verification->setTries($tries + 1);

            $this->em->persist($verification);
            $this->em->flush();
        }

        // TRIES = TRIES LIMIT
        elseif ($tries === $triesLimit) {
            // setting code
            $verificationCode = $this->verificationGenerator->getVerificationCode();
            $verification->setCode($verificationCode);

            // setting tries to null
            $verification->setTries(null);

            // persist and flush
            $this->em->persist($verification);
            $this->em->flush();

            // sending email to verification's email address
            $email = $verification->getEmail();
            $this->mailer->sendVerificationCode($email);
        }
    }

    public function isVerified(Verification $verification, string $verificationCode): bool
    {
        $realCode = $verification->getCode();

        if ($realCode == $verificationCode) {
            // remove from database!
            $this->em->remove($verification);
            $this->em->flush();

            return true;
        }

        return false;
    }
}