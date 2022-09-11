<?php

namespace Reservation\Application\Controller\Command;

use App\Reservation\Application\Controller\Command\DeleteReservationCommand;
use App\Shared\Application\Exception\InvalidParameterException;
use PHPUnit\Framework\TestCase;

class DeleteReservationCommandTest extends TestCase
{
    public function testCreatingQuery(): void
    {
        $command = new DeleteReservationCommand(1);

        $this->assertInstanceOf(DeleteReservationCommand::class, $command);
    }

    public function testCreatingQueryInvalidIdException(): void
    {
        $this->expectException(InvalidParameterException::class);
        new DeleteReservationCommand(0);
    }

}
