<?php

namespace App\Service\ConfigurationFetcher\Database\DatabaseNames;

interface DatabaseNameFetcherInterface
{
    public function getReservationTableName(): string;
}