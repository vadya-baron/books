<?php

declare(strict_types=1);

namespace app\src\Domain\Forms;

use app\src\Domain\ValueObjects\Phone;
use InvalidArgumentException;
use yii\base\Model;

final class SubscriptionForm extends Model
{
    public string $phone = '';
    public int $authorID = 0;
    public ?int $id;


    public function rules(): array
    {
        return [
            [['phone', 'authorID'], 'required'],
            ['phone', 'string', 'max' => 15],
            ['phone', 'validatePhone'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'phone' => 'Номер телефона',
            'authorID' => 'ID автора',
        ];
    }

    public function validatePhone(string $attribute, ?array $params = null): void
    {
        if ($this->hasErrors($attribute) || empty($this->phone)) {
            return;
        }

        try {
            new Phone($this->$attribute);
        } catch (InvalidArgumentException $e) {
            $this->addError($attribute, $e->getMessage());
        }
    }
}