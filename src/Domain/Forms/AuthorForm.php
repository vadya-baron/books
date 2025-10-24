<?php

declare(strict_types=1);

namespace app\src\Domain\Forms;

use app\src\Domain\Entities\Author;
use app\src\Domain\Repositories\AuthorRepository;
use app\src\Domain\ValueObjects\AuthorKey;
use yii\base\Model;

final class AuthorForm extends Model
{
    public string $fullName = '';
    public ?int $id;

    public function __construct(
        private readonly AuthorRepository $authorRepository,
        ?int $id = null,
        array $config = []
    ) {
        parent::__construct($config);

        $this->id = $id;
    }

    public function rules(): array
    {
        return [
            [['fullName'], 'required'],
            ['fullName', 'string', 'max' => 150],
            ['fullName', 'validateAuthor'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'fullName' => 'ФИО автора',
        ];
    }

    public function validateAuthor(string $attribute, ?array $params = null): void
    {
        if ($this->hasErrors($attribute) || empty($this->fullName)) {
            return;
        }

        $key = new AuthorKey($this->fullName);

        $author = $this->authorRepository->findByKey($key);

        if (!empty($author)) {
            $this->addError($attribute, "Этот автор уже существует");
        }
    }



    public function loadFromAuthor(?Author $author = null): void
    {
        if ($author === null) {
            return;
        }

        $this->id = $author->id();
        $this->fullName = $author->fullName();
    }
}