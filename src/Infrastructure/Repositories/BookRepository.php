<?php

declare(strict_types=1);

namespace app\src\Infrastructure\Repositories;

use app\src\Domain\Entities\Author;
use app\src\Domain\Entities\Book;
use app\src\Domain\ValueObjects\AuthorKey;
use app\src\Domain\ValueObjects\ISBN;
use app\src\Domain\Repositories\BookRepository as BookRepositoryInterface;
use yii\db\Connection;
use Exception;
use yii\db\Query;

final readonly class BookRepository implements BookRepositoryInterface
{
    public function __construct(
        private Connection $db
    ) {
    }

    public function findById(int $id): ?Book
    {
        $row = (new Query())
            ->from('books')
            ->where(['id' => $id])
            ->one($this->db);

        if (!$row) {
            return null;
        }

        return $this->toBook($row);
    }

    public function findByIsbn(ISBN $isbn): ?Book
    {
        $row = (new Query())
            ->from('books')
            ->where(['isbn' => (string)$isbn])
            ->one($this->db);

        return $row ? $this->toBook($row) : null;
    }

    public function findAll(): array
    {
        $rows = (new Query())
            ->from('books')
            ->all($this->db);

        return array_map([$this, 'toBook'], $rows);
    }

    /**
     * @throws Exception
     */
    public function save(Book $book): void
    {
        if ($book->id() == null) {
            $this->db->createCommand()
                ->insert('books', [
                    'title' => $book->title(),
                    'pub_year' => $book->pubYear(),
                    'description' => $book->description(),
                    'isbn' => (string)$book->isbn(),
                    'image_url' => $book->imageUrl(),
                ])
                ->execute();

            $id = $this->db->getLastInsertID();
            $book->addId(intval($id));
        } else {
            $this->db->createCommand()
                ->update('books', [
                    'title' => $book->title(),
                    'pub_year' => $book->pubYear(),
                    'description' => $book->description(),
                    'isbn' => (string)$book->isbn(),
                    'image_url' => $book->imageUrl(),
                ], ['id' => $book->id()])
                ->execute();
        }

        $this->saveBookAuthors($book);
    }

    /**
     * @throws Exception
     */
    public function delete(Book $book): void
    {
        if ($book->id() != null) {
            $this->db->createCommand()
                ->delete('books', ['id' => $book->id()])
                ->execute();
        }
    }

    private function toBook(array $row): Book
    {
        return new Book(
            id: (int)$row['id'],
            title: $row['title'],
            pubYear: (int)$row['pub_year'],
            description: $row['description'],
            isbn: new ISBN($row['isbn']),
            imageUrl: $row['image_url'],
            authors: $this->findBookAuthors((int)$row['id'])
        );
    }

    /**
     * @return array<Author>
     */
    private function findBookAuthors(int $bookId): array
    {
        $rows = (new Query())
            ->select(['a.*'])
            ->from(['a' => 'authors'])
            ->innerJoin(['ba' => 'book_authors'], 'a.id = ba.author_id')
            ->where(['ba.book_id' => $bookId])
            ->all($this->db);

        return array_map(function (array $row) {
            return new Author(
                id: (int)$row['id'],
                fullName: $row['full_name'],
                key: new AuthorKey($row['key'])
            );
        }, $rows);
    }

    /**
     * @throws Exception
     */
    private function saveBookAuthors(Book $book): void
    {
        if ($book->id() === null) {
            return;
        }

        $this->db->createCommand()
            ->delete('book_authors', ['book_id' => $book->id()])
            ->execute();

        foreach ($book->authors() as $author) {
            $this->db->createCommand()
                ->insert('book_authors', [
                    'book_id' => $book->id(),
                    'author_id' => $author->id(),
                ])
                ->execute();
        }
    }
}