<?php

declare(strict_types=1);

namespace App\Reservation\Application\Controller\Command\Handler;

use App\Reservation\Domain\Model\Write\ReservationWriteInterface;
use App\Reservation\Application\Controller\Command\UpdateReservationCommand;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UpdateReservationCommandHandler implements MessageHandlerInterface
{
    public function __construct(private ReservationWriteInterface $reservationModel) {}

    public function __invoke(UpdateReservationCommand $command)
    {
        $this->reservationModel->update(
            $command->oldReservationId(),
            $command->newReservation(),
        );
    }
}