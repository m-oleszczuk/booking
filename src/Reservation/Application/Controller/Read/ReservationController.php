<?php

declare(strict_types=1);

namespace App\Reservation\Application\Controller\Read;

use App\Reservation\Application\Controller\Query\ReservationQuery;
use App\Reservation\Application\Controller\Query\ReservationsQuery;
use App\Reservation\Entity\Reservation;
use App\Shared\Application\Controller\ApiController;
use App\Shared\Application\Exception\PaginationException;
use App\Shared\Application\ValueObject\Pagination;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;

class ReservationController extends ApiController
{
    /** @throws PaginationException|Throwable */
    public function reservationsAction(Request $request): JsonResponse {
        $pagination = new Pagination($request->query->getInt('page', 1));

        $reservations = $this->queryBus->query(
            new ReservationsQuery($pagination)
        );

        return new JsonResponse([
            'data' => $reservations,
            'metadata' => [
                'pagination' => [
                    'page' => $pagination->page()
                ]
            ]
        ]);
    }

    /** @throws Throwable */
    public function reservationAction(int $reservationId): JsonResponse {
        $reservation = $this->queryBus->query(
            new ReservationQuery($reservationId)
        );

        return new JsonResponse([
            'data' => $reservation
        ]);
    }
}