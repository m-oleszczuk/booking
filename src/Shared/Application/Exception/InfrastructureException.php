<?php

declare(strict_types=1);

namespace App\Shared\Application\Exception;

use Exception;
use Throwable;

class InfrastructureException extends Exception
{
    public static function unexpectedError(Throwable $exception): InfrastructureException
    {
        return new self('Fatal Error', 500, $exception);
    }
}
