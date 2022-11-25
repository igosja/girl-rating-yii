<?php
declare(strict_types=1);

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/**
 * @var common\models\Girl $model
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php foreach ($model->getErrorSummary(true) as $error): ?>
            <?= $error ?>
        <?php endforeach ?>
        <?php $form = ActiveForm::begin() ?>
        <?= $form->field($model, 'name')->textInput() ?>
        <?php if (file_exists($model->getFilePath())) : ?>
            <div class="form-group">
                <div class="col-md-6">
                    <?= Html::img($model->getFileUrl(), ['class' => 'img-fluid']) ?>
                </div>
            </div>
        <?php endif ?>
        <?= $form->field($model, 'imageFile')->fileInput() ?>
        <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-default']) ?>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>
