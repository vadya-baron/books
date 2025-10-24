<?php

declare(strict_types=1);

use app\src\App\UseCases\AuthorUseCase;
use app\src\App\UseCases\BookUseCase;
use app\src\App\UseCases\ReportUseCase;
use app\src\App\UseCases\SubscriptionUseCase;
use app\src\Domain\Repositories\AuthorRepository as AuthorRepositoryInterface;
use app\src\Domain\Repositories\BookRepository as BookRepositoryInterface;
use app\src\Domain\Repositories\ReportRepository as ReportRepositoryInterface;
use app\src\Domain\Repositories\SubscriptionRepository as SubscriptionRepositoryInterface;
use app\src\Domain\Services\SMSService as SMSServiceInterface;
use app\src\Infrastructure\Repositories\BookRepository;
use app\src\Infrastructure\Repositories\AuthorRepository;
use app\src\Infrastructure\Repositories\ReportRepository;
use app\src\Infrastructure\Repositories\SubscriptionRepository;
use app\src\Infrastructure\Services\SMSService;

return [
    'singletons' => [
        BookRepositoryInterface::class => function() {
            return new BookRepository(Yii::$app->db);
        },

        AuthorRepositoryInterface::class => function() {
            return new AuthorRepository(Yii::$app->db);
        },

        SubscriptionRepositoryInterface::class => function() {
            return new SubscriptionRepository(Yii::$app->db);
        },

        ReportRepositoryInterface::class => function() {
            return new ReportRepository(Yii::$app->db);
        },

        BookUseCase::class => function($container) {
            return new BookUseCase(
                $container->get(BookRepositoryInterface::class),
                $container->get(AuthorRepositoryInterface::class)
            );
        },

        AuthorUseCase::class => function($container) {
            return new AuthorUseCase(
                $container->get(AuthorRepositoryInterface::class)
            );
        },

        ReportUseCase::class => function($container) {
            return new ReportUseCase(
                $container->get(ReportRepositoryInterface::class)
            );
        },

        SubscriptionUseCase::class => function($container) {
            return new SubscriptionUseCase(
                $container->get(AuthorRepositoryInterface::class),
                $container->get(SubscriptionRepositoryInterface::class),
                $container->get(SMSServiceInterface::class)
            );
        },

        SMSServiceInterface::class => function() {
            return new SMSService(
                Yii::$app->params['smsSender']['apiKey'],
                Yii::$app->params['smsSender']['sender'],
                Yii::$app->params['smsSender']['url'],
                Yii::$app->params['smsSender']['timeout'],
            );
        },
    ],
];