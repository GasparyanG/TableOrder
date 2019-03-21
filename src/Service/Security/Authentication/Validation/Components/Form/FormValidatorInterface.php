<?php

namespace App\Service\Security\Authentication\Validation\Components\Form;

interface FormValidatorInterface
{
    public function validateForm(array $arrayOfFormData): array;
}