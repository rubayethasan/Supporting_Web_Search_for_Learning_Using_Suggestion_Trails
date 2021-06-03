<?php
/**
 * Created by PhpStorm.
 * User: mdrubayethasan
 * Date: 08.04.18
 * Time: 12:16
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = Yii::t('app', Yii::$app->name);
?>
<div class="breadcrumb">
    <?= $instruction ?>
</div>
<div class="topic-header row">
    <div class="col-md-6"><h3>TOPIC: <?= $current_topic_subject ?></h3></div>
</div>
<div class="body-content form-single">
    <div class="answers-form form-body">

        <?php $form = ActiveForm::begin();

        for($i = 0; $i < sizeof($attributes); $i++){

            $right_answer_str = strtoupper(trim($right_answers[$i]));

            if( $right_answer_str == 'TRUE' || $right_answer_str == 'FALSE' ){
                echo  $form->field($model, $attributes[$i])->radioList([ 'TRUE' => 'True', 'FALSE' => 'False', 'I DO NOT KNOW' => 'I Do Not Know'])->label(($i+1).' . '.$labels[$i]);
            }else{
                echo  $form->field($model, $attributes[$i])->textInput()->label($labels[$i]);
            }

        } ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>


