<?php

declare(strict_types=1);

namespace app\controllers;

use app\src\App\UseCases\ReportUseCase;
use yii\web\Response;

class TopAuthorsReportController extends BaseController
{
    public function __construct(
        $id,
        $module,
        private readonly ReportUseCase $topAuthorsReport,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
    }

    public function actionIndex(?int $year = null): Response|string
    {
        if ($year === null) {
            $year = intval(date('Y'));
        }

        return $this->render('index', ['report' => $this->topAuthorsReport->execute($year)]);
    }
}