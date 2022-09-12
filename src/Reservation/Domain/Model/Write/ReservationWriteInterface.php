<?php

declare(strict_types=1);

namespace App\Reservation\Domain\Model\Write;

use App\Reservation\Application\Dto\Reservation;

interface ReservationWriteInterface
{
    public function create(Reservation $reservation): void;
    public function update(int $oldReservationId, Reservation $newReservation): void;
    public function delete(int $reservationId): void;
}