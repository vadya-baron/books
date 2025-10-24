<?php

declare(strict_types=1);

use app\src\Domain\Forms\AuthorForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var AuthorForm $form
 * @var View $this
 * @var bool $isUpdate
 */

$isUpdate = $form->id !== null;
?>

<?php $authorForm = ActiveForm::begin([
    'id' => 'author-form',
    'options' => ['class' => 'form-horizontal'],
]); ?>

<?= $authorForm->field($form, 'fullName')->textInput([
    'maxlength' => true,
    'placeholder' => 'ФИО автора'
]) ?>


    <div class="form-group">
        <?= Html::submitButton(
            $isUpdate ? 'Обновить' : 'Создать',
            ['class' => $isUpdate ? 'btn btn-primary' : 'btn btn-success']
        ) ?>
        <?= Html::a('Закрыть', ['index'], ['class' => 'btn btn-secondary']) ?>

        <?php if ($isUpdate): ?>
            <?= Html::a('Удалить', ['delete', 'id' => $form->id], [
                'class' => 'btn btn-danger float-right',
                'data' => [
                    'confirm' => 'Вы действительно хотите удалить автора "' . $form->fullName . '"?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </div>

<?php ActiveForm::end(); ?>