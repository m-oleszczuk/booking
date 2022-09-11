<?php

declare(strict_types=1);

namespace App\Shared\Application\ValueObject;

use JsonSerializable;
use App\Shared\Application\Exception\PaginationException;

class Pagination implements JsonSerializable
{
    public const DEFAULT_SIZE = 50;

    private int $page;
    private int $limit;

    /** @throws PaginationException */
    public function __construct(int $pageNumber, int $pageSize = self::DEFAULT_SIZE)
    {
        $this->setPage($pageNumber);
        $this->setLimit($pageSize);
    }

    public function page(): int
    {
        return $this->page;
    }

    public function limit(): int
    {
        return $this->limit;
    }

    public function offset(): int
    {
        return ($this->page - 1) * $this->limit;
    }

    public function jsonSerialize(): array
    {
        return [
            'number' => $this->page,
        ];
    }

    /** @throws PaginationException */
    private function setPage(int $page): void
    {
        if ($page <= 0) {
            throw PaginationException::pageNumberLessThanZero();
        }

        $this->page = $page;
    }

    private function setLimit(int $size): void
    {
        if ($size <= 0) {
            $this->limit = 1;
        } else {
            $this->limit = $size;
        }
    }
}
