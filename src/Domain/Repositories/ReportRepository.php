<?php

declare(strict_types=1);

namespace app\src\Domain\Repositories;


interface ReportRepository
{
    /**
     * @return array<array{author_name: string, book_count: int}>
     */
    public function findTopAuthorsByYear(int $year, int $limit = 10): array;
}