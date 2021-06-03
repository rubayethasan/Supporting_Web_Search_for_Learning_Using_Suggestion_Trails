<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Answers */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Answers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answers-view">

    <!--for admin-->
    <?php if(!Yii::$app->user->isGuest){ ?>

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>

    <?php }else{ ?> <!--for guest-->
        <div class="breadcrumb">
            <h4><?= $instruction ?></h4>
        </div>
        <div class = 'blink' style="text-align: center; margin-bottom: 10px;">
            <?= Html::a(Yii::t('app', $btn_text), [$btn_url], ['class' => 'btn btn-lg btn-success']) ?>
        </div>
    <?php } ?>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'worker_id',
            'topic_id',
            'topic_subject',
            'question_answer:ntext',
            'right_answer',
            'wrong_answer',
            'result',
            'state',
            'create_date',
        ],
    ]) ?>

</div>
