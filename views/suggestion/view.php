<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Suggestion */

$this->title = $model->topic_name;
/*$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Suggestions'), 'url' => ['index']];*/
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suggestion-view">

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

    <?php }else{ ?>
        <div class="breadcrumb">
            <h4>Thank you for providing suggestion.</h4>
        </div>
        <div class = 'blink' style="text-align: center; margin-bottom: 10px;">
            <?= Html::a(Yii::t('app', 'Proceed To Suggestion Feed'), ['feed'], ['class' => 'btn btn-lg btn-success']) ?>
        </div>
    <?php } ?>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'topic_id',
            'topic_name',
            'suggestion:ntext',
            'thumbs_up',
            'thumbs_down',
            'rating',
            'thumbs_up_user_list',
            'thumbs_down_user_list',
            'create_date'
        ],
    ]) ?>

</div>
