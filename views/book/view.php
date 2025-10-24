<?php

declare(strict_types=1);

use app\src\Domain\Entities\Book;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var Book $book
 * @var View $this
 */

$this->title = $book->title();
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-view">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="card-body">
                    <?= $this->render('/entities/book', ['book' => $book, 'showTitle' => false]) ?>
                </div>
            </div>
        </div>
    </div>
</div>