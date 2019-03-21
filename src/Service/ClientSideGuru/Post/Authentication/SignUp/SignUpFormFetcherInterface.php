<?php

namespace App\Service\ClientSideGuru\Post\Authentication\SignUp;

interface SignUpFormFetcherInterface
{
    public function getFirstName(array $arrayOfFormData): ?string;

    public function getLastName(array $arrayOfFormData): ?string;
}