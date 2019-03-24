<?php

namespace App\Service\ClientSideGuru\Post\Authentication\Verification;

interface VerificationFetcherInterface
{
    public function getVerificationCode(array $postData);
}