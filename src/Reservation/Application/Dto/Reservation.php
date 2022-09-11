<?php

declare(strict_types=1);

namespace App\Reservation\Application\Dto;

use DateTimeImmutable;
use Exception;

class Reservation
{
    public DateTimeImmutable $startDate;
    public DateTimeImmutable $endDate;

    /** @throws Exception */
    public function __construct(
        public bool $confirmed,
        string $startDate,
        string $endDate,
        public ReservationHolder $holder,
        public Room $room
    ) {
        $this->setStartDate($startDate);
        $this->setEndDate($endDate);
    }

    /** @throws Exception */
    private function setStartDate(string $startDate): void {
        $this->startDate = new DateTimeImmutable($startDate);
    }

    /** @throws Exception */
    private function setEndDate(string $endDate): void {
        $this->endDate = new DateTimeImmutable($endDate);
    }
}