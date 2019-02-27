<?php

namespace App\Service\Search\Products\Searcher;

interface SearcherInterface
{
    public function getNotReservedTables(array $queryParams): ?array;
}