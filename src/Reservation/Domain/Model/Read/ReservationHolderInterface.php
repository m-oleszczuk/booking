<?php

declare(strict_types=1);

namespace App\Reservation\Domain\Model\Read;

use App\Reservation\Application\Dto\ReservationHolder;
use App\Shared\Application\ValueObject\Pagination;

interface ReservationHolderInterface
{
    /** @return ReservationHolder[] */
    public function getAllReservationHolders(Pagination $pagination): array;
}