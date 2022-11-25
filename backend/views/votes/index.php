<?php
declare(strict_types=1);

/**
 * @var yii\data\ArrayDataProvider $dataProvider
 * @var backend\search\VoteSearch $searchModel
 */

use common\helpers\ErrorHelper;
use common\models\Vote;
use yii\grid\ActionColumn;
use yii\grid\GridView;

?>
<div class="row">
    <div class="col-lg-12">
        <?php

        try {
            $columns = [
                [
                    'attribute' => 'id',
                    'headerOptions' => ['class' => 'col-lg-1'],
                ],
                [
                    'attribute' => 'girl_id_one',
                    'value' => static function (Vote $model): string {
                        return $model->girlOne->name;
                    },
                ],
                [
                    'attribute' => 'girl_id_two',
                    'value' => static function (Vote $model): string {
                        return $model->girlTwo->name;
                    },
                ],
                [
                    'attribute' => 'girl_id_winner',
                    'value' => static function (Vote $model): string {
                        if (!$model->girl_id_winner) {
                            return '';
                        }
                        return $model->girlWinner->name;
                    },
                ],
                [
                    'class' => ActionColumn::class,
                    'contentOptions' => ['class' => 'text-center'],
                    'headerOptions' => ['class' => 'col-lg-1'],
                    'template' => '{view}',
                ],
            ];
            print GridView::widget([
                'columns' => $columns,
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
            ]);
        } catch (Throwable $e) {
            ErrorHelper::log($e);
        }

        ?>
    </div>
</div>