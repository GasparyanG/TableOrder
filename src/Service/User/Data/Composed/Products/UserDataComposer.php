<?php

namespace App\Service\User\Data\Composed\Products;

use App\Service\ConfigurationFetcher\Templating\TemplatingConfigFetcherInterface;
use App\Service\User\Data\Composed\UserDataComposerInterface;
use App\Service\User\Data\Separate\UserDataFetcherInterface;

class UserDataComposer implements UserDataComposerInterface
{
    protected $userData;
    protected $templatingConfigFetcher;
    protected $userDataFetcher;

    public function __construct(TemplatingConfigFetcherInterface $templatingConfigFetcher, UserDataFetcherInterface $userDataFetcher)
    {
        $this->userData = [];
        $this->templatingConfigFetcher = $templatingConfigFetcher;
        $this->userDataFetcher = $userDataFetcher;
    }

    public function composeData(): array
    {
        $this->addUser();

        return $this->userData;
    }

    protected function addUser(): void
    {
        $userKey = $this->templatingConfigFetcher->getUser();

        $this->userData[$userKey] = $this->userDataFetcher->getUser();
    }
}