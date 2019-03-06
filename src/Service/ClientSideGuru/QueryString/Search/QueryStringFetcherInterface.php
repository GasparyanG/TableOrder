<?php

namespace App\Service\ClientSideGuru\QueryString\Search;

use App\Service\ClientSideGuru\QueryString\Common\ParentFetcherInterface;

// by queryString === queryParams
interface QueryStringFetcherInterface extends ParentFetcherInterface
{
    public function getGlobalBehavior(): string;

    public function getRestaurantBehavior(): string;

    public function getBehaviorKey(): string;

    public function getRestaurantName(array $queryString): ?string;

    public function getRestaurantId(array $queryString): ?int;

    public function getLocation(array $queryString): ?string;
}