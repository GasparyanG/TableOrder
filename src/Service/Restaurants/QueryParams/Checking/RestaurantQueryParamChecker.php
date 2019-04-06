<?php

namespace App\Service\Restaurants\QueryParams\Checking;

use App\Service\ConfigurationFetcher\Specific\Restaurants\RestaurantsConfigFetcherInterface;
use Symfony\Component\HttpFoundation\Request;

class RestaurantQueryParamChecker implements RestaurantsQueryParamCheckerInterface
{
    private $request;
    private $restaurantsConfigFetcher;

    public function __construct(RestaurantsConfigFetcherInterface $restaurantsConfigFetcher)
    {
        $this->request = Request::createFromGlobals();
        $this->restaurantsConfigFetcher = $restaurantsConfigFetcher;
    }

    public function check(): bool
    {
        $queryParams = $this->request->query->all();

        if (!$this->keys($queryParams)) {
            return false;
        }

        if (!$this->validFilter($queryParams)) {
            return false;
        }

        return true;
    }

    private function keys($queryParams): bool
    {
        // filter
        if (!isset($queryParams[$this->restaurantsConfigFetcher->getFilter()])) {
            return false;
        }

        if (!isset($queryParams[$this->restaurantsConfigFetcher->getOffset()])) {
            return false;
        }

        return true;
    }

    private function validFilter($queryParams): bool
    {
        $filter = $queryParams[$this->restaurantsConfigFetcher->getFilter()];
        $arrayOfFilters = $this->restaurantsConfigFetcher->getFilters();

        if (!in_array($filter, $arrayOfFilters)) {
            return false;
        }

        return true;
    }
}