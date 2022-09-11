<?php

declare(strict_types=1);

namespace App\Shared\Application\Exception;

use InvalidArgumentException;

class InvalidParameterException extends InvalidArgumentException
{
    public static function parameterMustBeGreaterThanZero(string $name): self
    {
        return new self("Passed parameter: '$name' must be greater than 0");
    }

    public static function emptyParameter(string $name): self
    {
        return new self("Passed parameter: '$name' should not be empty");
    }

    public static function parameterMustBeInstanceOf(string $name, string $properClassName): self
    {
        return new self("Passed parameter: '$name' must be instance of '$properClassName'");
    }

    public static function parameterNotAvailable(array $parameters, string $name): self
    {
        $parameters = json_encode($parameters);

        return new self("Passed parameter: '$name' should contain in $parameters");
    }

    public static function parameterLengthMustBeGreaterThan(string $name, int $minLength): InvalidArgumentException
    {
        return new self("Passed parameter's length: '$name' must be greater than $minLength");
    }

    public static function parameterTypeNotValid(string $type, string $name): self
    {
        return new self("Passed parameter: '$name' values must have type: $type");
    }
}
