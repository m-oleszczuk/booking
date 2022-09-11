<?php

namespace Reservation\Application\Controller\Query;

use App\Reservation\Application\Controller\Query\ReservationsQuery;
use App\Shared\Application\ValueObject\Pagination;
use PHPUnit\Framework\TestCase;

class ReservationsQueryTest extends TestCase
{
    public function testCreatingQuery(): void
    {
        $command = new ReservationsQuery(new Pagination(1));

        $this->assertInstanceOf(ReservationsQuery::class, $command);
    }
}
