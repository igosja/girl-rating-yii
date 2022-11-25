<?php
declare(strict_types=1);

use common\helpers\ErrorHelper;
use common\models\Girl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var common\models\Girl $model
 * @var yii\web\View $this
 */

?>
<ul class="list-inline text-center">
    <li class="list-inline-item">
        <?= Html::a(Yii::t('app', 'List'), ['index'], ['class' => ['btn', 'btn-default']]) ?>
    </li>
    <li class="list-inline-item">
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => ['btn', 'btn-default']]) ?>
    </li>
    <li class="list-inline-item">
        <?= Html::a(
            'Delete',
            ['delete', 'id' => $model->id],
            [
                'class' => 'btn btn-default',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure?'),
                ],
            ]
        ) ?>
    </li>
</ul>
<div class="row">
    <?php

    try {
        $attributes = [
            'id',
            'name',
            [
                'attribute' => 'imageFile',
                'format' => 'raw',
                'value' => static function (Girl $model):string {
                    if (file_exists($model->getFilePath())) {
                        return Html::img($model->getFileUrl(), ['class' => 'img-fluid img-thumbnail']);
                    }
                    return '';
                }
            ],
        ];
        $attributes = ArrayHelper::merge($attributes, [
            'rating',
            'votes',
            'created_at:datetime',
            'createdBy.username',
            'updated_at:datetime',
        ]);
        print DetailView::widget([
            'attributes' => $attributes,
            'model' => $model,
        ]);
    } catch (Throwable $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>