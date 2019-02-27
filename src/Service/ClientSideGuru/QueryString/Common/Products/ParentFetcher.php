<?php

namespace App\Service\ClientSideGuru\QueryString\Common\Products;

use Symfony\Component\Yaml\Yaml;

class ParentFetcher
{
    public function __construct()
    {
        $this->queryParamConf = Yaml::parseFile(__DIR__ . "/../../../../../../config/packages/client_side_guru/query_string.yaml");
        $this->queryParamKeysConf = Yaml::parseFile(__DIR__ . "/../../../../../../config/packages/client_side_guru/query_string_keys.yaml");
    }

    public function getPersonAmount(array $queryString): ?int
    {
        $keyForPersonAmount = $this->queryParamConf['search']['personAmount'];

        if (isset($queryString[$keyForPersonAmount])) {
            return $queryString[$keyForPersonAmount];
        }

        return null;
    }

    public function getReservationTime(array $queryString): ?string
    {
        $keyForReservationTime = $this->queryParamConf['search']['reservationTime'];

        if (isset($queryString[$keyForReservationTime])) {
            return $queryString[$keyForReservationTime];
        }

        return null;
    }

    public function getReservationDate(array $queryString): ?string
    {
        $keyForReservationDate = $this->queryParamConf['search']['reservationDate'];

        if (isset($queryString[$keyForReservationDate])) {
            return $queryString[$keyForReservationDate];
        }

        return null;
    }

    public function getAmountOfTime(array $assocArray): ?int
    {
        $keyForAmountOfTime = $this->queryParamKeysConf['reservation']['amountOfTime'];

        if (isset($assocArray[$keyForAmountOfTime])) {
            return $assocArray[$keyForAmountOfTime];
        }

        return null;
    }

    public function getReviewValue(array $assocArray): ?int
    {
        $keyForReviewValue = $this->queryParamKeysConf['postArray']['reviewValue'];

        if (isset($assocArray[$keyForReviewValue])) {
            if (is_int((int)$assocArray[$keyForReviewValue])) {
                return $assocArray[$keyForReviewValue];
            }
        }

        return null;
    }
}