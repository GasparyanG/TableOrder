<?php

namespace App\Service\Search\SearchFlow;

interface SearchFlowInterface
{
    /**
     * @return array|null array of assembled tables and required other data
     *  null if sth goes wrong
    */
    public function getNotReservedTables(): ?array;
}