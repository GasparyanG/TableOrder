<?php

namespace App\Service\ConfigurationFetcher\Database;

interface DatabaseFetcherInterface
{
    public function getReservationUpcomingLimit(): int;

    public function getReservationPassedLimit(): int;

    public function getReservationUpcomingMax(): int;

    public function getReservationPassedMax(): int;
}