<?php

declare(strict_types=1);

namespace app\src\Domain\Entities;

use app\src\Domain\ValueObjects\ISBN;

final class Book
{
    /**
     * @param array<Author> $authors
     */
    public function __construct(
        private ?int $id,
        private readonly string $title,
        private readonly int $pubYear,
        private readonly string $description,
        private readonly ISBN $isbn,
        private readonly ?string $imageUrl,
        private readonly array $authors = []
    ) {
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function pubYear(): int
    {
        return $this->pubYear;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function isbn(): ISBN
    {
        return $this->isbn;
    }

    public function imageUrl(): ?string
    {
        return $this->imageUrl;
    }

    /**
     * @return array<Author>
     */
    public function authors(): array
    {
        return $this->authors;
    }

    public function addId(int $id): void
    {
        $this->id = $id;
    }
}