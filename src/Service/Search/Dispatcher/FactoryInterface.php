<?php

namespace App\Service\Search\Dispatcher;

use App\Service\Search\AbstractFactory\Interfaces\SearchAbstractFactoryInterface;

interface FactoryInterface
{
    public function create(array $queryParams): ?SearchAbstractFactoryInterface;
}