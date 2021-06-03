<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\QryclickSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="qryclick-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'worker_id') ?>

    <?= $form->field($model, 'query_id') ?>

    <?= $form->field($model, 'query_term') ?>

    <?= $form->field($model, 'query_time') ?>

    <?php // echo $form->field($model, 'click_time') ?>

    <?php // echo $form->field($model, 'serp_rank') ?>

    <?php // echo $form->field($model, 'page_url') ?>

    <?php // echo $form->field($model, 'page_title') ?>

    <?php // echo $form->field($model, 'page_description') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
