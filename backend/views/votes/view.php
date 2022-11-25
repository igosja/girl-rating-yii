<?php
declare(strict_types=1);

use common\helpers\ErrorHelper;
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
</ul>
<div class="row">
    <?php

    try {
        $attributes = [
            'id',
            'girlOne.name',
            'girlTwo.name',
            'girlWinner.name',
            'created_at:datetime',
            'updated_at:datetime',
        ];
        print DetailView::widget([
            'attributes' => $attributes,
            'model' => $model,
        ]);
    } catch (Throwable $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>