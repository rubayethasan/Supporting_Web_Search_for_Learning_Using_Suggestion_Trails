<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AnswersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="answers-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'worker_id') ?>

    <?= $form->field($model, 'topic_id') ?>

    <?= $form->field($model, 'topic_subject') ?>

    <?= $form->field($model, 'question_answer') ?>

    <?php // echo $form->field($model, 'right_answer') ?>

    <?php // echo $form->field($model, 'wrong_answer') ?>

    <?php // echo $form->field($model, 'result') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'create_date') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
