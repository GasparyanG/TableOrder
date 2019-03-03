<?php

namespace App\Service\Reservation\Bridge\Products;

use App\Service\Reservation\Bridge\ReservationBridgeInterface;
use App\Service\Existence\Entity\ExistenceHandlerInterface;
use App\Service\ClientSideGuru\QueryString\Reservation\QueryParamFetcherInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Service\Reservation\Preparing\Products\ReservationPreparing;
use App\Entity\Reservation;

class ReservationBridge implements ReservationBridgeInterface
{
    public function __construct(ExistenceHandlerInterface $existenceHandler, QueryParamFetcherInterface $fetcher, SessionInterface $session, ReservationPreparing $reservationPreparing)
    {
        $this->existenceHandler = $existenceHandler;
        $this->fetcher = $fetcher;
        $this->session = $session;
        $this->reservationPreparing = $reservationPreparing;
    }

    public function restaurantExists(string $restaurantName, int $restaurantId): bool
    {
        return $this->existenceHandler->restaurantExists($restaurantName, $restaurantId);
    }

    public function getRestaurantTableId(array $queryParam): ?int
    {
        return $this->fetcher->getTableId($queryParam);
    }

    public function tableExists(int $tableId, int $restaurantId): bool
    {
        return $this->existenceHandler->tableExists($tableId, $restaurantId);
    }

    public function replace(array $queryParams): void
    {
        $this->session->replace($queryParams);
    }

    public function prepareReservationWithoutAmountOfTime(): ?Reservation
    {
        return $this->reservationPreparing->prepareReservationWithoutAmountOfTime();
    }
}