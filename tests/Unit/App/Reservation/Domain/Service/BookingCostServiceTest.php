<?php

declare(strict_types=1);

namespace Unit\App\Reservation\Domain\Service;

use App\Reservation\Domain\Service\BookingCostService;
use PHPUnit\Framework\TestCase;

class BookingCostServiceTest extends TestCase
{
    /** @dataProvider provideForTest */
    public function testGenerationBookingCosts(
        int $cost, \DateTimeImmutable $startDate, \DateTimeImmutable $endDate, bool $isPremium
    ): void {
        $bookingCostService = new BookingCostService();

        $result = $bookingCostService->bookingCost($isPremium, $startDate, $endDate);

        $this->assertEquals($cost, $result);
    }

    public function provideForTest(): array {
        return [
//            [
//                5000,
//                (new \DateTimeImmutable('2020-10-10 00:00:00')),
//                (new \DateTimeImmutable('2020-10-11 00:00:00')),
//                false,
//            ],
//            [
//                10000,
//                (new \DateTimeImmutable('2020-10-10 00:00:00')),
//                (new \DateTimeImmutable('2020-10-12 00:00:00')),
//                false,
//            ],
            [
                33000,
                (new \DateTimeImmutable('2020-10-10 00:00:00')),
                (new \DateTimeImmutable('2020-10-16 00:00:00')),
                true,
            ],
        ];
    }
}