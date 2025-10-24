<?php

declare(strict_types=1);

namespace tests\unit\App\DTO;

use app\src\App\DTO\AuthorStats;
use app\src\App\DTO\TopAuthorsReport;
use PHPUnit\Framework\TestCase;

class TopAuthorsReportTest extends TestCase
{
    private TopAuthorsReport $report;
    private int $year = 2023;

    /** @var array<AuthorStats> */
    private array $authors;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authors = [
            new AuthorStats('Лев Толстой', 15, 1),
            new AuthorStats('Фёдор Достоевский', 12, 2),
            new AuthorStats('Антон Чехов', 8, 3),
        ];

        $this->report = new TopAuthorsReport($this->year, $this->authors);
    }

    public function testCanBeCreatedWithValidData(): void
    {
        $this->assertInstanceOf(TopAuthorsReport::class, $this->report);
    }

    public function testGetYear(): void
    {
        $this->assertSame($this->year, $this->report->year());
        $this->assertSame($this->year, $this->report->year);
    }

    public function testGetAuthors(): void
    {
        $this->assertSame($this->authors, $this->report->authors());
        $this->assertSame($this->authors, $this->report->authors);
    }

    public function testAuthorsArrayContainsAuthorStatsObjects(): void
    {
        $authors = $this->report->authors();

        $this->assertCount(3, $authors);

        foreach ($authors as $author) {
            $this->assertInstanceOf(AuthorStats::class, $author);
        }

        $this->assertSame('Лев Толстой', $authors[0]->authorName());
        $this->assertSame('Фёдор Достоевский', $authors[1]->authorName());
        $this->assertSame('Антон Чехов', $authors[2]->authorName());
    }

    public function testCanBeCreatedWithEmptyAuthorsArray(): void
    {
        $report = new TopAuthorsReport(2024, []);

        $this->assertSame(2024, $report->year());
        $this->assertSame([], $report->authors());
        $this->assertCount(0, $report->authors);
    }
}