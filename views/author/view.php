<?php

declare(strict_types=1);

use app\src\Domain\Entities\Author;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var Author $author
 * @var View $this
 */

$this->title = $author->fullName();
$this->params['breadcrumbs'][] = ['label' => 'Все авторы', 'url' => ['/author']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-view">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="card-body">
                    <?= $this->render('/entities/author', ['author' => $author, 'showTitle' => false]) ?>
                </div>
            </div>
        </div>
    </div>
</div>