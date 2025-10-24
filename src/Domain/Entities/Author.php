<?php

declare(strict_types=1);

namespace app\src\Domain\Entities;

use app\src\Domain\ValueObjects\AuthorKey;

final class Author
{
    public function __construct(
        private ?int $id,
        private readonly string $fullName,
        private readonly AuthorKey $key
    ) {
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function fullName(): string
    {
        return $this->fullName;
    }

    public function key(): string
    {
        return $this->key->key();
    }

    public function addId(int $id): void
    {
        $this->id = $id;
    }
}