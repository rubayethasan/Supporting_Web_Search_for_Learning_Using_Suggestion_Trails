<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Bcscode */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bcscode-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'search_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'search_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'req_num')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ 'active' => 'Active', 'inactive' => 'Inactive', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
