<?php

namespace App\Service\DatabaseHighLvlManipulation\Insertion\User;

interface UserInsertionInterface
{
    public function InsertToDatabase(array $userCredentials): void;
}