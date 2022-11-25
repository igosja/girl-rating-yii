<?php
declare(strict_types=1);

/**
 * @var common\models\Vote $vote
 */

use yii\bootstrap5\Html;

?>
<div class="row text-center">
    <div class="col-lg-12">
        <h1>Vote #<?= $vote->id ?></h1>
    </div>
</div>
<div class="row text-center">
    <div class="col-lg-5 col-md-6 offset-lg-1">
        <?= Html::a(
            Html::img($vote->girlOne->getFileUrl(), ['class' => 'img-fluid img-thumbnail']),
            ['vote', 'id' => $vote->id, 'girlId' => $vote->girl_id_one]
        ) ?>
        <h3><?= $vote->girlOne->name ?></h3>
    </div>
    <div class="col-lg-5 col-md-6">
        <?= Html::a(
            Html::img($vote->girlTwo->getFileUrl(), ['class' => 'img-fluid img-thumbnail']),
            ['vote', 'id' => $vote->id, 'girlId' => $vote->girl_id_two]
        ) ?>
        <h3><?= $vote->girlTwo->name ?></h3>
    </div>
</div>
