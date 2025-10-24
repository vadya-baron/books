<?php

declare(strict_types=1);

namespace app\src\Domain\ValueObjects;

use InvalidArgumentException;

final readonly class AuthorKey
{
    public function __construct(
        public string $fullName
    ) {
        if (empty(trim($fullName))) {
            throw new InvalidArgumentException('ФИО автора не может быть пустым');
        }

        if (mb_strlen(trim($fullName)) > 100) {
            throw new InvalidArgumentException('Имя автора слишком длинное');
        }
    }

    public function key(): string
    {
        return str_replace([' ', '. '], ['.', '.'], mb_strtolower(trim($this->fullName)));
    }
}