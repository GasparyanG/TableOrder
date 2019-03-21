<?php

namespace App\Service\Security\Authentication\Validation\Supplier;

interface ValidationSupplierInterface
{
    public function convertErrorsToArray($errors): array;
}