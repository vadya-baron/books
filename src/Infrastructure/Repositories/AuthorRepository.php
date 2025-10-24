<?php

namespace app\src\Infrastructure\Repositories;

use app\src\Domain\Entities\Author;
use app\src\Domain\ValueObjects\AuthorKey;
use yii\db\Connection;
use app\src\Domain\Repositories\AuthorRepository as AuthorRepositoryInterface;
use yii\db\Query;
use Exception;

final readonly class AuthorRepository implements AuthorRepositoryInterface
{
    public function __construct(
        private Connection $db
    ) {
    }

    public function findById(int $id): ?Author
    {
        $row = (new Query())
            ->from('authors')
            ->where(['id' => $id])
            ->one($this->db);

        if (!$row) {
            return null;
        }

        return $this->toAuthor($row);
    }

    public function findByKey(AuthorKey $key): ?Author
    {
        $row = (new Query())
            ->from('authors')
            ->where(['key' => $key->key()])
            ->one($this->db);

        if (!$row) {
            return null;
        }

        return $this->toAuthor($row);
    }

    public function findByIds(array $ids): array
    {
        $rows = (new Query())
            ->from('authors')
            ->where(['id' => $ids])
            ->all($this->db);

        return array_map([$this, 'toAuthor'], $rows);
    }

    public function findAll(): array
    {
        $rows = (new Query())
            ->from('authors')
            ->all($this->db);

        return array_map([$this, 'toAuthor'], $rows);
    }

    /**
     * @throws Exception
     */
    public function save(Author $author): void
    {
        if ($author->id() == null) {
            $this->db->createCommand()
                ->insert('authors', [
                    'full_name' => $author->fullName(),
                    'key' => $author->key(),
                ])
                ->execute();

            $id = $this->db->getLastInsertID();
            $author->addId(intval($id));
        } else {
            $this->db->createCommand()
                ->update('authors', [
                    'full_name' => $author->fullName(),
                    'key' => $author->key(),
                ], ['id' => $author->id()])
                ->execute();
        }
    }

    /**
     * @throws Exception
     */
    public function delete(Author $author): void
    {
        if ($author->id() != null) {
            $this->db->createCommand()
                ->delete('authors', ['id' => $author->id()])
                ->execute();
        }
    }

    private function toAuthor(array $row): Author
    {
        return new Author(
            id: (int)$row['id'],
            fullName: $row['full_name'],
            key: new AuthorKey($row['key']),
        );
    }
}