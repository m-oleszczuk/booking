<?php

namespace Reservation\Application\Controller\Command\Handler;

use App\Reservation\Application\Controller\Command\CreateReservationCommand;
use App\Reservation\Application\Controller\Command\Handler\CreateReservationCommandHandler;
use App\Reservation\Application\Dto\Reservation;
use App\Reservation\Application\Dto\ReservationHolder;
use App\Reservation\Application\Dto\Room;
use App\Reservation\Application\Model\Write\ReservationWriteInterface;
use Faker\Factory;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

class CreateReservationCommandHandlerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testItCreatesReservation(): void
    {
        $model = Mockery::mock(ReservationWriteInterface::class);
        $reservation = $this->reservation();

        $command = Mockery::mock(CreateReservationCommand::class, [$reservation]);
        $command->shouldReceive('reservation')->andReturn($reservation);

        $model->shouldReceive('create')->with($reservation);

        $handler = new CreateReservationCommandHandler($model);

        $handler($command);
    }

    private function reservation(): Reservation {
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
