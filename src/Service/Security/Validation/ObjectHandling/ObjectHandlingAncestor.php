<?php

namespace App\Service\Security\Validation\ObjectHandling;

use App\Service\ConfigurationFetcher\Keys\KeysFetcherInterface;
use App\Service\Security\Authentication\Validation\Supplier\ValidationSupplierInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ObjectHandlingAncestor
{
    protected $validationSupplier;
    protected $request;
    protected $keysFetcher;
    protected $validator;

    public function __construct(ValidationSupplierInterface $validationSupplier,
                                KeysFetcherInterface $keysFetcher,
                                ValidatorInterface $validator)
    {
        $this->validationSupplier = $validationSupplier;
        $this->request = Request::createFromGlobals();
        $this->keysFetcher = $keysFetcher;
        $this->validator = $validator;
    }

    protected function populateObject()
    {
        // this will be implemented in child classes
    }
}