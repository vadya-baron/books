<?php

declare(strict_types=1);

use app\src\Domain\Forms\AuthorForm;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var AuthorForm $form
 * @var View $this
 */

$this->title = 'Обновить автора: ' . Html::encode($form->fullName);
$this->params['breadcrumbs'][] = ['label' => 'Все авторы', 'url' => ['/author']];
$this->params['breadcrumbs'][] = ['label' => $form->fullName, 'url' => ['view', 'id' => $form->id]];
$this->params['breadcrumbs'][] = 'Обновить автора';

?>
<div class="author-update">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title"><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body">
            <?= $this->render('form', ['form' => $form]) ?>
        </div>
    </div>
</div>