<?php

namespace App\Service\Bridge\SignUpAuthentication;

interface SignUpAuthenticationInterface
{
    public function validateForm(array $userCredentials): array;

    public function checkUsername(array $userCredentials): ?string;

    public function insertUserToDatabase(array $userCredentials): void;

    public function insertVerificationToDatabase(array $userCredentials): void;

    public function sendVerificationCode(array $userCredentials): void;
}