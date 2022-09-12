<?php

declare(strict_types=1);

namespace App\Reservation\Application\Controller\Command\Handler;

use App\Reservation\Application\Controller\Command\DeleteReservationCommand;
use App\Reservation\Domain\Model\Write\ReservationWriteInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeleteReservationCommandHandler implements MessageHandlerInterface
{
    public function __construct(private ReservationWriteInterface $reservationModel) {}

    public function __invoke(DeleteReservationCommand $command)
    {
        $this->reservationModel->delete(
            $command->reservationId(),
        );
    }
}