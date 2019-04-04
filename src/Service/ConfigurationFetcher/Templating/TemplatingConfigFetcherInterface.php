<?php

namespace App\Service\ConfigurationFetcher\Templating;

interface TemplatingConfigFetcherInterface
{
    public function getDefaultPath(): string;

    public function getVerificationCodeVar(): string;

    public function getPersonAmount(): string;

    public function getCities(): string;

    public function getUser(): string;

    public function getReview(): string;

    public function getRestaurantRating(): string;

    public function getNotificationData(): string;
}