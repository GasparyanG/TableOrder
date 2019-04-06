<?php

namespace App\Service\Restaurants;

use App\Service\Restaurants\Factory\HandlerFactory\HandlerFactoryInterface;
use App\Service\Restaurants\QueryParams\Checking\RestaurantsQueryParamCheckerInterface;
use App\Service\Restaurants\QueryParams\Preparing\RestaurantsQueryParamPreparingInterface;

class QueryParamSuperHandlerStrategy implements RestaurantSuperHandlerInterface
{
    private $restaurantsQueryParamChecker;
    private $restaurantsQueryParamPreparing;
    private $handlerFactory;

    public function __construct(RestaurantsQueryParamCheckerInterface $restaurantsQueryParamChecker,
                                RestaurantsQueryParamPreparingInterface $restaurantsQueryParamPreparing, HandlerFactoryInterface $handlerFactory)
    {
        $this->restaurantsQueryParamChecker = $restaurantsQueryParamChecker;
        $this->restaurantsQueryParamPreparing = $restaurantsQueryParamPreparing;
        $this->handlerFactory = $handlerFactory;
    }

    public function getRestaurants(): array
    {
        $queryParams = null;

        if (!$this->restaurantsQueryParamChecker->check()) {
            $queryParams = $this->restaurantsQueryParamPreparing->getDefaultQueryParams();
        }

        else {
            $queryParams = $this->restaurantsQueryParamPreparing->getSettledQueryParams();
        }

        // create object, which will return desired array, with desired filter used!
        $restaurantsPreparingHandler = $this->handlerFactory->create($queryParams);

        return $restaurantsPreparingHandler->getRestaurants($queryParams);
    }
}