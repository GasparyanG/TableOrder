<?php

namespace App\Service\Security\Validation\Objects;

class Reservation
{
    private $personAmount;
    private $tableId;
    private $reservationTime;
    private $reservationDate;

    public function getPersonAmount(): int
    {
        return $this->personAmount;
    }

    public function setPersonAmount(int $personAmount): self
    {
        $this->personAmount = $personAmount;

        return $this;
    }

    public function getTableId(): int
    {
        return $this->tableId;
    }

    public function setTableId(int $tableId): self
    {
        $this->tableId = $tableId;

        return $this;
    }

    public function getReservationTime(): \DateTimeInterface
    {
        return $this->reservationTime;
    }

    public function setReservationTime(\DateTimeInterface $reservationTime): self
    {
        $this->reservationTime = $reservationTime;

        return $this;
    }

    public function getReservationDate(): \DateTimeInterface
    {
        return $this->reservationDate;
    }

    public function setReservationDate(\DateTimeInterface $reservationDate): self
    {
        $this->reservationDate = $reservationDate;

        return $this;
    }
}