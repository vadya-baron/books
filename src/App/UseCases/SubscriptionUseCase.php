<?php

declare(strict_types=1);

namespace app\src\App\UseCases;

use app\src\Domain\Forms\SubscriptionForm;
use app\src\Domain\Repositories\AuthorRepository;
use app\src\Domain\Repositories\SubscriptionRepository;
use app\src\Domain\ValueObjects\Phone;
use app\src\Infrastructure\Services\SMSService;
use Exception;

final readonly class SubscriptionUseCase
{
    public function __construct(
        private AuthorRepository $authorRepository,
        private SubscriptionRepository $subscriptionRepository,
        private SMSService $smsService,
    ) {
    }

    /**
     * @throws Exception
     */
    public function execute(SubscriptionForm $form): void
    {
        $author = $this->authorRepository->findById($form->id);
        if (empty($author)) {
            throw new Exception('Автор не найден');
        }

        $phone = (new Phone($form->phone))->normalize();
        $this->subscriptionRepository->save($author->id(), $phone);
        $this->smsService->sendSMS($phone, 'Вы подписаны на автора: ' . $author->fullName());
    }
}