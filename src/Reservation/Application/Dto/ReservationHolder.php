<?php

declare(strict_types=1);

namespace App\Reservation\Application\Dto;

class ReservationHolder
{
    public function __construct(
        public ?string $firstName,
        public ?string $lastName,
        public ?string $phoneNumber,
        public ?string $email
    ) {}
}