<?php

declare(strict_types=1);

namespace app\controllers;

use app\src\App\UseCases\SubscriptionUseCase;
use app\src\Domain\Forms\SubscriptionForm;
use Exception;
use Yii;
use yii\db\IntegrityException;
use yii\web\Response;

class SubscriptionController extends BaseController
{
    public function __construct(
        $id,
        $module,
        private readonly SubscriptionUseCase $subscriptionUseCase,
        private readonly SubscriptionForm $form,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
    }

    public function actionIndex(int $author_id): Response|string
    {
        $this->form->id = $author_id;

        if ($this->request->isPost && $this->form->load($this->request->post())) {
            try {
                if ($this->form->validate()) {
                    $this->subscriptionUseCase->execute($this->form);

                    Yii::$app->session->setFlash('success', 'Вы успешно подписались на автора');

                    return $this->goHome();
                }
            } catch (IntegrityException $e) {
                Yii::$app->session->setFlash('error', 'Вы уже подписаны на этого автора');
            } catch (Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('index', [
            'form' => $this->form,
        ]);
    }
}