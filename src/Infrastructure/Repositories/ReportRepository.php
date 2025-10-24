<?php

declare(strict_types=1);

namespace app\src\Infrastructure\Repositories;

use app\src\Domain\Repositories\ReportRepository as ReportRepositoryInterface;
use yii\db\Connection;
use yii\db\Query;

final readonly class ReportRepository implements ReportRepositoryInterface
{
    public function __construct(
        private Connection $db
    ) {
    }

    public function findTopAuthorsByYear(int $year, int $limit = 10): array
    {
        return (new Query())
            ->select([
                'a.id as author_id',
                'a.full_name as author_name',
                'COUNT(ba.book_id) as book_count'
            ])
            ->from(['a' => 'authors'])
            ->innerJoin(['ba' => 'book_authors'], 'a.id = ba.author_id')
            ->innerJoin(['b' => 'books'], 'ba.book_id = b.id')
            ->where(['b.pub_year' => $year])
            ->groupBy(['a.id', 'a.full_name'])
            ->orderBy(['book_count' => SORT_DESC])
            ->limit($limit)
            ->all($this->db);
    }
}