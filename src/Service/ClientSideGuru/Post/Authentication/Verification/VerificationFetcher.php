<?php

namespace App\Service\ClientSideGuru\Post\Authentication\Verification;

use Symfony\Component\Yaml\Yaml;

class VerificationFetcher implements VerificationFetcherInterface
{
    private $authenticationFormConf;

    public function __construct()
    {
        $this->authenticationFormConf = Yaml::parseFile(__DIR__ . "/../../../../../../config/packages/client_side_guru/post/authentication_form.yaml");
    }

    public function getVerificationCode(array $postData)
    {
        $verificationCodeKey = $this->authenticationFormConf["verification"]["verificationCode"];

        if (isset($postData[$verificationCodeKey])) {
            return $postData[$verificationCodeKey];
        }

        return null;
    }
}