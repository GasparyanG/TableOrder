<?php

namespace App\Service\Existence\Entity;

interface ExistenceHandlerInterface
{
    public function restaurantExists(string $restaurantName, int $restaurantId): bool;

    public function tableExists(int $tableId, int $restaurantId): bool;
}