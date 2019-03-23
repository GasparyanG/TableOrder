<?php

namespace App\Service\ConfigurationFetcher\Templating;

interface TemplatingConfigFetcherInterface
{
    public function getDefaultPath(): string;

    public function getVerificationCodeVar(): string;
}