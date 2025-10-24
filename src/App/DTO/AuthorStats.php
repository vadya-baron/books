<?php

declare(strict_types=1);

namespace app\src\App\DTO;

final readonly class AuthorStats
{
    public function __construct(
        public string $authorName,
        public int $bookCount,
        public int $authorId
    ) {
    }

    public function authorName(): string
    {
        return $this->authorName;
    }

    public function bookCount(): int
    {
        return $this->bookCount;
    }

    public function authorId(): int
    {
        return $this->authorId;
    }
}