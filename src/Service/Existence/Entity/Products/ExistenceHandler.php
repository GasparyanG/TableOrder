<?php

/**
 * []- make entity feald names configured in yaml conf files
 */

namespace App\Service\Existence\Entity\Products;

use App\Service\Existence\Entity\ExistenceHandlerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

// entities
use App\Entity\Restaurant;
use App\Entity\RestaurantTable;

class ExistenceHandler implements ExistenceHandlerInterface
{
    private $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;

        // database configuration
        $em = $this->doctrine->getManager();
        $this->restaurantRepo = $em->getRepository(Restaurant::class);
        $this->restaurantTableRepo = $em->getRepository(RestaurantTable::class);
    }

    public function restaurantExists(string $restaurantName, int $restaurantId): bool
    {
        $restaurants = $this->restaurantRepo->findBy(["id" => $restaurantId, "name" => $restaurantName]);

        if (count($restaurants) === 0) {
            return false;
        }

        return true;
    }

    public function tableExists(int $tableId, int $restaurantId): bool
    {
        $tables = $this->restaurantTableRepo->findBy(["id" => $tableId, "restaurant" => $restaurantId]);

        if (count($tables) === 0) {
            return false;
        }

        return true;
    }
}