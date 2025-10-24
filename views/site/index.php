<?php

/**
 * @var View $this
 * @var array<Book> $books
 */

use yii\web\View;
use app\src\Domain\Entities\Book;

$this->title = 'Книги';
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <?php if (!empty($books)): ?>
                <?php foreach ($books as $book): ?>
                    <?= $this->render('/entities/book', ['book' => $book, 'showTitle' => true]) ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
