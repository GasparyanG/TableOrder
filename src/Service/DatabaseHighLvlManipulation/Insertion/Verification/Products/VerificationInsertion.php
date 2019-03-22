<?php

namespace App\Service\DatabaseHighLvlManipulation\Insertion\Verification\Products;

use App\Service\ClientSideGuru\Post\Authentication\SignUp\SignUpFormFetcherInterface;
use App\Service\DatabaseHighLvlManipulation\Insertion\Verification\VerificationInsertionInterface;
use App\Service\Security\Authentication\Verification\Generator\VerificationGeneratorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

// entities
use App\Entity\Verification;

class VerificationInsertion implements VerificationInsertionInterface
{
    private $verificationGenerator;
    private $em;
    private $authenticationFetcher;

    public function __construct(VerificationGeneratorInterface $verificationGenerator, RegistryInterface $registry, SignUpFormFetcherInterface $authenticationFetcher)
    {
        $this->verificationGenerator = $verificationGenerator;
        $this->em = $registry->getEntityManager();
        $this->authenticationFetcher = $authenticationFetcher;
    }

    public function insertToDatabase(array $userCredentials)
    {
        $verification = new Verification();

        // username
        $username = $this->authenticationFetcher->getUsername($userCredentials);
        $verification->setEmail($username);

        // verification code
        $verificationCode = $this->verificationGenerator->getVerificationCode();
        $verification->setCode($verificationCode);

        // creation time: int
        $creationTime = time();
        $verification->setCreationTime($creationTime);

        $this->em->persist($verification);
        $this->em->flush();
    }
}