<?php

namespace Reservation\Application\Controller\Query;

use App\Reservation\Application\Controller\Query\ReservationHoldersQuery;
use App\Shared\Application\ValueObject\Pagination;
use PHPUnit\Framework\TestCase;

class ReservationHoldersQueryTest extends TestCase
{
    public function testCreatingQuery(): void
    {
        $command = new ReservationHoldersQuery(new Pagination(1));

        $this->assertInstanceOf(ReservationHoldersQuery::class, $command);
    }
}
