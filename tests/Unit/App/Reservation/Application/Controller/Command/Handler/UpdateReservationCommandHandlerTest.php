<?php

namespace Reservation\Application\Controller\Command\Handler;

use App\Reservation\Application\Controller\Command\Handler\UpdateReservationCommandHandler;
use App\Reservation\Application\Controller\Command\UpdateReservationCommand;
use App\Reservation\Application\Dto\Reservation;
use App\Reservation\Application\Dto\ReservationHolder;
use App\Reservation\Application\Dto\Room;
use App\Reservation\Domain\Model\Write\ReservationWriteInterface;
use Faker\Factory;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

class UpdateReservationCommandHandlerTest extends TestCase
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
        $reservationId = 1;

        $command = Mockery::mock(UpdateReservationCommand::class, [$reservationId, $reservation]);
        $command->shouldReceive('newReservation')->andReturn($reservation);
        $command->shouldReceive('oldReservationId')->andReturn($reservationId);

        $model->shouldReceive('update')->with($reservationId, $reservation);

        $handler = new UpdateReservationCommandHandler($model);

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
