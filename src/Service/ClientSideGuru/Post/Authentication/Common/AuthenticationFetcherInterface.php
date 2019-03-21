<?php

namespace App\Service\ClientSideGuru\Post\Authentication\Common;

interface AuthenticationFetcherInterface
{
    public function getUsername(array $arrayOfFormData): ?string;

    public function getPassword(array $arrayOfFormData): ?string;
}