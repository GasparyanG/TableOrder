<?php

namespace App\Service\ConfigurationFetcher\Keys;

interface KeysFetcherInterface
{
    public function getComment(): string;

    public function getRating(): string;

    public function getBookmark(): string;

    public function getRestaurant(): string;
}