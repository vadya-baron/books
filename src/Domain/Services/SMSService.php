<?php

declare(strict_types=1);

namespace app\src\Domain\Services;

interface SMSService
{
    public function sendSMS(string $number, string $message): bool;
}