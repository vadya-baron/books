<?php

declare(strict_types=1);

namespace app\src\App\UseCases;

use app\src\Domain\Repositories\ReportRepository;
use app\src\App\DTO\TopAuthorsReport as TopAuthorsReportDTO;
use app\src\App\DTO\AuthorStats as AuthorStatsDTO;

final readonly class ReportUseCase
{
    public function __construct(
        private ReportRepository $reportRepository
    ) {
    }

    public function execute(int $year): TopAuthorsReportDTO
    {
        $topAuthors = $this->reportRepository->findTopAuthorsByYear($year);

        $authorsStats = array_map(
            fn(array $data) => new AuthorStatsDTO(
                authorName: $data['author_name'],
                bookCount: (int)$data['book_count'],
                authorId: (int)$data['author_id']
            ),
            $topAuthors
        );

        return new TopAuthorsReportDTO($year, $authorsStats);
    }
}