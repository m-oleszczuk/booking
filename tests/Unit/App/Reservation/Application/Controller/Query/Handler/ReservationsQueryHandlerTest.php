<?php

namespace Reservation\Application\Controller\Query\Handler;

use App\Reservation\Application\Controller\Query\Handler\ReservationsQueryHandler;
use App\Reservation\Application\Controller\Query\ReservationsQuery;
use App\Reservation\Application\Dto\Reservation;
use App\Reservation\Application\Dto\ReservationHolder;
use App\Reservation\Application\Dto\Room;
use App\Reservation\Domain\Model\Read\ReservationInterface;
use App\Shared\Application\ValueObject\Pagination;
use Faker\Factory;
use Mockery;
use PHPUnit\Framework\TestCase;

class ReservationsQueryHandlerTest extends TestCase
{
    public function testCreatingQueryHandler(): void
    {
        $model = Mockery::mock(ReservationInterface::class);
        $queryHandler = new ReservationsQueryHandler($model);

        $this->assertInstanceOf(ReservationsQueryHandler::class, $queryHandler);
    }

    public function testGettingReservationForHolder(): void
    {
        $reservations = $this->reservations();

        $modelMock = Mockery::mock(ReservationInterface::class);
        $modelMock->shouldReceive('getAllReservations')->andReturn($reservations);

        $pagination = new Pagination(1);

        $query = new ReservationsQuery($pagination);
        $handler = new ReservationsQueryHandler($modelMock);

        $this->assertEquals($handler($query), $reservations);
    }

    private function reservations(): array
    {
        $faker = Factory::create();

        return [
            new Reservation(
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
            ),
            new Reservation(
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
            ),
        ];
    }
}
