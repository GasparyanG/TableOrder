<?php

namespace App\Service\ConfigurationFetcher\AppSimpleConfig;

interface AppSimpleConfigFetcherInterface
{
    public function getTriesAmount(): int;
}