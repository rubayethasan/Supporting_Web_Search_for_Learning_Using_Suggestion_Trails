<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Observationmodaltrace */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="observationmodaltrace-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'topic_id')->textInput() ?>

    <?= $form->field($model, 'topic_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'iteration')->textInput() ?>

    <?= $form->field($model, 'active_time')->textInput() ?>

    <?= $form->field($model, 'create_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
