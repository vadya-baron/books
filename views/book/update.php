<?php

declare(strict_types=1);

use app\src\Domain\Forms\BookForm;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var BookForm $form
 * @var View $this
 */

$this->title = 'Обновить книгу: ' . Html::encode($form->title);
$this->params['breadcrumbs'][] = ['label' => $form->title, 'url' => ['view', 'id' => $form->id]];
$this->params['breadcrumbs'][] = 'Обновить книгу';

?>
<div class="book-update">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title"><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body">
            <?= $this->render('form', ['form' => $form]) ?>
        </div>
    </div>
</div>