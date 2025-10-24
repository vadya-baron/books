<?php

/**
 * @var View $this
 * @var TopAuthorsReport $report
 */

use yii\web\View;
use app\src\App\DTO\TopAuthorsReport;

$this->title = 'Топ 10 авторов';
?>
<div class="top-authors-report">
    <div class="body-content">
        <div class="row">
            <?php if (!empty($report)): ?>
                <?php foreach ($report->authors() as $author): ?>
                    <p><?= $author->authorName(); ?>: <strong><?= $author->bookCount(); ?></strong></p>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
