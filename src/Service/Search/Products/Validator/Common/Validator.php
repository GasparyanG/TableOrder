<?php

/**
 * []- define error message in yaml
 * []- make properties private
 */
namespace App\Service\Search\Products\Validator\Common;

use App\Service\ClientSideGuru\QueryString\Search\QueryStringFetcherInterface;
use App\Service\ClientSideGuru\Defaults\Search\DefaultsFetcherInterface;
use App\Service\ClientSideGuru\Keys\Search\KeysFetcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Psr\Log\LoggerInterface;

class Validator
{
    public function __construct(QueryStringFetcherInterface $fetcher, DefaultsFetcherInterface $defaultsFetcher, KeysFetcherInterface $keysFetcher, ValidatorInterface $validator, LoggerInterface $logger)
    {
        $this->validator = $validator;
        $this->fetcher = $fetcher;
        $this->keysFetcher = $keysFetcher;
        $this->defaultsFetcher = $defaultsFetcher;
        $this->logger = $logger;
    }

    // this is defined by Validaotr interface
    // error message will be defined in yaml config file
    public function checkTimeAndDate(array $queryParams): bool
    {
        $reservationTime = $this->fetcher->getReservationTime($queryParams);
        $reservationDate = $this->fetcher->getReservationDate($queryParams);

        // current time MUST be less than reservation time
        if (time() > strtotime($reservationDate . " " . date("H:i:s", strtotime($reservationTime)))) {
            return false;
        }

        else {
            return true;
        }
    }

    protected function sanitizeLocation(array $queryParams): array
    {
        if ($this->fetcher->getLocation($queryParams)) {
            return $queryParams;
        }

        // get default from yaml config
        $queryParams[$this->keysFetcher->getLocation()] = $this->defaultsFetcher->getLocation();

        return $queryParams;
    }

    protected function sanitizePersonAmount(array $queryParams): array
    {
        if ($this->fetcher->getPersonAmount($queryParams)) {
            return $queryParams;
        }

        $queryParams[$this->keysFetcher->getPersonAmount()] = $this->defaultsFetcher->getPersonAmount();

        return $queryParams;
    }
}