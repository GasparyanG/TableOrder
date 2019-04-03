<?php

namespace App\Service\ConfigurationFetcher\Keys;

interface KeysFetcherInterface
{
    public function getComment(): string;

    public function getRating(): string;

    public function getBookmark(): string;

    public function getRestaurant(): string;

    public function getPersonAmount(): string;

    public function getTableId(): string;

    public function getReservationTime(): string;

    public function getReservationDate(): string;

    public function getAmountOfTime(): string;
}