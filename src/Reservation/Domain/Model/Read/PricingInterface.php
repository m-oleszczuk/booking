<?php

declare(strict_types=1);

namespace App\Reservation\Domain\Model\Read;

use App\Reservation\Application\Dto\Pricing;
use DateTimeImmutable;

interface PricingInterface
{
    public function getPricingSettingsForDate(DateTimeImmutable $date): Pricing;
}