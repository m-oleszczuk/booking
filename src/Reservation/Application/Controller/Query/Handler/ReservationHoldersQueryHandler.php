<?php

declare(strict_types=1);

namespace App\Reservation\Application\Controller\Query\Handler;

use App\Reservation\Application\Controller\Query\ReservationHoldersQuery;
use App\Reservation\Application\Model\Read\ReservationHolderInterface;
use App\Shared\Application\Exception\InfrastructureException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ReservationHoldersQueryHandler implements MessageHandlerInterface
{
    public function __construct(private ReservationHolderInterface $reservationModel) {}

    public function __invoke(ReservationHoldersQuery $reservationsHoldersQuery): array
    {
        return $this->reservationModel->getAllReservationHolders(
            $reservationsHoldersQuery->pagination()
        );
    }
}