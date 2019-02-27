<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RestaurantRepository")
 */
class Restaurant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $owner;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cover_photo;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount_of_tables;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $layout_photo;

    /**
     * @ORM\Column(type="integer")
     */
    private $registration_date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $working_status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slogan;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $phone_number;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="restaurant")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RestaurantTable", mappedBy="restaurant", orphanRemoval=true)
     */
    private $restaurantTables;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="restauran", orphanRemoval=true)
     */
    private $reservations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="restaurant", orphanRemoval=true)
     */
    private $reviews;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Bookmark", mappedBy="restaurant", orphanRemoval=true)
     */
    private $bookmarks;

    public function __construct()
    {
        $this->restaurantTables = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->bookmarks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getOwner(): ?string
    {
        return $this->owner;
    }

    public function setOwner(?string $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getCoverPhoto(): ?string
    {
        return $this->cover_photo;
    }

    public function setCoverPhoto(string $cover_photo): self
    {
        $this->cover_photo = $cover_photo;

        return $this;
    }

    public function getAmountOfTables(): ?int
    {
        return $this->amount_of_tables;
    }

    public function setAmountOfTables(int $amount_of_tables): self
    {
        $this->amount_of_tables = $amount_of_tables;

        return $this;
    }

    public function getLayoutPhoto(): ?string
    {
        return $this->layout_photo;
    }

    public function setLayoutPhoto(string $layout_photo): self
    {
        $this->layout_photo = $layout_photo;

        return $this;
    }

    public function getRegistrationDate(): ?int
    {
        return $this->registration_date;
    }

    public function setRegistrationDate(int $registration_date): self
    {
        $this->registration_date = $registration_date;

        return $this;
    }

    public function getWorkingStatus(): ?bool
    {
        return $this->working_status;
    }

    public function setWorkingStatus(bool $working_status): self
    {
        $this->working_status = $working_status;

        return $this;
    }

    public function getSlogan(): ?string
    {
        return $this->slogan;
    }

    public function setSlogan(?string $slogan): self
    {
        $this->slogan = $slogan;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?int $phone_number): self
    {
        $this->phone_number = $phone_number;

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

    /**
     * @return Collection|RestaurantTable[]
     */
    public function getRestaurantTables(): Collection
    {
        return $this->restaurantTables;
    }

    public function addRestaurantTable(RestaurantTable $restaurantTable): self
    {
        if (!$this->restaurantTables->contains($restaurantTable)) {
            $this->restaurantTables[] = $restaurantTable;
            $restaurantTable->setRestaurant($this);
        }

        return $this;
    }

    public function removeRestaurantTable(RestaurantTable $restaurantTable): self
    {
        if ($this->restaurantTables->contains($restaurantTable)) {
            $this->restaurantTables->removeElement($restaurantTable);
            // set the owning side to null (unless already changed)
            if ($restaurantTable->getRestaurant() === $this) {
                $restaurantTable->setRestaurant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setRestauranId($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getRestauranId() === $this) {
                $reservation->setRestauranId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Review[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setRestaurant($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->contains($review)) {
            $this->reviews->removeElement($review);
            // set the owning side to null (unless already changed)
            if ($review->getRestaurant() === $this) {
                $review->setRestaurant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Bookmark[]
     */
    public function getBookmarks(): Collection
    {
        return $this->bookmarks;
    }

    public function addBookmark(Bookmark $bookmark): self
    {
        if (!$this->bookmarks->contains($bookmark)) {
            $this->bookmarks[] = $bookmark;
            $bookmark->setRestaurant($this);
        }

        return $this;
    }

    public function removeBookmark(Bookmark $bookmark): self
    {
        if ($this->bookmarks->contains($bookmark)) {
            $this->bookmarks->removeElement($bookmark);
            // set the owning side to null (unless already changed)
            if ($bookmark->getRestaurant() === $this) {
                $bookmark->setRestaurant(null);
            }
        }

        return $this;
    }
}
