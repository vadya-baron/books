<?php

declare(strict_types=1);

use app\src\Domain\Forms\BookForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var BookForm $form
 * @var View $this
 * @var bool $isUpdate
 */

$isUpdate = $form->id !== null;
?>

<?php $bookForm = ActiveForm::begin([
    'id' => 'book-form',
    'options' => ['class' => 'form-horizontal'],
]); ?>

<?= $bookForm->field($form, 'title')->textInput([
    'maxlength' => true,
    'placeholder' => 'Название книги'
]) ?>

    <div class="row">
        <div class="col-md-6">
            <?= $bookForm->field($form, 'pubYear')->dropDownList(
                $form->pubYearRange(),
                ['prompt' => 'Выбрать год публикации']
            ) ?>
        </div>
        <div class="col-md-6">
            <?= $bookForm->field($form, 'isbn')->textInput([
                'maxlength' => true,
                'placeholder' => 'ISBN'
            ]) ?>
        </div>
    </div>

<?= $bookForm->field($form, 'authorIDs')->listBox(
    $form->authorsList(),
    [
        'multiple' => true,
        'size' => 6,
        'style' => 'width: 100%'
    ]
) ?>

<?= $bookForm->field($form, 'imageUrl')->textInput([
    'maxlength' => true,
    'placeholder' => 'URL изображения'
]) ?>

<?= $form->imagePreview() ?>

<?= $bookForm->field($form, 'description')->textarea([
    'rows' => 6,
    'placeholder' => 'Описание'
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
                    'confirm' => 'Вы действительно хотите удалить книгу "' . $form->title . '"?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </div>

<?php ActiveForm::end(); ?>