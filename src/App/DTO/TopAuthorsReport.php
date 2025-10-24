<?php

declare(strict_types=1);

namespace app\src\App\DTO;

final readonly class TopAuthorsReport
{
    /**
     * @param array<AuthorStats> $authors
     */
    public function __construct(
        public int $year,
        public array $authors
    ) {
    }

    public function year(): int
    {
        return $this->year;
    }

    public function authors(): array
    {
        return $this->authors;
    }
}