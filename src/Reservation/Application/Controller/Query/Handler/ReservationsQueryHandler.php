<?php

declare(strict_types=1);

namespace App\Reservation\Application\Controller\Query\Handler;

use App\Reservation\Application\Controller\Query\ReservationsQuery;
use App\Reservation\Application\Model\Read\ReservationInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ReservationsQueryHandler implements MessageHandlerInterface
{
    public function __construct(private ReservationInterface $reservationModel) {}

    public function __invoke(ReservationsQuery $reservationsQuery): array
    {
        return $this->reservationModel->getAllReservations(
            $reservationsQuery->pagination(),
        );
    }
}