<?php

namespace App\Service\Mailer\DataPreparing\Products;

use App\Service\ConfigurationFetcher\Templating\TemplatingConfigFetcherInterface;
use App\Service\Mailer\DataPreparing\DataPreparingInterface;

// entity
use App\Entity\Verification;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DataPreparingEngine implements DataPreparingInterface
{
    private $templatingConfigFetcher;
    private $em;
    private $verificationRepo;

    public function __construct(TemplatingConfigFetcherInterface $templatingConfigFetcher, RegistryInterface $registry)
    {
        $this->templatingConfigFetcher = $templatingConfigFetcher;

        // database
        $this->em = $registry->getEntityManager();
        $this->verificationRepo = $this->em->getRepository(Verification::class);

    }

    public function getVerificationData(string $email): array
    {
        $arrayOfData = [];

        // verification code
        $verification = $this->getVerificationUser($email);
        $verificationCode = $verification->getCode();
        $arrayOfData[$this->templatingConfigFetcher->getVerificationCodeVar()] =  $verificationCode;

        return $arrayOfData;
    }

    private function getVerificationUser(string $email)
    {
        $verification = $this->verificationRepo->findOneBy(["email" => $email]);

        return $verification;
    }
}