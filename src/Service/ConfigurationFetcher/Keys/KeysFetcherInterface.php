<?php

namespace App\Service\ConfigurationFetcher\Keys;

interface KeysFetcherInterface
{
    public function getComment(): string;

    public function getRating(): string;
}