<?php

namespace App\Service\Security\Authentication\Validation\Components\Username;

interface UsernameCheckerInterface
{
    public function checkUsername(array $arrayOfFormData): ?string;
}