<?php

declare(strict_types=1);

namespace App\Reservation\Application\Controller\Query;

use App\Shared\Application\Exception\InvalidParameterException;

class ReservationQuery
{
    private int $id;

    public function __construct(int $id) {
        $this->setId($id);
    }

    private function setId(int $id) {
        if ($id <= 0) {
            throw InvalidParameterException::parameterMustBeGreaterThanZero('id');
        }

        $this->id = $id;
    }

    public function id(): int {
        return $this->id;
    }
}