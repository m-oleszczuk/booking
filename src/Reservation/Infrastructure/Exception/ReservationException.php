<?php

declare(strict_types=1);

namespace App\Reservation\Infrastructure\Exception;

use DateTimeImmutable;
use Exception;

class ReservationException extends Exception
{
    public static function roomReserved(
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate,
        int $roomNumber
    ): ReservationException
    {
        return new self(
            sprintf(
            "Room number %s is already reserved between dates %s and %s.",
                $roomNumber,
                $startDate->format('Y-m-d H:i:s'),
                $endDate->format('Y-m-d H:i:s')
            ),
        );
    }
}