<?php

namespace App\Service\ClientSideGuru\Post\Authentication\SignUp\Products;

use App\Service\ClientSideGuru\Post\Authentication\Common\Products\AuthenticationFetcher;
use App\Service\ClientSideGuru\Post\Authentication\SignUp\SignUpFormFetcherInterface;

class SignUpFormFetcher extends AuthenticationFetcher implements SignUpFormFetcherInterface
{
    public function getFirstName(array $arrayOfFormData): ?string
    {
        $firstNameKey = $this->authenticationFormConf["sign_up"]["first_name"];

        if (isset($arrayOfFormData[$firstNameKey])) {
            return $arrayOfFormData[$firstNameKey];
        }

        return null;
    }

    public function getLastName(array $arrayOfFormData): ?string
    {
        $lastNameKey = $this->authenticationFormConf["sign_up"]["last_name"];

        if (isset($arrayOfFormData[$lastNameKey])) {
            return $arrayOfFormData[$lastNameKey];
        }

        return null;
    }
}