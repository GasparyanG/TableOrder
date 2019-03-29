<?php

namespace App\Service\Review\ReviewSupplier\User;

use App\Entity\User;

interface UserRatingsSupplierInterface
{
    public function getUserRatings(User $user, bool $dashboard = true): array;

    public function getUserRatingAmount(User $user): int;
}