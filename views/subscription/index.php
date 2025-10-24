<?php

/**
 * @var View $this
 * @var array<SubscriptionForm> $form
 */


use app\src\Domain\Forms\SubscriptionForm;
use yii\helpers\Html;
use yii\web\View;

$this->title = 'Подписка на автора';
?>
<div class="subscription-index">
    <div class="body-content">
        <div class="row">
            <div class="card-header">
                <h1 class="card-title"><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="card-body">
                <?= $this->render('form', ['form' => $form]) ?>
            </div>
        </div>
    </div>
</div>
