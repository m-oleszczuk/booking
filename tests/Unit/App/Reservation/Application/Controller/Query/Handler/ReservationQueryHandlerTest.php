<?php

namespace Reservation\Application\Controller\Query\Handler;

use App\Reservation\Application\Controller\Query\Handler\ReservationQueryHandler;
use App\Reservation\Application\Controller\Query\ReservationQuery;
use App\Reservation\Application\Dto\Reservation;
use App\Reservation\Application\Dto\ReservationHolder;
use App\Reservation\Application\Dto\Room;
use App\Reservation\Domain\Model\Read\ReservationInterface;
use Faker\Factory;
use Mockery;
use PHPUnit\Framework\TestCase;

class ReservationQueryHandlerTest extends TestCase
{
    public function testCreatingQueryHandler(): void
    {
        $model = Mockery::mock(ReservationInterface::class);
        $queryHandler = new ReservationQueryHandler($model);

        $this->assertInstanceOf(ReservationQueryHandler::class, $queryHandler);
    }

    public function testGettingReservationForHolder(): void
    {
        $reservation = $this->reservations();

        $modelMock = Mockery::mock(ReservationInterface::class);
        $modelMock->shouldReceive('getReservation')->andReturn($reservation);

        $query = new ReservationQuery(1);
        $handler = new ReservationQueryHandler($modelMock);

        $this->assertEquals($handler($query), $reservation);
    }

    private function reservations(): Reservation
    {
        $faker = Factory::create();

        return new Reservation(
            true,
            '2020-09-10 00:00:00',
            '2020-09-12 00:00:00',
            new ReservationHolder(
                $faker->firstName(),
                $faker->lastName(),
                $faker->phoneNumber(),
                $faker->email(),
            ),
            new Room(
                $faker->numberBetween(0, 100),
            ),
        );
    }
}
