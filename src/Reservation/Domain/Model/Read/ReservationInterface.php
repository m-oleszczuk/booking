<?php

declare(strict_types=1);

namespace App\Reservation\Domain\Model\Read;

use App\Reservation\Application\Dto\Reservation;
use App\Shared\Application\ValueObject\Pagination;

interface ReservationInterface
{
    /** @return Reservation[] */
    public function getAllReservations(Pagination $pagination): array;
    public function getReservation(int $id): Reservation;
}