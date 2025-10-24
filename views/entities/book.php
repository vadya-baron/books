<?php

declare(strict_types=1);

use app\src\Domain\Entities\Book;
use yii\helpers\Html;

/**
 * @var Book $book
 * @var bool $showTitle
 */

?>
<div class="col-lg-4 mb-3">
    <?= $book->imageUrl() ? Html::img($book->imageUrl(), [
        'class' => 'card-img-top',
        'alt' => $book->title(),
        'style' => 'max-height: 300px; object-fit: cover;'
    ]) : '' ?>
    <?= $showTitle ? Html::a($book->title(), ['/book/view', 'id' => $book->id()]) : ''; ?>
    <p><?= $book->description(); ?></p>
    <p></p>
    <?=Yii::$app->user->isGuest ? '' : Html::a('Обновить', ['/book/update', 'id' => $book->id()]);?>
    <hr>
    <strong>Авторы</strong>
    <ul>
        <?php if ($book->authors()): ?>
            <?php foreach ($book->authors() as $author): ?>
                <li>
                    <?= $author->fullName(); ?>
                    <?= Html::a(
                            'Подписаться на автора &raquo;',
                            ['/subscription', 'author_id' => $author->id()],
                            ['class' => 'btn btn-sm btn-outline-secondary mb-2']
                    ); ?>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>
