<?php

namespace App\Service\ClientSideGuru\QueryString\Common;

interface ParentFetcherInterface
{
    public function getPersonAmount(array $queryString): ?int;

    public function getReservationTime(array $queryString): ?string;

    public function getReservationDate(array $queryString): ?string;

    public function getAmountOfTime(array $assocArray): ?int;
}