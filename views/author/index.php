<?php

/**
 * @var View $this
 * @var array<Author> $authors
 */

use app\src\Domain\Entities\Author;
use yii\web\View;

$this->title = 'Авторы';
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <?php if (!empty($authors)): ?>
                <?php foreach ($authors as $author): ?>
                    <?= $this->render('/entities/author', ['author' => $author, 'showTitle' => true]) ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
