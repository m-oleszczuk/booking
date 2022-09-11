<?php

declare(strict_types=1);

namespace App\Reservation\Domain\Service;

use DateTimeImmutable;

/**
 * Very simple class used for setting the cost and maintaining the logic. Could be extracted and improved
 * to differentiate between currencies and countries and having different premium factors for each.
 * The plan would be to keep such data in a separate table, maintained by the 'business'.
 */
class BookingCostService
{
    private const PREMIUM_FACTOR = 1.1;
    private const BASE_COST = 5000; // cost in cents

    public function bookingCost(bool $isRoomPremium, DateTimeImmutable $startDate, DateTimeImmutable $endDate): int {
        $numberOfDays = $this->numberOfDays($startDate, $endDate);

        return (int)($numberOfDays * ($isRoomPremium ? $this->premiumCostPercentage() : self::BASE_COST));
    }

    private function premiumCostPercentage(): float {
        return self::BASE_COST * self::PREMIUM_FACTOR;
    }

    private function numberOfDays(DateTimeImmutable $startDate, DateTimeImmutable $endDate): int {
        return $startDate->diff($endDate)->d;
    }
}