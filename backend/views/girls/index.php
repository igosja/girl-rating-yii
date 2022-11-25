<?php
declare(strict_types=1);

/**
 * @var yii\data\ArrayDataProvider $dataProvider
 * @var backend\search\GirlSearch $searchModel
 */

use common\helpers\ErrorHelper;
use common\models\Girl;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

?>
<ul class="list-inline text-center">
    <li class="list-inline-item">
        <?= Html::a('Create', ['create'], ['class' => ['btn', 'btn-default']]) ?>
    </li>
</ul>
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
                    'attribute' => 'name',
                    'value' => static function (Girl $model): string {
                        return $model->name;
                    },
                ],
                [
                    'attribute' => 'rating',
                    'value' => static function (Girl $model): int {
                        return $model->rating;
                    },
                ],
                [
                    'class' => ActionColumn::class,
                    'contentOptions' => ['class' => 'text-center'],
                    'headerOptions' => ['class' => 'col-lg-1'],
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