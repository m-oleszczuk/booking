<?php

declare(strict_types=1);

namespace App\Reservation\Application\Factory;

use App\Reservation\Application\Dto\Room;
use Exception;
use App\Reservation\Application\Dto\Reservation;
use App\Reservation\Application\Dto\ReservationDates;
use App\Reservation\Application\Dto\ReservationHolder;
use App\Reservation\Application\Dto\RoomReservation;

class ReservationFactory
{
    /** @throws Exception */
    public function createReservation($data): Reservation {
        return (
            new Reservation(
                $data['confirmed'],
                $data['start_date'],
                $data['end_date'],
                $this->createReservationHolder($data),
                $this->createRoom($data),
            )
        );
    }

    public function createReservationHolder(array $data): ReservationHolder {
        return new ReservationHolder(
            $data['first_name'],
            $data['last_name'],
            $data['phone_number'],
            $data['email'],
        );
    }

    public function createRoom(array $data): Room {
        return new Room(
            $data['number'],
            $data['premium'],
        );
    }
}