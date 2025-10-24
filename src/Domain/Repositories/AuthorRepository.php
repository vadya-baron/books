<?php

declare(strict_types=1);

namespace app\src\Domain\Repositories;

use app\src\Domain\Entities\Author;
use app\src\Domain\ValueObjects\AuthorKey;

interface AuthorRepository
{
    public function findById(int $id): ?Author;

    public function findByKey(AuthorKey $key): ?Author;

    /**
     * @param array<int> $ids
     * @return array<Author>
     */
    public function findByIds(array $ids): array;

    /**
     * @return array<Author>
     */
    public function findAll(): array;

    public function save(Author $author): void;

    public function delete(Author $author): void;
}