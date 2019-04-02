<?php

namespace App\Service\Reservation\Time\Products;

use App\Service\Augmention\TimeAndDate\TimeAndDateSupplierInterface;
use App\Service\ConfigurationFetcher\Keys\KeysFetcherInterface;
use App\Service\Reservation\Time\ReservationTimeAndDateGuruInterface;
use Symfony\Component\HttpFoundation\Request;

// DEV
use Psr\Log\LoggerInterface;

class ReservationTimeAndDateGuru implements ReservationTimeAndDateGuruInterface
{
    private $request;
    private $keysFetcher;
    private $timeAndDateSupplier;

    // DEV
    private $logger;

    public function __construct(KeysFetcherInterface $keysFetcher,
                                TimeAndDateSupplierInterface $timeAndDateSupplier, LoggerInterface $logger)
    {
        $this->request = Request::createFromGlobals();
        $this->keysFetcher = $keysFetcher;
        $this->timeAndDateSupplier = $timeAndDateSupplier;

        // DEV
        $this->logger = $logger;
    }

    public function timeMachine(): bool
    {
        $queryParams = $this->request->query->all();
        $reservationTime = $queryParams[$this->keysFetcher->getReservationTime()];
        $reservationDate = $queryParams[$this->keysFetcher->getReservationDate()];

        $timeAndDateCombined = $reservationDate . " " . $reservationTime;

        // not from future but from past
        if (!$this->timeAndDateSupplier->fromFuture($timeAndDateCombined)) {
            // we don't have any time machine yet
            return true;
        }

        return false;
    }
}
