<?php

namespace App\Service\ClientSideGuru\QueryString\Search;

use App\Service\ClientSideGuru\QueryString\Common\ParentFetcherInterface;

interface QueryStringFetcherInterface extends ParentFetcherInterface
{
    public function getGlobalBehavior(): string;

    public function getBehaviorKey(): string;

    public function getRestaurantName(array $queryString): ?string;

    public function getLocation(array $queryString): ?string;
}