<?php

declare(strict_types=1);

namespace App\Reservation\Application\Controller\Write;

use App\Reservation\Application\Controller\Command\DeleteReservationCommand;
use App\Reservation\Application\Dto\Reservation;
use App\Reservation\Application\Dto\ReservationHolder;
use App\Reservation\Application\Dto\Room;
use App\Reservation\Infrastructure\Exception\ReservationException;
use App\Shared\Application\Controller\ApiController;
use App\Reservation\Application\Controller\Command\CreateReservationCommand;
use App\Reservation\Application\Controller\Command\UpdateReservationCommand;
use App\Shared\Application\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ReservationController extends ApiController
{
    public function createAction(Request $request): JsonResponse {
        try {
            $this->commandBus->dispatch(
                new CreateReservationCommand(
                    new Reservation(
                        $request->request->getBoolean('confirmed', false),
                        $request->request->get('start_date'),
                        $request->request->get('end_date'),
                        new ReservationHolder(
                            $request->request->get('first_name'),
                            $request->request->get('last_name'),
                            $request->request->get('phone_number'),
                            $request->request->get('email'),
                        ),
                        new Room(
                            $request->request->getInt('room_number'),
                        ),
                    )
                )
            );
        } catch (NotFoundException) {
            return $this->notFound();
        } catch (ReservationException) {
            return $this->notModified();
        }

        return $this->created();
    }

    public function updateAction(Request $request, int $reservationId): JsonResponse {
        try {
            $this->commandBus->dispatch(
                new UpdateReservationCommand(
                    $reservationId,
                    new Reservation(
                        $request->request->getBoolean('confirmed', false),
                        $request->request->get('start_date'),
                        $request->request->get('end_date'),
                        new ReservationHolder(
                            $request->request->get('first_name'),
                            $request->request->get('last_name'),
                            $request->request->get('phone_number'),
                            $request->request->get('email'),
                        ),
                        new Room(
                            $request->request->getInt('room_number'),
                        ),
                    )
                )
            );
        } catch (NotFoundException) {
            return $this->notFound();
        }

        return $this->updated();
    }

    public function deleteAction(int $reservationId): JsonResponse {
        try {
            $this->commandBus->dispatch(
                new DeleteReservationCommand(
                    $reservationId,
                )
            );
        } catch (NotFoundException) {
            return $this->notFound();
        }

        return $this->deleted();
    }
}