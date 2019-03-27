<?php

namespace App\Service\User;

use App\Entity\User;

interface UserSupporterInterface
{
    public function getUser(): ?User;

    public function isAuthenticated(): bool;

    public function getUserData(): array;
}