<?php

declare(strict_types=1);

namespace App\Reservation\Application\Controller\Read;

use App\Reservation\Application\Controller\Query\ReservationHoldersQuery;
use App\Reservation\Application\Controller\Query\ReservationsForHolderQuery;
use App\Reservation\Application\Dto\ReservationHolder;
use App\Shared\Application\Controller\ApiController;
use App\Shared\Application\ValueObject\Pagination;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

class ReservationHolderController extends ApiController
{
    public function reservationHoldersAction(Request $request): JsonResponse
    {
        $pagination = new Pagination($request->query->getInt('page', 1));

        $reservationHolders = $this->queryBus->query(
            new ReservationHoldersQuery($pagination)
        );

        return new JsonResponse([
            'data' => $reservationHolders
        ]);
    }
}