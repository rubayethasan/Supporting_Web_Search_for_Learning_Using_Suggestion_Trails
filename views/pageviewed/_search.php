<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PageviewedSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pageviewed-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'page_url') ?>

    <?= $form->field($model, 'referrer') ?>

    <?= $form->field($model, 'worker_id') ?>

    <?= $form->field($model, 'time_clicked') ?>

    <?php // echo $form->field($model, 'stay_time') ?>

    <?php // echo $form->field($model, 'active_time') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
