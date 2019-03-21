<?php

namespace App\Service\Security\Authentication\Validation\SignUpValidation;

interface SignUpFormValidationInterface
{
    public function validateForm(array $arrayOfFormData): array;
    public function checkUsername(array $arrayOfFormData): ?string;
}