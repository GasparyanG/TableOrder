<?php

/**
 * - to display errors first its needed to 
 *  []- add constraints to config/validator/validation.yaml
 * - if there is no error
 *  []- check amount of time
 * - else
 *  []- display errors
 * - if amount of time is right
 *  []- make record
 * - else
 *  []- show error about amount of time
 */

namespace App\Service\Reservation\PostBridge\Products;

use App\Service\Reservation\PostBridge;
use App\Entity\Reservation;
use App\Service\Reservation\Preparing\ReservationPreparingInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Service\Reservation\PostBridge\PostReservationBridgeInterface;
use App\Service\Reservation\AmountOfTimeChecker\AmountOfTimeCheckerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
// use App\Entity\Reservation;

class PostReservationBridge implements PostReservationBridgeInterface
{
    public function __construct(ReservationPreparingInterface $reservationPreparing, ValidatorInterface $validator, AmountOfTimeCheckerInterface $amountOfTimeChecker, RegistryInterface $doctrine)
    {
        $this->reservationPreparing = $reservationPreparing;
        $this->validator = $validator;
        $this->amountOfTimeChecker = $amountOfTimeChecker;
        // db config
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getManager();
    }

    public function checkReservation(Reservation $reservation): ?array
    {
        $errors = $this->validator->validate($reservation);
        // this will force to return array, which means that null will never be returned
        if (count($errors) === 0) {
            return [];
        }

        else {
            $errors;
        }
    }

    public function prepareReservation(): ?Reservation
    {
        return $this->reservationPreparing->prepareReservation();
    }

    public function checkAmountOfTime(Reservation $reservation): bool
    {
        return $this->amountOfTimeChecker->checkAmountOfTime($reservation);
    }

    public function getValidAmountOfTime(Reservation $reservation): int
    {
        return $this->amountOfTimeChecker->getValidAmountOfTime($reservation);
    }
    
    public function saveReservation(Reservation $reservation): void
    {
        $this->em->persist($reservation);
        $this->em->flush();
    }
}