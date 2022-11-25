<?php
declare(strict_types=1);

namespace frontend\controllers;

use common\helpers\ErrorHelper;
use common\models\Vote;
use frontend\services\VoteCreateService;
use frontend\services\VoteService;
use Yii;
use yii\web\Response;

/**
 * Class VotesController
 * @package frontend\controllers
 */
class VotesController extends AbstractController
{
    /**
     * @return Response
     */
    public function actionIndex(): Response
    {
        /**
         * @var Vote $vote
         */
        $vote = Vote::find()
            ->andWhere(['girl_id_winner' => null])
            ->andWhere(['<', 'created_at', time() - 24 * 60 * 60])
            ->one();
        if ($vote) {
            return $this->redirect(['view', 'id' => $vote->id]);
        }

        $service = new VoteCreateService();

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $service->execute();
            $transaction->commit();
        } catch (\Exception $e) {
            ErrorHelper::log($e);
            $transaction->rollBack();

            return $this->redirect(['index']);
        }

        return $this->redirect(['view', 'id' => $service->getVoteId()]);
    }

    /**
     * @param int $id
     * @return string|Response
     */
    public function actionView(int $id): Response|string
    {
        $vote = $this->getVote($id);
        if (!$vote || $vote->girl_id_winner) {
            return $this->redirect(['index']);
        }

        $this->view->title = 'Vote #' . $id;
        return $this->render('view', [
            'vote' => $vote,
        ]);
    }

    /**
     * @param int $id
     * @param int $girlId
     * @return Response
     */
    public function actionVote(int $id, int $girlId): Response
    {
        $vote = $this->getVote($id);
        if (!$vote || $vote->girl_id_winner) {
            return $this->redirect(['index']);
        }

        $service = new VoteService($vote, $girlId);

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!$service->execute()) {
                return $this->redirect(['view', 'id' => $id]);
            }

            $transaction->commit();
        } catch (\Exception $e) {
            ErrorHelper::log($e);
            $transaction->rollBack();

            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->redirect(['index']);
    }

    /**
     * @param int $id
     * @return Vote|null
     */
    private function getVote(int $id): ?Vote
    {
        /**
         * @var Vote $vote
         */
        $vote = Vote::find()
            ->andWhere(['id' => $id])
            ->limit(1)
            ->one();
        if (!$vote) {
            return null;
        }

        return $vote;
    }
}
