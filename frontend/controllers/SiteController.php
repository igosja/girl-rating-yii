<?php
declare(strict_types=1);

namespace frontend\controllers;

use common\models\Girl;
use yii\web\ErrorAction;

/**
 * Class SiteController
 * @package frontend\controllers
 */
class SiteController extends AbstractController
{
    /**
     * @return string[][]
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $girls = Girl::find()
            ->orderBy(['rating' => SORT_DESC])
            ->limit(8)
            ->all();

        $this->view->title = 'Girls';
        return $this->render('index', [
            'girls' => $girls,
        ]);
    }
}
