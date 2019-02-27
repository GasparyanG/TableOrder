<?php

namespace App\Service\ClientSideGuru\QueryString\Search\Products;

use App\Service\ClientSideGuru\QueryString\Search\QueryStringFetcherInterface;
use App\Service\ClientSideGuru\QueryString\Common\Products\ParentFetcher;

class QueryStringFetcher extends ParentFetcher implements QueryStringFetcherInterface
{
    public function getGlobalBehavior(): string
    {
        return $this->queryParamConf["search"]["behavior"]["global"];
    }

    public function getBehaviorKey(): string
    {
        return $this->queryParamKeysConf['search']['behavior'];
    }

    public function getRestaurantName(array $queryString): ?string
    {
        $keyForRestaurantName = $this->queryParamConf['search']['restaurantName'];

        if (isset($queryString[$keyForRestaurantName])) {
            return $queryString[$keyForRestaurantName];
        }
    }

    public function getLocation(array $queryString): ?string
    {
        $keyForLocation = $this->queryParamConf['search']['location'];

        if (isset($queryString[$keyForLocation])) {
            return $queryString[$keyForLocation];
        }
    }
}