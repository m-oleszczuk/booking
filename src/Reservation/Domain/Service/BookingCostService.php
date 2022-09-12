<?php

declare(strict_types=1);

namespace App\Reservation\Domain\Service;

use DateInterval;
use DatePeriod;
use DateTimeImmutable;
use App\Reservation\Domain\Model\Read\PricingInterface;

/**
 * Very simple class used for setting the cost and maintaining the logic. Could be extracted and improved
 * to differentiate between currencies and countries and having different premium factors for each.
 * The plan would be to keep such data in a separate table, maintained by the 'business'.
 */
class BookingCostService
{
    private float $factor = 1.0;
    private int $cost = 5000;

    public function __construct(private PricingInterface $pricingRepository) {}

    public function bookingCost(bool $isRoomPremium, DateTimeImmutable $startDate, DateTimeImmutable $endDate): int {
        return $this->calculateCost($isRoomPremium, $startDate, $endDate);
    }

    private function calculateCost(bool $isRoomPremium, DateTimeImmutable $startDate, DateTimeImmutable $endDate): int {
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($startDate, $interval, $endDate);
        $totalCost = 0;

        foreach ($period as $date) {
            $pricingSettings = $this->pricingRepository->getPricingSettingsForDate($date);
            $totalCost += (int)($pricingSettings->cost * ($isRoomPremium ? $pricingSettings->factor : 1));
        }
        return $totalCost;
    }
}