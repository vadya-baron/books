<?php

declare(strict_types=1);

use app\src\Domain\Entities\Author;
use yii\helpers\Html;

/**
 * @var Author $author
 * @var bool $showTitle
 */

?>
<div class="col-lg-4 m-3 p-3 shadow-sm">
    <?= $showTitle ? Html::a($author->fullName(), ['/author/view', 'id' => $author->id()]) : ''; ?>
    <p></p>
    <?=Yii::$app->user->isGuest ? '' : Html::a('Обновить', ['/author/' . $author->id() . '/update']);?>
</div>
