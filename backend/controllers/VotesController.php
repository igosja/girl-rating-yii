<?php
declare(strict_types=1);

namespace backend\controllers;

use backend\search\VoteSearch;
use common\models\Vote;
use Yii;

/**
 * Class VotesController
 * @package backend\controllers
 */
class VotesController extends AbstractController
{
    /**
     * @var string $dbClass
     */
    protected string $dbClass = Vote::class;

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new VoteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $this->view->title = 'Votes';
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
         * @var Vote $model
         */
        $model = $this->getModel($id);

        $this->view->title = $model->id;
        $this->view->params['breadcrumbs'][] = ['label' => 'Votes', 'url' => ['index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
