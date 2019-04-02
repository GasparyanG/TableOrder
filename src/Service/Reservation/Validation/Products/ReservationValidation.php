<?php

namespace App\Service\Reservation\Validation\Products;

use App\Service\ConfigurationFetcher\Keys\KeysFetcherInterface;
use App\Service\Existence\Entity\ExistenceHandlerInterface;
use App\Service\Existence\Entity\Products\ExistenceHandler;
use App\Service\Reservation\Time\ReservationTimeAndDateGuruInterface;
use App\Service\Reservation\Validation\ReservationValidationInterface;
use App\Service\Reservation\Validation\QueryParams\ReservationQueryParamValidatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Request;

// entity
use App\Entity\Reservation;

// DEV
use Psr\Log\LoggerInterface;

class ReservationValidation implements ReservationValidationInterface
{
    private $request;
    private $reservationQueryParamValidator;
    private $reservationTimeAndDateGuru;
    private $existenceHandler;
    private $keysFetcher;

    // db
    private $em;
    private $reservationRepo;

    // DEV
    private $logger;

    public function __construct(ReservationQueryParamValidatorInterface $reservationQueryParamValidator,
                                ReservationTimeAndDateGuruInterface $reservationTimeAndDateGuru,
                                ExistenceHandlerInterface $existenceHandler,
                                KeysFetcherInterface $keysFetcher,
                                RegistryInterface $registry,
                                LoggerInterface $logger)
    {
        $this->request = Request::createFromGlobals();
        $this->reservationQueryParamValidator = $reservationQueryParamValidator;
        $this->reservationTimeAndDateGuru = $reservationTimeAndDateGuru;
        $this->existenceHandler = $existenceHandler;
        $this->keysFetcher = $keysFetcher;

        // db
        $this->em = $registry->getEntityManager();
        $this->reservationRepo = $this->em->getRepository(Reservation::class);

        // DEV
        $this->logger = $logger;
    }

    public function getRequestIsValid(string $restaurantName, int $restaurantId): bool
    {
        // query params validation
        if (!$this->reservationQueryParamValidator->isValid()) {
            return  false;
        }

        // time validation
        if ($this->reservationTimeAndDateGuru->timeMachine()) {
            // we don't have time machine yet
            return false;
        }

        // restaurant validation
        // restaurant exists
        if (!$this->existenceHandler->restaurantExists($restaurantName, $restaurantId)) {
            return false;
        }

        // table id belongs to given restaurant
        // getting table id form query string
        $queryParams = $this->request->query->all();
        $tableId = $queryParams[$this->keysFetcher->getTableId()];

        if (!$this->existenceHandler->tableExists($tableId, $restaurantId)) {
            return false;
        }

        // table is free
        if (!$this->tableIsFree()) {
            return false;
        }

        // request is checked
        return true;
    }

    private function tableIsFree(): bool
    {
        $queryParams = $this->request->query->all();

        $tableId = $queryParams[$this->keysFetcher->getTableId()];
        $reservationTime = $queryParams[$this->keysFetcher->getReservationTime()];
        $reservationDate = $queryParams[$this->keysFetcher->getReservationDate()];

        // reservation repository requires this format for searching
        $arrayOfTableIds = [$tableId];

        $reservedTables = $this->reservationRepo->findReservedTables($arrayOfTableIds, $reservationDate, $reservationTime);

        if (count($reservedTables) != 0) {
            return false;
        }

        return true;
    }
}