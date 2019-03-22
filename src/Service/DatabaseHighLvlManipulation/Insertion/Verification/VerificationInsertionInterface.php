<?php

namespace App\Service\DatabaseHighLvlManipulation\Insertion\Verification;

interface VerificationInsertionInterface
{
    public function insertToDatabase(array $userCredentials); // TODO: add type hint!
}