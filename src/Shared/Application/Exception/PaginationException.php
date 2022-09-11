<?php

declare(strict_types=1);

namespace App\Shared\Application\Exception;

use Exception;

class PaginationException extends Exception
{
    public static function pageNumberLessThanZero(): PaginationException {
        return new self('Page number must be greater than zero', 400);
    }
}