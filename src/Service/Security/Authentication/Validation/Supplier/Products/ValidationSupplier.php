<?php

namespace App\Service\Security\Authentication\Validation\Supplier\Products;

use App\Service\Security\Authentication\Validation\Supplier\ValidationSupplierInterface;

class ValidationSupplier implements ValidationSupplierInterface
{
    public function convertErrorsToArray($errors): array
    {
        $arrToBeReturned = [];

        foreach($errors as $error) {
            $arrToBeReturned[] = $error->getMessage();
        }


        return $arrToBeReturned;
    }
}