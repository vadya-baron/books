<?php

declare(strict_types=1);

namespace app\src\Domain\ValueObjects;

use InvalidArgumentException;

final readonly class ISBN
{
    public function __construct(
        public string $value
    ) {
        if (!$this->isValid()) {
            throw new InvalidArgumentException('Неверный формат ISBN');
        }
    }

    private function isValid(): bool
    {
        $isbn = str_replace(['-', ' '], '', $this->value);
        return preg_match('/^(?:\d{9}[\dX]|\d{13})$/', $isbn) === 1;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}