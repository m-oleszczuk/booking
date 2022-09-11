<?php

declare(strict_types=1);

namespace App\Reservation\Application\Controller\Command;

use App\Shared\Application\Exception\InvalidParameterException;

class DeleteReservationCommand
{
    private int $reservationId;

    public function __construct(int $reservationId) {
        $this->setReservationId($reservationId);
    }

    private function setReservationId(int $reservationId): void {
        if ($reservationId <= 0) {
            throw InvalidParameterException::parameterMustBeGreaterThanZero('id');
        }

        $this->reservationId = $reservationId;
    }

    public function reservationId(): int {
        return $this->reservationId;
    }
}