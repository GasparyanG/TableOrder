<?php

namespace App\Service\Review\ReviewSupplier\ComposedReview;

use App\Entity\User;

interface ComposedReviewInterface
{
    public function getComposedReview(User $user, bool $dashboard = true): array;
}