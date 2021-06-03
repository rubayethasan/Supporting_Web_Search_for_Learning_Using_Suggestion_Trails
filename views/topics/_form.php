<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Topics */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="topics-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'topic_subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'topic_description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
