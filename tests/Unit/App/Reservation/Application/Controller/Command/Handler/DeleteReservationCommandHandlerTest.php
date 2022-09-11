<?php

namespace Reservation\Application\Controller\Command\Handler;

use App\Reservation\Application\Controller\Command\DeleteReservationCommand;
use App\Reservation\Application\Controller\Command\Handler\DeleteReservationCommandHandler;
use App\Reservation\Application\Model\Write\ReservationWriteInterface;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

class DeleteReservationCommandHandlerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testItCreatesReservation(): void
    {
        $model = Mockery::mock(ReservationWriteInterface::class);
        $reservationId = 1;

        $command = Mockery::mock(DeleteReservationCommand::class, [$reservationId]);
        $command->shouldReceive('reservationId')->andReturn($reservationId);

        $model->shouldReceive('delete')->with($reservationId);

        $handler = new DeleteReservationCommandHandler($model);

        $handler($command);
    }
}
