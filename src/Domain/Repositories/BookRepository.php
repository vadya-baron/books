<?php

declare(strict_types=1);

namespace app\src\Domain\Repositories;

use app\src\Domain\Entities\Book;
use app\src\Domain\ValueObjects\ISBN;

interface BookRepository
{
    public function findById(int $id): ?Book;

    public function findByIsbn(ISBN $isbn): ?Book;

    /**
     * @return array<Book>
     * TODO Добавить фильтр
     */
    public function findAll(): array;

    public function save(Book $book): void;

    public function delete(Book $book): void;
}