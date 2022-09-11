<?php

namespace Reservation\Application\Controller\Query;

use App\Reservation\Application\Controller\Query\ReservationQuery;
use App\Shared\Application\Exception\InvalidParameterException;
use PHPUnit\Framework\TestCase;

class ReservationQueryTest extends TestCase
{
    public function testCreatingQuery(): void
    {
        $command = new ReservationQuery(1);

        $this->assertInstanceOf(ReservationQuery::class, $command);
    }

    public function testCreatingQueryInvalidIdException(): void
    {
        $this->expectException(InvalidParameterException::class);
        new ReservationQuery(0);
    }
}
