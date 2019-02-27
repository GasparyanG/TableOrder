<?php

namespace App\Service\ClientSideGuru\QueryString\Reservation;

use App\Service\ClientSideGuru\QueryString\Common\ParentFetcherInterface;

interface QueryParamFetcherInterface extends ParentFetcherInterface
{
    public function getTableId(array $queryParam): ?int;
}