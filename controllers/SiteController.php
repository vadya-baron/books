<?php

declare(strict_types=1);

namespace app\controllers;

use app\src\App\UseCases\BookUseCase;
use app\src\Domain\Forms\LoginForm;
use Yii;
use yii\web\Response;

class SiteController extends BaseController
{
    public function __construct(
        $id,
        $module,
        private readonly BookUseCase $bookUseCase,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
    }

    public function actionIndex(): Response|string
    {
        $books = $this->bookUseCase->getAll();

        return $this->render('index', ['books' => $books]);
    }

    public function actionLogin(): Response|string
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
