<?php

declare(strict_types=1);

namespace App\Reservation\Application\Controller\Query\Handler;

use App\Reservation\Application\Controller\Query\ReservationQuery;
use App\Reservation\Application\Dto\Reservation;
use App\Reservation\Application\Model\Read\ReservationInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ReservationQueryHandler implements MessageHandlerInterface
{
    public function __construct(private ReservationInterface $reservationModel) {}

    public function __invoke(ReservationQuery $reservationQuery): Reservation
    {
        return $this->reservationModel->getReservation(
            $reservationQuery->id(),
        );
    }
}