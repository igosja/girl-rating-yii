<?php
declare(strict_types=1);

/**
 * @var common\models\Girl[] $girls
 */

use yii\bootstrap5\Html;

?>
<div class="row text-center">
    <?php foreach ($girls as $girl) : ?>
        <div class="col-lg-3 col-sm-6">
            <?= Html::img($girl->getFileUrl(), ['class' => 'img-fluid img-thumbnail']) ?>
            <h3><?= $girl->name ?></h3>
            <h6><?= $girl->rating ?></h6>
        </div>
    <?php endforeach ?>
</div>
