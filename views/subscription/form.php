<?php

declare(strict_types=1);

use app\src\Domain\Forms\SubscriptionForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var SubscriptionForm $form
 * @var View $this
 */

?>

<?php $subscriptionForm = ActiveForm::begin([
    'id' => 'subscription-form',
    'options' => ['class' => 'form-horizontal'],
]); ?>

<?= $subscriptionForm->field($form, 'phone')->textInput([
    'maxlength' => true,
    'placeholder' => 'Номер телефона'
]) ?>


    <div class="form-group">
        <?= Html::submitButton('Подписаться на автора', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Закрыть', ['site/index'], ['class' => 'btn btn-secondary']) ?>
    </div>

<?php ActiveForm::end(); ?>