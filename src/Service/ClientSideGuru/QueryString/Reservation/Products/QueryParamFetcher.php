<?php

namespace App\Service\ClientSideGuru\QueryString\Reservation\Products;

use App\Service\ClientSideGuru\QueryString\Reservation\QueryParamFetcherInterface;
use App\Service\ClientSideGuru\QueryString\Common\Products\ParentFetcher;
use Symfony\Component\Yaml\Yaml;

class QueryParamFetcher extends ParentFetcher implements QueryParamFetcherInterface
{
    public function getTableId(array $queryParams): ?int
    {
        if (isset($queryParams[$this->queryParamKeysConf['reservation']['tableId']])) {
            if (is_int((int)$queryParams[$this->queryParamKeysConf['reservation']['tableId']])) {
                return $queryParams[$this->queryParamKeysConf['reservation']['tableId']];
            }
        }

        return null;
    }
}