<?php

namespace App\Service\Security\Authentication\Validation\Components\Form\Products;

use App\Service\ClientSideGuru\Post\Authentication\SignUp\SignUpFormFetcherInterface;
use App\Service\Security\Authentication\Validation\Components\Form\FormValidatorInterface;
use App\Service\Security\Authentication\Validation\Objects\User\SignUpUser;
use App\Service\Security\Authentication\Validation\Supplier\ValidationSupplierInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FormValidator implements FormValidatorInterface
{
    private $user;
    private $signUpFormFetcher;
    private $validator;
    private $validationSupplier;

    public function __construct(SignUpFormFetcherInterface $signUpFormFetcher, ValidatorInterface $validator, ValidationSupplierInterface $validationSupplier, LoggerInterface $logger)
    {
        $this->user = new SignUpUser();
        $this->signUpFormFetcher = $signUpFormFetcher;
        $this->validator = $validator;
        $this->validationSupplier = $validationSupplier;

        // dev
        $this->logger = $logger;
    }

    public function validateForm(array $arrayOfFormData): array
    {
        $username = $this->signUpFormFetcher->getUsername($arrayOfFormData);
        $this->user->setUsername($username);

        $password = $this->signUpFormFetcher->getPassword($arrayOfFormData);
        $this->user->setPassword($password);

        $firstName = $this->signUpFormFetcher->getFirstName($arrayOfFormData);
        $this->user->setFirstName($firstName);

        $lastName = $this->signUpFormFetcher->getLastName($arrayOfFormData);
        $this->user->setLastName($lastName);

        $errors = $this->validator->validate($this->user);


        if (count($errors) === 0) {
            return [];
        }

        return $this->validationSupplier->convertErrorsToArray($errors);
    }
}
