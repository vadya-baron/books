<?php

declare(strict_types=1);

namespace app\src\Infrastructure\Services;

use app\src\Domain\Services\SMSService as SMSServiceInterface;
use yii\base\BaseObject;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;
use yii\httpclient\Exception;

readonly class SMSService implements SMSServiceInterface
{
    private BaseObject $client;
    public function __construct(
        private string $apiKey,
        private string $sender,
        private string $url,
        private int $timeout
    ) {
        $this->client = new Client();
    }

    /**
     * @throws Exception|InvalidConfigException
     */
    public function sendSMS(string $number, string $message): bool
    {

        $response = $this->client->createRequest()
            ->setMethod('GET')
            ->setUrl($this->url)
            ->setData([
                'send' => $message,
                'to' => $number,
                'from' => $this->sender,
                'apikey' => $this->apiKey,
                'format' => 'json'
            ])
            ->setOptions(['timeout' => $this->timeout])
            ->send();

        if ($error = $this->gerError($response->getData())) {
            throw new Exception($error);
        }

        return true;
    }

    private function gerError(mixed $data): ?string
    {
        $error = $data['error'] ?? null;
        if ($error == null) {
            return null;
        }

        return $error['description_ru'] ?? null;
    }
}