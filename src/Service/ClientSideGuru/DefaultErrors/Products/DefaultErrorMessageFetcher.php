<?php

namespace App\Service\ClientSideGuru\DefaultErrors\Products;

use App\Service\ClientSideGuru\DefaultErrors\DefaultErrorMessageFetcherInterface;
use Symfony\Component\Yaml\Yaml;

class DefaultErrorMessageFetcher implements DefaultErrorMessageFetcherInterface
{
    // this can be defined in parent class which will be ment for DYR principle
    public function __construct()
    {
        $this->defaultErrorMessageConf = Yaml::parseFile(__DIR__ . "/../../../../../config/packages/client_side_guru/default_errors.yaml");
    }

    public function getNoBehaviorFealdError(): string
    {
        return $this->defaultErrorMessageConf['search']['behavior'];
    }

    public function getPastReservationErrorMsg(): string
    {
        return $this->defaultErrorMessageConf['search']['reservingPast'];
    }

    public function getTimeAndDateUnproperErrorMsg(): string
    {
        return $this->defaultErrorMessageConf['search']['timeAndDate'];
    }

    public function getTableIdIsNotDefined(): string
    {
        return $this->defaultErrorMessageConf['reservation']['tableId'];
    }

    // EMAIL SECTION
    public function getEmailAlreadyInUse(): string
    {
        return $this->defaultErrorMessageConf["email"]["already_in_use"];
    }

    public function getEmailFormatIsWrong(): string
    {
        return $this->defaultErrorMessageConf["email"]["wrong_format"];
    }
}