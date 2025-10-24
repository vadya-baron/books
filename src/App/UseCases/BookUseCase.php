<?php

declare(strict_types=1);

namespace app\src\App\UseCases;

use app\src\Domain\Entities\Book;
use app\src\Domain\Forms\BookForm;
use app\src\Domain\Repositories\AuthorRepository;
use app\src\Domain\Repositories\BookRepository;
use app\src\Domain\ValueObjects\ISBN;
use DomainException;
use Exception;

final readonly class BookUseCase
{
    public function __construct(
        private BookRepository $bookRepository,
        private AuthorRepository $authorRepository
    ) {
    }

    public function get(int $id): ?Book
    {
        return $this->bookRepository->findById($id);
    }

    /**
     * @return array<Book>
     */
    public function getAll(): array
    {
        return $this->bookRepository->findAll();
    }

    /**
     * @throws Exception
     */
    public function execute(BookForm $form): Book
    {
        $isbn = new ISBN($form->isbn);

        if ($form->id == null && $this->bookRepository->findByIsbn($isbn) !== null) {
            throw new DomainException('Книга уже существует');
        }

        $authors = $this->authorRepository->findByIds($form->authorIDs);

        if (empty($authors)) {
            throw new DomainException('Укажите как минимум одного автора');
        }

        /** @var array $authors */
        $book = new Book(
            id: null,
            title: $form->title,
            pubYear: $form->pubYear,
            description: $form->description,
            isbn: $isbn,
            imageUrl: $form->imageUrl,
            authors: $authors
        );

        if ($form->id !== null) {
            $book->addId($form->id);
        }

        $this->bookRepository->save($book);

        return $book;
    }

    /**
     * @throws Exception
     */
    public function delete(Book $book): void
    {
        $this->bookRepository->delete($book);
    }
}