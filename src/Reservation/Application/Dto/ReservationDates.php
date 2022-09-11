<?php

declare(strict_types=1);

namespace App\Reservation\Application\Dto;

use DateTimeImmutable;
use Exception;

class ReservationDates
{
    private DateTimeImmutable $startDate;
    private DateTimeImmutable $endDate;

    /** @throws Exception */
    public function __construct(string $startDate, string $endDate) {
        $this->setStartDate($startDate);
        $this->setEndDate($endDate);
    }

    public function startDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    public function endDate(): DateTimeImmutable
    {
        return $this->endDate;
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