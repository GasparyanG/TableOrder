<?php

namespace App\Service\Mailer\Common\Products;

use App\Service\ConfigurationFetcher\Specific\SpecificConfigFetcherInterface;
use App\Service\Mailer\Common\MailerSupplierInterface;

class MailerSupplier implements MailerSupplierInterface
{
    protected $specificConfigFetcher;

    public function __construct(SpecificConfigFetcherInterface $specificConfigFetcher)
    {
        $this->specificConfigFetcher = $specificConfigFetcher;
    }

    public function getConfiguredMailer(): \Swift_Mailer
    {
        $transport = (new \Swift_SmtpTransport("smtp.gmail.com", 465, "ssl"))
            ->setUsername($this->specificConfigFetcher->getUsername())
            ->setPassword($this->specificConfigFetcher->getPassword());

        $mailer = new \Swift_Mailer($transport);

        return $mailer;
    }
}