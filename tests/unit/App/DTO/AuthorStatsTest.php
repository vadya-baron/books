<?php

declare(strict_types=1);

namespace tests\unit\App\DTO;

use app\src\App\DTO\AuthorStats;
use PHPUnit\Framework\TestCase;

class AuthorStatsTest extends TestCase
{
    private AuthorStats $authorStats;
    private string $authorName = 'Лев Толстой';
    private int $bookCount = 15;
    private int $authorId = 1;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authorStats = new AuthorStats(
            $this->authorName,
            $this->bookCount,
            $this->authorId
        );
    }

    public function testCanBeCreatedWithValidData(): void
    {
        $this->assertInstanceOf(AuthorStats::class, $this->authorStats);
    }

    public function testGetAuthorName(): void
    {
        $this->assertSame($this->authorName, $this->authorStats->authorName());
        $this->assertSame($this->authorName, $this->authorStats->authorName);
    }

    public function testGetBookCount(): void
    {
        $this->assertSame($this->bookCount, $this->authorStats->bookCount());
        $this->assertSame($this->bookCount, $this->authorStats->bookCount);
    }

    public function testGetAuthorId(): void
    {
        $this->assertSame($this->authorId, $this->authorStats->authorId());
        $this->assertSame($this->authorId, $this->authorStats->authorId);
    }

    public function testCanBeCreatedWithZeroBookCount(): void
    {
        $stats = new AuthorStats('Автор без книг', 0, 2);

        $this->assertSame(0, $stats->bookCount());
        $this->assertSame('Автор без книг', $stats->authorName());
        $this->assertSame(2, $stats->authorId());
    }

    public function testToStringIfImplemented(): void
    {
        $stats = new AuthorStats('Пушкин', 15, 3);

        $message = "Автор: {$stats->authorName()}, Книг: {$stats->bookCount()}";
        $this->assertSame('Автор: Пушкин, Книг: 15', $message);
    }
}