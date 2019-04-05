<?php

namespace App\Service\Security\Validation\ObjectHandling;

use App\Service\Security\Validation\Objects\Login;

class LoginObjectHandlingStrategy extends ObjectHandlingAncestor implements ObjectHandlingInterface
{
    public function validate(): array
    {
        $logInObject = $this->populateObject();
        $errors = $this->validator->validate($logInObject);

        if (count($errors) === 0) {
            return [];
        }

        return $this->validationSupplier->convertErrorsToArray($errors);
    }

    protected function populateObject()
    {
        $loginObject = new Login();

        $formData = $this->request->request->all();

        // email
        $emailKey = $this->keysFetcher->getUsername();
        if (!isset($formData[$emailKey])) {
            $loginObject->setEmail("");
        }

        else {
            $loginObject->setEmail($formData[$emailKey]);
        }

        // password
        $passwordKey = $this->keysFetcher->getPassword();
        if (!isset($formData[$passwordKey])) {
            $loginObject->setPassword("");
        }

        else {
            $loginObject->setPassword($formData[$passwordKey]);
        }

        return $loginObject;
    }
}