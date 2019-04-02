<?php

namespace App\Service\Reservation\Validation\QueryParams;

interface ReservationQueryParamValidatorInterface
{
    public function isValid(): bool;
}