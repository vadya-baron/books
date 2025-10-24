<?php

declare(strict_types=1);

namespace app\src\Domain\Entities;

use app\src\Domain\ValueObjects\Phone;

final readonly class Subscription
{
    public function __construct(
        private Phone $phone,
        private Author $author,
    ) {
    }

    public function phone(): Phone
    {
        return $this->phone;
    }

    public function author(): Author
    {
        return $this->author;
    }
}