<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ModaltraceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modaltrace-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'topic_id') ?>

    <?= $form->field($model, 'topic_name') ?>

    <?= $form->field($model, 'iteration') ?>

    <?php // echo $form->field($model, 'active_time') ?>

    <?php // echo $form->field($model, 'copied_string') ?>

    <?php // echo $form->field($model, 'pasted_string') ?>

    <?php // echo $form->field($model, 'create_date') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
