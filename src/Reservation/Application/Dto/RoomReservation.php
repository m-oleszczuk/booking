<?php

declare(strict_types=1);

namespace App\Reservation\Application\Dto;

class RoomReservation
{
    public function __construct(
        public int $roomNumber,
        public string $startDate,
        public string $endDate,
    ) {}
}