<?php

declare(strict_types=1);

namespace App\Reservation\Application\Controller\Query;

use App\Shared\Application\ValueObject\Pagination;

class ReservationsQuery
{
    public function __construct(private Pagination $pagination) {}

    public function pagination(): Pagination {
        return $this->pagination;
    }
}