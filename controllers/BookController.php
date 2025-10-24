<?php

declare(strict_types=1);

namespace app\controllers;

use app\src\App\UseCases\BookUseCase;
use app\src\Domain\Forms\BookForm;
use Exception;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class BookController extends Controller
{
    public function __construct(
        $id,
        $module,
        private readonly BookUseCase $bookUseCase,
        private readonly BookForm $form,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
    }

    public function actionView(int $id): Response|string
    {
        $book = $this->bookUseCase->get($id);
        if ($book === null) {
            Yii::$app->session->setFlash('error', 'Книга не найдена');

            return $this->goHome();
        }

        return $this->render('view', ['book' => $book]);
    }

    public function actionCreate(): Response|string
    {
        if ($this->request->isPost && $this->form->load($this->request->post())) {
            try {
                if ($this->form->validate()) {
                    $book = $this->bookUseCase->execute($this->form);

                    Yii::$app->session->setFlash('success', 'Книга создана');

                    return $this->redirect(['view', 'id' => $book->id()]);
                }
            } catch (Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'form' => $this->form,
        ]);
    }

    public function actionUpdate(int $id): Response|string
    {
        $book = $this->bookUseCase->get($id);
        if ($book === null) {
            Yii::$app->session->setFlash('error', 'Книга не найдена');

            return $this->goHome();
        }

        $this->form->id = $id;

        if ($this->request->isPost && $this->form->load($this->request->post())) {
            try {
                if ($this->form->validate()) {
                    $book = $this->bookUseCase->execute($this->form);

                    Yii::$app->session->setFlash('success', 'Книга обновлена');

                    return $this->redirect(['view', 'id' => $book->id()]);
                }
            } catch (Exception $e) {
                $this->form->addError('*', $e->getMessage());
            }
        }

        $this->form->loadFromBook($book);

        return $this->render('update', [
            'form' => $this->form,
        ]);
    }

    public function actionDelete(int $id): Response|string
    {
        $book = $this->bookUseCase->get($id);
        if ($book === null) {
            Yii::$app->session->setFlash('error', 'Книга не найдена');

            return $this->goHome();
        }

        try {
            $this->bookUseCase->delete($book);

            Yii::$app->session->setFlash('success', 'Книга удалена');

            return $this->goHome();
        } catch (Exception $e) {
            $this->form->addError('*', $e->getMessage());
        }

        return $this->redirect(['update', 'id' => $id]);
    }
}