<?php

declare(strict_types=1);

use app\src\Domain\Forms\AuthorForm;
use yii\web\View;
use yii\helpers\Html;

/**
 * @var AuthorForm $form
 * @var View $this
 */

$this->title = 'Добавить автора';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="author-create">
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