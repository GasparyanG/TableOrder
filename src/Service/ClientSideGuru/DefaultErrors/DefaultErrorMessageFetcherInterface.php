<?php

namespace App\Service\ClientSideGuru\DefaultErrors;

interface DefaultErrorMessageFetcherInterface
{
    public function getNoBehaviorFealdError(): string;

    public function getPastReservationErrorMsg(): string;

    public function getTimeAndDateUnproperErrorMsg(): string;

    public function getEmailAlreadyInUse(): string;

    public function getEmailFormatIsWrong(): string;
}