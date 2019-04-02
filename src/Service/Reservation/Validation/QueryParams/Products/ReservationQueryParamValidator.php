<?php

namespace App\Service\Reservation\Validation\QueryParams\Products;

use App\Service\ConfigurationFetcher\Keys\KeysFetcherInterface;
use App\Service\Reservation\Validation\QueryParams\ReservationQueryParamValidatorInterface;
use App\Service\Security\Authentication\Validation\Supplier\ValidationSupplierInterface;
use App\Service\Security\Validation\Objects\Reservation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

// DEV
use Psr\Log\LoggerInterface;

class ReservationQueryParamValidator implements ReservationQueryParamValidatorInterface
{
    private $request;
    private $keysFetcher;
    private $validator;
    private $validationSupplier;

    public function __construct(KeysFetcherInterface $keysFetcher,
                                ValidatorInterface $validator,
                                ValidationSupplierInterface $validationSupplier,
                                LoggerInterface $logger)
    {
        $this->request = Request::createFromGlobals();
        $this->keysFetcher = $keysFetcher;
        $this->validator = $validator;
        $this->validationSupplier = $validationSupplier;

        // DEV
        $this->logger = $logger;
    }

    public function isValid(): bool
    {
        if ($this->getErrors() === null) {
            return false;
        }

        elseif (count($this->getErrors()) === 0) {
            return true;
        }

        return false;
    }

    public function getErrors(): ?array
    {
        $queryParams = $this->request->query->all();
        $reservationObject = new Reservation();

        // person amount
        if (!isset($queryParams[$this->keysFetcher->getPersonAmount()])){
            return null;
        }
        $personAmount = $queryParams[$this->keysFetcher->getPersonAmount()];
        $reservationObject->setPersonAmount($personAmount);

        // reservation date
        if (!isset($queryParams[$this->keysFetcher->getReservationDate()])) {
            return null;
        }
        $reservationDate = $queryParams[$this->keysFetcher->getReservationDate()];
        $date = new \DateTime($reservationDate);
        $reservationObject->setReservationDate($date);

        // reservation time
        if (!isset($queryParams[$this->keysFetcher->getReservationTime()])) {
            return null;
        }
        $reservationTime = $queryParams[$this->keysFetcher->getReservationTime()];
        $time = new \DateTime($reservationTime);
        $reservationObject->setReservationTime($time);

        // table id
        if (!isset($queryParams[$this->keysFetcher->getTableId()])) {
            return null;
        }
        $tableId = $queryParams[$this->keysFetcher->getTableId()];
        $reservationObject->setTableId($tableId);

        // validation
        $errors = $this->validator->validate($reservationObject);

        if (count($errors) == 0) {
            return [];
        }

        return $this->validationSupplier->convertErrorsToArray($errors);
    }
}