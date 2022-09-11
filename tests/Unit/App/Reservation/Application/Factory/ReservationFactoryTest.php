<?php

declare(strict_types=1);

namespace Unit\App\Reservation\Application\Factory;

use App\Reservation\Application\Dto\Reservation;
use App\Reservation\Application\Dto\ReservationHolder;
use App\Reservation\Application\Dto\Room;
use App\Reservation\Application\Factory\ReservationFactory;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class ReservationFactoryTest extends TestCase
{
    private const DATA = [
        'confirmed' => true,
        'start_date' => '2020-09-10 00:00:00',
        'end_date' => '2020-09-12 00:00:00',
        'first_name' => 'test',
        'last_name' => 'test',
        'phone_number' => '999888777',
        'email' => 'test@gmail.com',
        'number' => 100,
        'premium' => false,
    ];

    private ReservationFactory $dtoFactory;
    private Reservation $reservation;

    protected function setUp(): void
    {
        parent::setUp();
        $this->dtoFactory = new ReservationFactory();
        $this->reservation = $this->reservation();
    }

    public function testItCreatesReservation(): void
    {
        $result = $this->dtoFactory->createReservation(
            self::DATA
        );

        $this->assertEquals(
            $result,
            $this->reservation
        );
    }

    public function testItCreatesReservationHolderDto(): void
    {
        $result = $this->dtoFactory->createReservationHolder(
            self::DATA
        );

        $this->assertEquals(
            $result,
            $this->reservation->holder
        );
    }

    public function testItCreatesRoomDto(): void
    {
        $result = $this->dtoFactory->createRoom(
            self::DATA
        );

        $this->assertEquals(
            $result,
            $this->reservation->room
        );
    }

    private function reservation(): Reservation {
        return new Reservation(
            self::DATA['confirmed'],
            self::DATA['start_date'],
            self::DATA['end_date'],
            new ReservationHolder(
                self::DATA['first_name'],
                self::DATA['last_name'],
                self::DATA['phone_number'],
                self::DATA['email'],
            ),
            new Room(
                self::DATA['number'],
            ),
        );
    }
}