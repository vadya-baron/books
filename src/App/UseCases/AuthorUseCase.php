<?php

declare(strict_types=1);

namespace app\src\App\UseCases;

use app\src\Domain\Entities\Author;
use app\src\Domain\Forms\AuthorForm;
use app\src\Domain\Repositories\AuthorRepository;
use app\src\Domain\ValueObjects\AuthorKey;
use DomainException;
use Exception;

final readonly class AuthorUseCase
{
    public function __construct(
        private AuthorRepository $authorRepository
    ) {
    }

    public function get(int $id): ?Author
    {
        return $this->authorRepository->findById($id);
    }

    /**
     * @throws Exception
     */
    public function delete(Author $author): void
    {
        $this->authorRepository->delete($author);
    }

    /**
     * @return array<Author>
     */
    public function getAll(): array
    {
        return $this->authorRepository->findAll();
    }

    /**
     * @throws Exception
     */
    public function execute(AuthorForm $form): Author
    {
        $key = new AuthorKey($form->fullName);

        if ($form->id == null && $this->authorRepository->findByKey($key) !== null) {
            throw new DomainException('Автор уже существует');
        }

        $author = new Author(
            id: null,
            fullName: $form->fullName,
            key: $key
        );

        if ($form->id !== null) {
            $author->addId($form->id);
        }

        $this->authorRepository->save($author);

        return $author;
    }
}