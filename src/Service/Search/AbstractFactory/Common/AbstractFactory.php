<?php

namespace App\Service\Search\AbstractFactory\Common;

use App\Service\ClientSideGuru\QueryString\Search\QueryStringFetcherInterface;

class AbstractFactory
{
    public function __construct(QueryStringFetcherInterface $fetcher)
    {
        $this->fetcher = $fetcher;
    }
}