<?php

namespace App\Service\ConfigurationFetcher\Specific;

interface SpecificConfigFetcherInterface
{
    public function getUsername(): string;

    public function getPassword(): string;
}