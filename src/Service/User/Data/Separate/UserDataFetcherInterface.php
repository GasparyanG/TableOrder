<?php

namespace App\Service\User\Data\Separate;

use App\Entity\User;

interface UserDataFetcherInterface
{
    public function getUser(): ?User;
}