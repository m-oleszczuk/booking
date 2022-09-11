<?php

declare(strict_types=1);

namespace App\Reservation\Application\Dto;

class Room
{
    public function __construct(public int $number, public ?bool $isPremium = null) {}
}