<?php

declare(strict_types=1);

namespace App\Reservation\Infrastructure\Model\Read;

use App\Reservation\Application\Dto\Pricing;
use App\Reservation\Domain\Model\Read\PricingInterface;
use DateTimeImmutable;
use Exception;

class InMemoryPricingRepository implements PricingInterface
{
    /** @throws Exception */
    public function getPricingSettingsForDate(DateTimeImmutable $date): Pricing
    {
        $formattedDate = $date->format('m-d');
        $dateMap = $this->datePricingMap();
        foreach ($dateMap as $key => $value) {
            if ($formattedDate == $key) {
                return $value;
            }
        }

        return new Pricing();
    }

    private function datePricingMap(): array {
        return [
            '10-12' => new Pricing(7000, 1.0),
            '10-15' => new Pricing(10000, 2.0),
        ];
    }
}