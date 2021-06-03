<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pageviewed */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pageviewed-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'page_url')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'referrer')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'worker_id')->textInput() ?>

    <?= $form->field($model, 'time_clicked')->textInput() ?>

    <?= $form->field($model, 'stay_time')->textInput() ?>

    <?= $form->field($model, 'active_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
