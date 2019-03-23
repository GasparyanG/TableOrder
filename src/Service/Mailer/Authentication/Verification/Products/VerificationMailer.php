<?php

namespace App\Service\Mailer\Authentication\Verification\Products;

use App\Service\Mailer\Authentication\Verification\VerificationMailerInterface;
use App\Service\Mailer\Common\Products\MailerSupplier;
use App\Service\ConfigurationFetcher\Specific\SpecificConfigFetcherInterface;
use App\Service\Mailer\DataPreparing\DataPreparingInterface;
use App\Templating\Configuration\ConfiguredTemplateEngine;

class VerificationMailer extends MailerSupplier implements VerificationMailerInterface
{
    private $engine;
    private $dataPreparingEngine;

    public function __construct(SpecificConfigFetcherInterface $specificConfigFetcher, ConfiguredTemplateEngine $engine, DataPreparingInterface $dataPreparingEngine)
    {
        parent::__construct($specificConfigFetcher);

        $this->engine = $engine;
        $this->dataPreparingEngine = $dataPreparingEngine;
    }

    public function sendVerificationCode(string $email): void
    {
        $dataForTemplate = $this->dataPreparingEngine->getVerificationData($email);

        // config mailer
        $mailer = $this->getConfiguredMailer();

        // create a message
        $message = (new \Swift_Message("Verification Code"))
            ->setFrom($this->specificConfigFetcher->getUsername())
            ->setTo($email)
            ->setBody(
                $this->engine->getConfiguredTemplating()->render("mailing_views_php/verification.html.php", $dataForTemplate),
                "text/html"
            );

        // send a message
        $mailer->send($message);
    }
}