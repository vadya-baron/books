<?php

declare(strict_types=1);

namespace app\src\Domain\ValueObjects;

use InvalidArgumentException;

final readonly class Phone
{
    public function __construct(
        public string $value
    ) {
        if (!$this->isValid()) {
            throw new InvalidArgumentException('Неверный формат номера телефона');
        }
    }

    private function isValid(): bool
    {
        $cleanPhone = $this->cleanPhone();
        $pattern = '/^(\+7|7|8)?[-\s]?\(?[489]\d{2}\)?[-\s]?\d{3}[-\s]?\d{2}[-\s]?\d{2}$/';

        return preg_match($pattern, $cleanPhone) === 1;
    }

    public function normalize(): string
    {
        return $this->cleanPhone();
    }

    private function cleanPhone(): string
    {
        return preg_replace('/\D/', '', $this->value);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}