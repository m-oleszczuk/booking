<?php

declare(strict_types=1);

namespace App\Reservation\Application\Controller\Command\Handler;

use App\Reservation\Application\Controller\Command\CreateReservationCommand;
use App\Reservation\Application\Model\Write\ReservationWriteInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateReservationCommandHandler implements MessageHandlerInterface
{
    public function __construct(private ReservationWriteInterface $reservationModel) {}

    public function __invoke(CreateReservationCommand $command)
    {
        $this->reservationModel->create(
            $command->reservation()
        );
    }
}