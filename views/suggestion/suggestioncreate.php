<?php
/**
 * Created by PhpStorm.
 * User: mdrubayethasan
 * Date: 11.05.18
 * Time: 21:41
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\range\RangeInput;

/* @var $this yii\web\View */
/* @var $model app\models\Suggestion */
/* @var $form yii\widgets\ActiveForm */

switch ($model->topic_id) {
    case 1:
        $query_placeholder = 'altitude sickness, what is altitude sickness, how sickness grows with altitude';
        break;
    case 2:
        $query_placeholder = 'american revolutionary war, revolutionary war in america, american revolution' ;
        break;
    case 3:
        $query_placeholder = 'carpenter bee, behavior of carpenter bee, carpenter bee size';
        break;
    case 4:
        $query_placeholder = 'theory of evolution, theory of Darwin, What is evolution';
        break;
    case 5:
        $query_placeholder = 'nasa, international space station, nasa missions';
        break;
    case 6:
        $query_placeholder = 'Orcas Island, where is Orcas Island, Orcas';
        break;
    case 7:
        $query_placeholder = 'Sangre de Cristo Mountains, where Sangre de Cristo, Sangre de Cristo';
        break;
    case 8:
        $query_placeholder = 'Sun Tzu, who is Sun Tzu, Sun Tzu biography';
        break;
    case 9:
        $query_placeholder = 'Tornado, what is Tornado, Tornado types';
        break;
    default:
        $query_placeholder = 'USS Cole Bombing, Bombing on USS Cole, USS Cole';
}

$query_placeholder = 'EXAMPLE: '.$query_placeholder.'
NOTE: Please separate two queries with a comma between them.';
$page_placeholder = 'EXAMPLE: wikipedia, google, https://example.com
NOTE: Please separate two page name/url with a comma between them.';

if($state == 'suggestion-create'){?>
    <div class="breadcrumb">
        <h4>Please fill up following feedback section that can help another user search and learn about this topic. You can also reflect on what you found to be useful in your own experience.</h4>
    </div>
    <div><h3>TOPIC: <?= $model->topic_name ?></h3></div>
    <div class="suggestion-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'suggestion_1')->textarea(['rows' => 2, 'placeholder' => $query_placeholder])->label("The queries that were useful in my search were as follows") ?>

        <?= $form->field($model, 'suggestion_2')->textarea(['rows' => 2,'placeholder' => $page_placeholder])->label("I found most of the useful information on the following pages"); ?>

        <?= $form->field($model, 'observation_1')->widget(RangeInput::classname(), [
            'html5Container' => ['style' => 'width:60%'],
            'html5Options' => ['min' => 1, 'max' => 5],
            'options' => ['placeholder' => 'Rate between 1 to 5', 'class' => 'text-center',],
            'addon' => [
                'prepend' => ['content'=>'<span class="text-danger">Short Time (1) </span>'],
                'preCaption' => "<span class='input-group-addon'><span class='text-success'>Long Time (5) </span></span>",
            ]
        ])->label("How much time did it take you to satisfy your information need ?") ?>

        <?= $form->field($model, 'observation_2')->widget(RangeInput::classname(), [
            'html5Container' => ['style' => 'width:60%'],
            'html5Options' => ['min' => 1, 'max' => 5],
            'options' => ['placeholder' => 'Rate between 1 to 5', 'class' => 'text-center',],
            'addon' => [
                'prepend' => ['content'=>'<span class="text-danger">Few Queries (1) </span>'],
                'preCaption' => "<span class='input-group-addon'><span class='text-success'>Many Queries (5) </span></span>",
            ]
        ])->label("How many queries did you have to fire in order to satisfy your information need ?") ?>

        <?= $form->field($model, 'observation_3')->widget(RangeInput::classname(), [
            'html5Container' => ['style' => 'width:60%'],
            'html5Options' => ['min' => 1, 'max' => 5],
            'options' => ['placeholder' => 'Rate between 1 to 5', 'class' => 'text-center',],
            'addon' => [
                'prepend' => ['content'=>'<span class="text-danger">Easy (1) </span>'],
                'preCaption' => "<span class='input-group-addon'><span class='text-success'>Complex (5) </span></span>",
            ]
        ])->label("How complex did you find this search task to be ?") ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
<?php } ?>



