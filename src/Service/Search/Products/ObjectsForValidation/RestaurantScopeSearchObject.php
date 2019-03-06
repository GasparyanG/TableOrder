<?php

namespace App\Service\Search\Products\ObjectsForValidation;

class RestaurantScopeSearchObject
{
    private $personAmount;
    private $restaurantName;
    private $restaurantId;
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

    public function getRestaurantName(): string
    {
        return $this->restaurantName;
    }

    public function setRestaurantName(string $restaurantName): self
    {
        $this->restaurantName = $restaurantName;

        return $this;
    }

    public function getRestaurantId(): string
    {
        return $this->restaurantId;
    }

    public function setRestaurantId(string $restaurantId): self
    {
        $this->restaurantId = $restaurantId;

        return $this;
    }
}