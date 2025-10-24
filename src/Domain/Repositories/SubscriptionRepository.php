<?php

declare(strict_types=1);

namespace app\src\Domain\Repositories;


use Exception;

interface SubscriptionRepository
{
    /**
     * @throws Exception
     */
    public function save(int $authorID, string $phone): void;
}