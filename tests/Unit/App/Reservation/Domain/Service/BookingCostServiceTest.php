<?php

declare(strict_types=1);

namespace Unit\App\Reservation\Domain\Service;

use App\Reservation\Application\Dto\Pricing;
use App\Reservation\Domain\Model\Read\PricingInterface;
use App\Reservation\Domain\Service\BookingCostService;
use App\Reservation\Infrastructure\Model\Read\InMemoryPricingRepository;
use Mockery;
use PHPUnit\Framework\TestCase;

class BookingCostServiceTest extends TestCase
{
    /** @dataProvider provideForTest */
    public function testGenerationBookingCosts(
        int $cost, \DateTimeImmutable $startDate, \DateTimeImmutable $endDate, bool $isPremium
    ): void {
        $pricingRepository = new InMemoryPricingRepository();
        $bookingCostService = new BookingCostService($pricingRepository);

        $result = $bookingCostService->bookingCost($isPremium, $startDate, $endDate);

        $this->assertEquals($cost, $result);
    }

    public function provideForTest(): array {
        return [
            [
                5000,
                (new \DateTimeImmutable('2020-10-10 00:00:00')),
                (new \DateTimeImmutable('2020-10-11 00:00:00')),
                false,
            ],
            [
                10000,
                (new \DateTimeImmutable('2020-10-10 00:00:00')),
                (new \DateTimeImmutable('2020-10-12 00:00:00')),
                false,
            ],
            [
                47000,
                (new \DateTimeImmutable('2020-10-10 00:00:00')),
                (new \DateTimeImmutable('2020-10-16 00:00:00')),
                true,
            ],
        ];
    }
}