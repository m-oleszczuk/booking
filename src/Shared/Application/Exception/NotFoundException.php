<?php

declare(strict_types=1);

namespace App\Shared\Application\Exception;

use Exception;

class NotFoundException extends Exception
{
    public static function resourceNotFound(): NotFoundException
    {
        return new self('Resource not found', 404);
    }
}
