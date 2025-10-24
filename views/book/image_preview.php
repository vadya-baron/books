<?php

declare(strict_types=1);

use yii\helpers\Html;

/**
 * @var string $imageUrl
 * @var string $alt
 */

if ($imageUrl === null) {
    return;
}
?>

<div class="image-preview mt-2">
    <div class="card" style="width: 200px;">
        <?= Html::img($imageUrl, [
            'class' => 'card-img-top',
            'alt' => $alt,
            'style' => 'max-height: 300px; object-fit: cover;'
        ]) ?>
    </div>
</div>