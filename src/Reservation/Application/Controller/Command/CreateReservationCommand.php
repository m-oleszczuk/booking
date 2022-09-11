<?php

declare(strict_types=1);

namespace App\Reservation\Application\Controller\Command;

use App\Reservation\Application\Dto\Reservation;
use App\Shared\Application\Exception\InvalidParameterException;

class CreateReservationCommand
{
    private Reservation $reservation;

    public function __construct(
        Reservation $reservation
    ) {
        $this->setReservation($reservation);
    }

    private function setReservation(Reservation $reservation): void {
        //TODO: Validate phone number string
        if (!filter_var($reservation->holder->email, FILTER_VALIDATE_EMAIL)) {
            throw InvalidParameterException::parameterTypeNotValid('holder email', 'email');
        }

        $this->reservation = $reservation;
    }

    public function reservation(): Reservation {
        return $this->reservation;
    }
}