<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Answers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="answers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'worker_id')->textInput() ?>

    <?= $form->field($model, 'topic_id')->textInput() ?>

    <?= $form->field($model, 'topic_subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'question_answer')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'right_answer')->textInput() ?>

    <?= $form->field($model, 'wrong_answer')->textInput() ?>

    <?= $form->field($model, 'result')->textInput() ?>

    <?= $form->field($model, 'state')->dropDownList([ 'presearch' => 'Presearch', 'postsearch' => 'Postsearch', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'create_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
