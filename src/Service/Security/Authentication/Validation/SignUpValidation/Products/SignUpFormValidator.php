<?php

namespace App\Service\Security\Authentication\Validation\SignUpValidation\Products;

use App\Service\Security\Authentication\Validation\Components\Form\FormValidatorInterface;
use App\Service\Security\Authentication\Validation\Components\Username\UsernameCheckerInterface;
use App\Service\Security\Authentication\Validation\SignUpValidation\SignUpFormValidationInterface;

class SignUpFormValidator implements SignUpFormValidationInterface
{
    private $formValidator;
    private $usernameChecker;

    public function __construct(FormValidatorInterface $formValidator, UsernameCheckerInterface $usernameChecker)
    {
        $this->formValidator = $formValidator;
        $this->usernameChecker = $usernameChecker;
    }

    /**
     * @param array $arrayOfFormData
     * @return array
     */
    public function validateForm(array $arrayOfFormData): array
    {
        return $this->formValidator->validateForm($arrayOfFormData);
    }

    /**
     * @param array $arrayOfFormData
     * @return string|null
     */
    public function checkUsername(array $arrayOfFormData): ?string
    {
        return $this->usernameChecker->checkUsername($arrayOfFormData);
    }
}