<?php

declare(strict_types=1);

namespace App\Reservation\Application\Controller\Command;

use App\Reservation\Application\Dto\Reservation;
use App\Shared\Application\Exception\InvalidParameterException;

class UpdateReservationCommand
{
    private int $oldReservationId;
    private Reservation $reservation;

    public function __construct(
        int $oldReservationId,
        Reservation $reservation
    ) {
        $this->setOldReservationId($oldReservationId);
        $this->setNewReservation($reservation);
    }

    private function setOldReservationId(int $oldReservationId): void
    {
        if ($oldReservationId < 0) {
            throw InvalidParameterException::parameterMustBeGreaterThanZero('id');
        }

        $this->oldReservationId = $oldReservationId;
    }

    private function setNewReservation(Reservation $reservation): void
    {
        //TODO: Validate phone number string
        if (!filter_var($reservation->holder->email, FILTER_VALIDATE_EMAIL)) {
            throw InvalidParameterException::parameterTypeNotValid('holder email', 'email');
        }

        $this->reservation = $reservation;
    }

    public function oldReservationId(): int {
        return $this->oldReservationId;
    }

    public function newReservation(): Reservation {
        return $this->reservation;
    }
}