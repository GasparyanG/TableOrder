<?php

namespace App\Service\Security\Authentication\Verification;

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

    public function __construct(RegistryInterface $registry, VerificationGeneratorInterface $verificationGenerator, MailerInterface $mailer, LoggerInterface $logger)
    {
        // DEV
        $this->logger = $logger;

        // PROD
        $this->verificationGenerator = $verificationGenerator;
        $this->mailer = $mailer;

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
}