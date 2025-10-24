<?php

declare(strict_types=1);

namespace app\controllers;

use app\src\App\UseCases\AuthorUseCase;
use app\src\Domain\Forms\AuthorForm;
use Exception;
use Yii;
use yii\web\Response;

class AuthorController extends BaseController
{
    public function __construct(
        $id,
        $module,
        private readonly AuthorUseCase $authorUseCase,
        private readonly AuthorForm $form,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
    }

    public function actionIndex(): Response|string
    {
        return $this->render('index', ['authors' => $this->authorUseCase->getAll()]);
    }

    public function actionView(int $id): Response|string
    {
        $author = $this->authorUseCase->get($id);
        if ($author === null) {
            Yii::$app->session->setFlash('error', 'Автор не найден');

            return $this->goHome();
        }

        return $this->render('view', ['author' => $author]);
    }

    public function actionCreate(): Response|string
    {
        if ($this->request->isPost && $this->form->load($this->request->post())) {
            try {
                if ($this->form->validate()) {
                    $author = $this->authorUseCase->execute($this->form);

                    Yii::$app->session->setFlash('success', 'Автор создан');

                    return $this->redirect(['view', 'id' => $author->id()]);
                }
            } catch (Exception $e) {
                $this->form->addError('*', $e->getMessage());
            }
        }

        return $this->render('create', [
            'form' => $this->form,
        ]);
    }

    public function actionUpdate(int $id): Response|string
    {
        $author = $this->authorUseCase->get($id);
        if ($author === null) {
            Yii::$app->session->setFlash('error', 'Автор создан');

            return $this->goHome();
        }

        $this->form->id = $id;

        if ($this->request->isPost && $this->form->load($this->request->post())) {
            try {
                if ($this->form->validate()) {
                    $author = $this->authorUseCase->execute($this->form);

                    Yii::$app->session->setFlash('success', 'Автор обновлен');

                    return $this->redirect(['view', 'id' => $author->id()]);
                }
            } catch (Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        $this->form->loadFromAuthor($author);

        return $this->render('update', [
            'form' => $this->form,
        ]);
    }

    public function actionDelete(int $id): Response|string
    {
        $author = $this->authorUseCase->get($id);
        if ($author === null) {
            Yii::$app->session->setFlash('error', 'Автор создан');

            return $this->goHome();
        }

        try {
            $this->authorUseCase->delete($author);

            Yii::$app->session->setFlash('success', 'Автор удален');

            return $this->goHome();
        } catch (Exception $e) {
            $this->form->addError('*', $e->getMessage());
        }

        return $this->redirect(['update', 'id' => $id]);
    }
}