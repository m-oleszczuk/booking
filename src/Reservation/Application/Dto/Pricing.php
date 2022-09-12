<?php

declare(strict_types=1);

namespace App\Reservation\Application\Dto;

class Pricing
{
    public function __construct(public int $cost = 5000, public float $factor = 1.0) {}
}