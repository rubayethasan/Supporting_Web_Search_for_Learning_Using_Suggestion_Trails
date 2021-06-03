<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Observation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="observation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'topic_id')->textInput() ?>

    <?= $form->field($model, 'topic_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'observation_1')->textInput() ?>

    <?= $form->field($model, 'observation_2')->textInput() ?>

    <?= $form->field($model, 'observation_3')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
