<?php

namespace App\Service\Mailer\Common;

interface MailerSupplierInterface
{
    public function getConfiguredMailer(): \Swift_Mailer;
}