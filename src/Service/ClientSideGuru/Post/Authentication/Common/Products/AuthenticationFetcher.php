<?php

namespace App\Service\ClientSideGuru\Post\Authentication\Common\Products;

use App\Service\ClientSideGuru\Post\Authentication\Common\AuthenticationFetcherInterface;
use Symfony\Component\Yaml\Yaml;

class AuthenticationFetcher implements AuthenticationFetcherInterface
{
    // this need to be used by children also
    protected $authenticationFormConf;

    public function __construct()
    {
        $this->authenticationFormConf = Yaml::parseFile(__DIR__ . "/../../../../../../../config/packages/client_side_guru/post/authentication_form.yaml");
    }

    public function getUsername(array $arrayOfFormData): ?string
    {
        $usernameKey = $this->authenticationFormConf["common"]["username"];

        if (isset($arrayOfFormData[$usernameKey])) {
            return $arrayOfFormData[$usernameKey];
        }

        // if not mention void will be returned, which violates defined return type hint!
        return null;
    }

    public function getPassword(array $arrayOfFormData): ?string
    {
        $passwordKey = $this->authenticationFormConf["common"]["password"];

        if (isset($arrayOfFormData[$passwordKey])) {
            return $arrayOfFormData[$passwordKey];
        }

        return null;
    }
}