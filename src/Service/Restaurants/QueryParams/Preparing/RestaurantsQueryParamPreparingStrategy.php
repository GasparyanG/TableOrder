<?php

namespace App\Service\Restaurants\QueryParams\Preparing;

use App\Service\ConfigurationFetcher\Specific\Restaurants\RestaurantsConfigFetcherInterface;
use Symfony\Component\HttpFoundation\Request;

class RestaurantsQueryParamPreparingStrategy implements RestaurantsQueryParamPreparingInterface
{
    protected $request;
    protected $restaurantsConfigFetcher;
    protected $defaultQueryParams;

    public function __construct(RestaurantsConfigFetcherInterface $restaurantsConfigFetcher)
    {
        $this->request = Request::createFromGlobals();
        $this->restaurantsConfigFetcher = $restaurantsConfigFetcher;
        $this->defaultQueryParams = [];
    }

    public function getDefaultQueryParams(): array
    {
        $this->addFilter();
        $this->addOffset();

        return $this->defaultQueryParams;
    }

    public function getSettledQueryParams(): array
    {
        return $this->request->query->all();
    }

    protected function addFilter(): void
    {
        $filterKey = $this->restaurantsConfigFetcher->getFilter();
        $defaultFilter = $this->restaurantsConfigFetcher->getDefaultFilter();
        $this->defaultQueryParams[$filterKey] = $defaultFilter;
    }

    protected function addOffset(): void
    {
        $offsetKey = $this->restaurantsConfigFetcher->getOffset();
        $defaultOffset = $this->restaurantsConfigFetcher->getDefaultOffset();
        $this->defaultQueryParams[$offsetKey] = $defaultOffset;
    }
}