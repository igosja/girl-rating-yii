<?php
declare(strict_types=1);

namespace backend\controllers;

use backend\search\GirlSearch;
use backend\services\GirlSaveService;
use common\models\Girl;
use Yii;
use yii\web\Response;

/**
 * Class GirlsController
 * @package backend\controllers
 */
class GirlsController extends AbstractController
{
    /**
     * @var string $dbClass
     */
    protected string $dbClass = Girl::class;

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new GirlSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $this->view->title = 'Girls';
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws yii\base\InvalidConfigException
     * @throws yii\web\NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        /**
         * @var Girl $model
         */
        $model = $this->getModel($id);

        $this->view->title = $model->name;
        $this->view->params['breadcrumbs'][] = ['label' => 'Girls', 'url' => ['index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|Response
     */
    public function actionCreate(): Response|string
    {
        $model = new Girl;
        if ($model->load(Yii::$app->request->post())) {
            $service = new GirlSaveService($model);
            if ($service->execute()) {
                $this->successFlash();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        $this->view->title = 'Create';
        $this->view->params['breadcrumbs'][] = ['label' => 'Girls', 'url' => ['index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return yii\web\Response|string
     * @throws yii\base\InvalidConfigException
     * @throws yii\web\NotFoundHttpException
     */
    public function actionUpdate(int $id): Response|string
    {
        /**
         * @var Girl $model
         */
        $model = $this->getModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $service = new GirlSaveService($model);
            if ($service->execute()) {
                $this->successFlash();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        $this->view->title = 'Update';
        $this->view->params['breadcrumbs'][] = ['label' => 'Girls', 'url' => ['index']];
        $this->view->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return yii\web\Response
     * @throws \Throwable
     * @throws yii\db\StaleObjectException
     * @throws yii\web\NotFoundHttpException
     */
    public function actionDelete(int $id): Response
    {
        /**
         * @var Girl $model
         */
        $model = $this->getModel($id);

        if ($model->delete()) {
            $this->successFlash();
        } else {
            $this->errorFlash();
        }

        return $this->redirect(['index']);
    }
}
