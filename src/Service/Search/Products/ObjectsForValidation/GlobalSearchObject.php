<?php

namespace App\Service\Search\Products\ObjectsForValidation;

class GlobalSearchObject
{
    private $personAmount;
    private $location;
    private $reservationDate;
    private $reservationTime;

    public function getPersonAmount(): int
    {
        return $this->personAmount;
    }

    public function setPersonAmount(int $personAmount): self
    {
        $this->personAmount = $personAmount;

        return $this;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $locaiton): self
    {
        $this->location = $locaiton;

        return $this;
    }

    public function getReservationTime()
    {
        $this->reservationTime;
    }

    public function setReservationTime($reservationTime): self
    {
        $this->reservationTime = $reservationTime;

        return $this;
    }

    public function getReservationDate()
    {
        return $this->reservationDate;
    }

    public function setReservationDate($reservationDate): self
    {
        $this->reservationDate = $reservationDate;

        return $this;
    }
}