<?php

declare(strict_types=1);

namespace app\src\Domain\Forms;

use app\src\Domain\Entities\Book;
use app\src\Domain\Repositories\AuthorRepository;
use app\src\Domain\ValueObjects\ISBN;
use InvalidArgumentException;
use Yii;
use yii\base\Model;

final class BookForm extends Model
{
    public ?int $id;
    public int $pubYear;
    public string $isbn = '';
    public string $title = '';
    public string $description = '';
    public ?string $imageUrl = null;
    public array $authorIDs = [];

    public function __construct(
        private readonly AuthorRepository $authorRepository,
        ?int $id = null,
        array $config = []
    ) {
        parent::__construct($config);

        $this->id = $id;
        $this->pubYear = (int)date('Y');
    }

    public function rules(): array
    {
        return [
            [['title', 'pubYear', 'description', 'isbn'], 'required'],
            ['title', 'string', 'max' => 150],
            ['description', 'string'],
            ['pubYear', 'integer', 'min' => 1000, 'max' => (int)date('Y')],
            ['isbn', 'string', 'max' => 17],
            ['isbn', 'validateIsbn'],
            ['imageUrl', 'string', 'max' => 255],
            ['authorIDs', 'each', 'rule' => ['integer']],
            ['authorIDs', 'validateAuthors'],
            ['authorIDs', 'required', 'message' => 'Выберите хотя бы одного автора'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'title' => 'Название',
            'pubYear' => 'Год выпуска',
            'description' => 'Описание',
            'isbn' => 'ISBN',
            'imageUrl' => 'URL изображения',
            'authorIDs' => 'Авторы',
        ];
    }

    public function validateIsbn(string $attribute, ?array $params = null): void
    {
        if ($this->hasErrors($attribute)) {
            return;
        }

        try {
            new ISBN($this->$attribute);
        } catch (InvalidArgumentException $e) {
            $this->addError($attribute, $e->getMessage());
        }
    }

    public function validateAuthors(string $attribute, ?array $params = null): void
    {
        if ($this->hasErrors($attribute) || empty($this->authorIDs)) {
            return;
        }

        $authors = $this->authorRepository->findByIds($this->authorIDs);

        if (empty($authors)) {
            $this->addError($attribute, "Не найдено ни одного автора");
        }

        $authorIds = [];
        foreach ($authors as $author) {
            $authorIds[] = $author->id();
        }

        $missingIds = array_diff($this->authorIDs, $authorIds);

        if (!empty($missingIds)) {
            $this->addError($attribute, "Авторов с ID: " . implode(', ', $missingIds) . " не существует");
        }
    }

    public function authorsList(): array
    {
        $authors = $this->authorRepository->findAll();

        $authorsMap = [];
        foreach ($authors as $author) {
            $authorsMap[$author->id()] = $author->fullName();
        }

        return $authorsMap;
    }

    public function loadFromBook(?Book $book = null): void
    {
        if ($book === null) {
            return;
        }

        $this->id = $book->id();
        $this->title = $book->title();
        $this->pubYear = $book->pubYear();
        $this->description = $book->description();
        $this->isbn = (string)$book->isbn();
        $this->imageUrl = $book->imageUrl();
        $this->authorIDs = array_map(fn($author) => $author->id(), $book->authors());
    }

    public function pubYearRange(): array
    {
        $currentYear = (int)date('Y');
        $years = range($currentYear, 1000);

        return array_combine($years, $years);
    }

    public function imagePreview(): string
    {
        if ($this->imageUrl) {
            return Yii::$app->view->render('image_preview', [
                'imageUrl' => $this->imageUrl,
                'alt' => $this->title,
            ]);
        }

        return '';
    }
}