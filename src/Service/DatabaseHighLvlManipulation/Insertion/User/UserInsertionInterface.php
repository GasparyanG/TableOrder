<?php

namespace App\Service\DatabaseHighLvlManipulation\Insertion\User;

interface UserInsertionInterface
{
    public function InsertToDatabase(array $userCredentials); // TODO: check what does database insertion returns and add type hint here!
}