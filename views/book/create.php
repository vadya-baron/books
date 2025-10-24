<?php

declare(strict_types=1);

use app\src\Domain\Forms\BookForm;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var BookForm $form
 * @var View $this
 */

$this->title = 'Добавить книгу';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="book-create">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="card-body">
                    <?= $this->render('form', ['form' => $form]) ?>
                </div>
            </div>
        </div>
    </div>
</div>