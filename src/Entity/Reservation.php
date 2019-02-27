<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\RestaurantTable", inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $table;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Restaurant", inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $restauran;

    /**
     * @ORM\Column(type="date")
     */
    private $reservationDate;

    /**
     * @ORM\Column(type="time")
     */
    private $reservationTime;

    /**
     * @ORM\Column(type="integer")
     */
    private $amountOfTime;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $tableNumber;

    public function __construct()
    {
        $this->bookmarks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTable(): ?RestaurantTable
    {
        return $this->table;
    }

    public function setTable(?RestaurantTable $table): self
    {
        $this->table = $table;

        return $this;
    }

    public function getRestauran(): ?Restaurant
    {
        return $this->restauran;
    }

    public function setRestauran(?Restaurant $restauran): self
    {
        $this->restauran = $restauran;

        return $this;
    }

    public function getReservationDate(): ?\DateTimeInterface
    {
        return $this->reservationDate;
    }

    public function setReservationDate(\DateTimeInterface $reservationDate): self
    {
        $this->reservationDate = $reservationDate;

        return $this;
    }

    public function getReservationTime(): ?\DateTimeInterface
    {
        return $this->reservationTime;
    }

    public function setReservationTime(\DateTimeInterface $reservationTime): self
    {
        $this->reservationTime = $reservationTime;

        return $this;
    }

    public function getAmountOfTime(): ?int
    {
        return $this->amountOfTime;
    }

    public function setAmountOfTime(int $amountOfTime): self
    {
        $this->amountOfTime = $amountOfTime;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTableNumber(): ?int
    {
        return $this->tableNumber;
    }

    public function setTableNumber(int $tableNumber): self
    {
        $this->tableNumber = $tableNumber;

        return $this;
    }
}
