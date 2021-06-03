<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Qryclick */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="qryclick-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'worker_id')->textInput() ?>

    <?= $form->field($model, 'query_id')->textInput() ?>

    <?= $form->field($model, 'query_term')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'query_time')->textInput() ?>

    <?= $form->field($model, 'click_time')->textInput() ?>

    <?= $form->field($model, 'serp_rank')->textInput() ?>

    <?= $form->field($model, 'page_url')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'page_title')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'page_description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
