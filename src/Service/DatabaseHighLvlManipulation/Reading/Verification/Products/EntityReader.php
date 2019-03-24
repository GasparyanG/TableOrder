<?php

namespace App\Service\DatabaseHighLvlManipulation\Reading\Verification\Products;

use App\Service\DatabaseHighLvlManipulation\Reading\Verification\EntityReadingInterface;

// entity
use App\Entity\Verification;
use Symfony\Bridge\Doctrine\RegistryInterface;

class EntityReader implements EntityReadingInterface
{
    private $em;
    private $verificationRepo;

    public function __construct(RegistryInterface $registry)
    {
        $this->em = $registry->getEntityManager();
        $this->verificationRepo = $this->em->getRepository(Verification::class);
    }

    public function findVerification(string $email): ?Verification
    {
        return $this->verificationRepo->findOneBy(["email" => $email]);
    }
}