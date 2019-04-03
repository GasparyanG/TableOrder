<?php

namespace App\Service\Mailer\Reservation;

use App\Entity\Reservation;
use App\Service\ConfigurationFetcher\Specific\SpecificConfigFetcherInterface;
use App\Service\Mailer\Common\Products\MailerSupplier;
use App\Service\User\UserSupporterInterface;
use App\Templating\Configuration\ConfiguredTemplateEngine;

class ReservationMailer extends MailerSupplier implements ReservationMailerInterface
{
    private $engine;

    public function __construct(SpecificConfigFetcherInterface $specificConfigFetcher, ConfiguredTemplateEngine $engine, UserSupporterInterface $userSupporter)
    {
        parent::__construct($specificConfigFetcher, $userSupporter);

        $this->engine = $engine;
    }

    public function sendReservationDetailsToUser(Reservation $reservation): void
    {
        $user = $this->getUser();

        $mailer = $this->getConfiguredMailer();
        $userEmail = $user->getUsername();

        $message = (new \Swift_Message("Reservation Details"))
            ->setFrom($this->specificConfigFetcher->getUsername())
            ->setTo($userEmail)
            ->setBody(
                $this->engine->getConfiguredTemplating()->render("mailing_views_php/reservation/reservation_details.html.php", [
                    "reservation" => $reservation,
                    "user" => $user
                ]),
                "text/html"
            );

        // send message
        $mailer->send($message);
    }
}