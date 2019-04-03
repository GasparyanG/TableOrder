<?php

namespace App\Service\Mailer\Common\Products;

use App\Service\ConfigurationFetcher\Specific\SpecificConfigFetcherInterface;
use App\Service\Mailer\Common\MailerSupplierInterface;
use App\Entity\User;
use App\Service\User\UserSupporterInterface;

class MailerSupplier implements MailerSupplierInterface
{
    protected $specificConfigFetcher;
    protected $userSupporter;

    public function __construct(SpecificConfigFetcherInterface $specificConfigFetcher, UserSupporterInterface $userSupporter)
    {
        $this->specificConfigFetcher = $specificConfigFetcher;
        $this->userSupporter = $userSupporter;
    }

    public function getConfiguredMailer(): \Swift_Mailer
    {
        $transport = (new \Swift_SmtpTransport("smtp.gmail.com", 465, "ssl"))
            ->setUsername($this->specificConfigFetcher->getUsername())
            ->setPassword($this->specificConfigFetcher->getPassword());

        $mailer = new \Swift_Mailer($transport);

        return $mailer;
    }

    public function getUser(): User
    {
        return $this->userSupporter->getUser();
    }
}