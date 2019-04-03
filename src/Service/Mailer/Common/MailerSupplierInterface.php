<?php

namespace App\Service\Mailer\Common;

use App\Entity\User;

interface MailerSupplierInterface
{
    public function getConfiguredMailer(): \Swift_Mailer;

    public function getUser(): User;
}