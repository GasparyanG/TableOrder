<?php

namespace App\Service\ClientSideGuru\Defaults\Search;

interface DefaultsFetcherInterface
{
    public function getLocation(): string;

    public function getPersonAmount(): int;
}