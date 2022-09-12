<?php

namespace Reservation\Application\Controller\Query\Handler;

use App\Reservation\Application\Controller\Query\Handler\ReservationHoldersQueryHandler;
use App\Reservation\Application\Controller\Query\ReservationHoldersQuery;
use App\Reservation\Application\Dto\ReservationHolder;
use App\Reservation\Domain\Model\Read\ReservationHolderInterface;
use App\Shared\Application\ValueObject\Pagination;
use Faker\Factory;
use Mockery;
use PHPUnit\Framework\TestCase;

class ReservationHoldersQueryHandlerTest extends TestCase
{
    public function testCreatingQueryHandler(): void
    {
        $model = Mockery::mock(ReservationHolderInterface::class);
        $queryHandler = new ReservationHoldersQueryHandler($model);

        $this->assertInstanceOf(ReservationHoldersQueryHandler::class, $queryHandler);
    }

    public function testGettingReservationHolders(): void
    {
        $holders = $this->holders();

        $modelMock = Mockery::mock(ReservationHolderInterface::class);
        $modelMock->shouldReceive('getAllReservationHolders')->andReturn($holders);

        $pagination = new Pagination(1);

        $query = new ReservationHoldersQuery($pagination);
        $handler = new ReservationHoldersQueryHandler($modelMock);

        $this->assertEquals($handler($query), $holders);
    }

    private function holders(): array
    {
        $faker = Factory::create();

        return [
            new ReservationHolder(
                $faker->firstName(),
                $faker->lastName(),
                $faker->phoneNumber(),
                $faker->email(),
            ),
            new ReservationHolder(
                $faker->firstName(),
                $faker->lastName(),
                $faker->phoneNumber(),
                $faker->email(),
            )
        ];
    }
}
