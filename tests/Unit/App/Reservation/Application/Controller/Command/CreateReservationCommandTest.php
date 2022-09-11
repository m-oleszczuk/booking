<?php

namespace Reservation\Application\Controller\Command;

use App\Reservation\Application\Controller\Command\CreateReservationCommand;
use App\Reservation\Application\Dto\Reservation;
use App\Reservation\Application\Dto\ReservationHolder;
use App\Reservation\Application\Dto\Room;
use App\Shared\Application\Exception\InvalidParameterException;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class CreateReservationCommandTest extends TestCase
{
    public function testCreatingQuery(): void
    {
        $command = new CreateReservationCommand($this->reservation());

        $this->assertInstanceOf(CreateReservationCommand::class, $command);
    }

    public function testCreatingQueryInvalidIdException(): void
    {
        $reservation = $this->reservation();
        $reservation->holder->email = 'zzz';

        $this->expectException(InvalidParameterException::class);
        new CreateReservationCommand($reservation);
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
