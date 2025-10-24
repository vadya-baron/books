<?php

declare(strict_types=1);

namespace app\src\Domain\Entities;


use yii\base\BaseObject;
use yii\web\IdentityInterface;

final class User extends BaseObject implements IdentityInterface
{
    public ?string $id;
    public string $username;
    public string $password;
    public string $authKey;
    public string $accessToken;
    private static array $users = [
        '100' => [
            'id' => '100',
            'username' => 'test',
            'password' => 'test',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
    ];

    public static function findByUsername($username): null|static
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    public static function findIdentity($id): IdentityInterface|static|null
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    public static function findIdentityByAccessToken($token, $type = null): IdentityInterface|static|null
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getAuthKey(): string
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->authKey === $authKey;
    }

    public function validatePassword($password): bool
    {
        return $this->password === $password;
    }
}
