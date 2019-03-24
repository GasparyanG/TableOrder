<?php

namespace App\Service\Security\Authentication\Validation\Verification\Products;

use App\Service\ClientSideGuru\Post\Authentication\SignUp\SignUpFormFetcherInterface;
use App\Service\ClientSideGuru\Post\Authentication\Verification\VerificationFetcherInterface;
use App\Service\Security\Authentication\Validation\Objects\Verification\LessPropertyVerification;
use App\Service\Security\Authentication\Validation\Supplier\ValidationSupplierInterface;
use App\Service\Security\Authentication\Validation\Verification\VerificationValidationInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class VerificationValidator implements VerificationValidationInterface
{
    private $validationSupplier;
    private $request;
    private $signUpFormFetcher;
    private $verificationFetcher;
    private $validator;

    public function __construct(ValidationSupplierInterface $validationSupplier,
                                SignUpFormFetcherInterface $signUpFormFetcher,
                                VerificationFetcherInterface $verificationFetcher,
                                ValidatorInterface $validator)
    {
        $this->validationSupplier = $validationSupplier;
        $this->request = Request::createFromGlobals();
        $this->signUpFormFetcher = $signUpFormFetcher;
        $this->verificationFetcher = $verificationFetcher;
        $this->validator = $validator;
    }

    public function validateVerification(): array
    {
        // OBJECT TO BE VALIDATED!
        $verification = new LessPropertyVerification();

        // username
        $username = $this->getUsername();

        if ($username) {
            $verification->setUsername($username);
        }

        // verification code
        $verificationCode = $this->getVerificationCode();

        if ($verificationCode) {
            $verification->setVerificationCode($verificationCode);
        }

        // validate
        $errorObjectsArray = $this->validator->validate($verification);

        // convert to string[]
        $errorsArray = $this->validationSupplier->convertErrorsToArray($errorObjectsArray);

        return $errorsArray;
    }

    private function getUsername(): ?string
    {
        $getParams = $this->request->query->all();
        $username = $this->signUpFormFetcher->getUsername($getParams);

        return $username;
    }

    private function getVerificationCode()
    {
        $postParams = $this->request->request->all();
        $verificationCode = $this->verificationFetcher->getVerificationCode($postParams);

        return $verificationCode;
    }
}