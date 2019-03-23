<?php

namespace App\Service\Mailer\DataPreparing;

interface DataPreparingInterface
{
    public function getVerificationData(string $email): array;
}