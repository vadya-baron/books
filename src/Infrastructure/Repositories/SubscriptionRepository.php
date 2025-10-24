<?php

namespace app\src\Infrastructure\Repositories;

use yii\db\Connection;
use app\src\Domain\Repositories\SubscriptionRepository as SubscriptionRepositoryInterface;
use Exception;

final readonly class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    public function __construct(
        private Connection $db
    ) {
    }

    /**
     * @throws Exception
     */
    public function save(int $authorID, string $phone): void
    {
        $this->db->createCommand()
            ->insert('subscriptions', [
                'author_id' => $authorID,
                'phone' => $phone,
            ])
            ->execute();
    }
}