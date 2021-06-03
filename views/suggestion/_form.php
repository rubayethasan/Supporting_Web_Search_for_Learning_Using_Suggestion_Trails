<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Suggestion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="suggestion-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput(['maxlength' => true, 'value'=>$model->user_id,'readonly' => true]) ?>

    <?= $form->field($model, 'topic_id')->textInput(['maxlength' => true, 'value'=>$model->topic_id,'readonly' => true]) ?>

    <?= $form->field($model, 'topic_id')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'topic_name')->textInput(['maxlength' => true, 'value'=>$model->topic_name,'readonly' => true]) ?>

    <?= $form->field($model, 'topic_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'suggestion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'thumbs_up')->textInput() ?>

    <?= $form->field($model, 'thumbs_down')->textInput() ?>

    <?= $form->field($model, 'rating')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

