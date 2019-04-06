<?php

namespace App\Service\Restaurants\Factory\HandlerFactory;

use App\Service\Restaurants\Factory\Products\RestaurantsHandlerInterface;
use Psr\Container\ContainerInterface;

class QueryParamHandlerFactoryStrategy implements HandlerFactoryInterface
{
    private $handlersBaseDirNamespace;
    private $handlers;
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $this->handlersBaseDirNamespace = "App\Service\Restaurants\Factory\Products\\";

        $this->handlers = [
            "ResentAddedRestaurants",
            "MostRatedRestaurants"
        ];
    }

    public function create(array $queryParams): RestaurantsHandlerInterface
    {
        foreach($this->handlers as $handler) {
            $fullyQualifiedNamespace = $this->handlersBaseDirNamespace . $handler;
            // init object with constructor

            $currentHandler = $this->container->get($fullyQualifiedNamespace);
            if ($currentHandler->isUsed($queryParams)) {
                return $currentHandler;
            }
        }

        throw new \RuntimeException("Object not chosen");
    }
}