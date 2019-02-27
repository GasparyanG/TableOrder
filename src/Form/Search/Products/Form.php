<?php

namespace App\Form\Search\Products;

use App\Form\Search\Interfaces\SearchFormInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
// entities
use App\Entity\Location;

class Form implements SearchFormInterface
{
    public function __construct(RegistryInterface $doctrine)
    {
        // static properties
        $this->personAmountLimit = 20;

        // services
        $this->doctrine = $doctrine;

        // repositores
        $this->em = $this->doctrine->getManager();
        $this->locationRepo = $this->em->getRepository(Location::class);
    }

    public function getLocationsForChoiceType(): array
    {
        $locations = $this->locationRepo->findAll();
        
        return $this->convertForChoiceType($locations);
    }

    private function convertForChoiceType(array $locations): array
    {
        $choiceTypeArray = [];
        foreach ($locations as $location) {
            $choiceTypeArray[$location->getCity()][$location->getRegion()] = $location->getRegion();
        }

        return $choiceTypeArray;
    }

    public function getPersonAmountArray():array
    {
        return range(1, 20);
    }
}