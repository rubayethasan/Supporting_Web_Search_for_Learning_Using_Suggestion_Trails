<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Suggestion */

$this->title = Yii::t('app', 'Update Suggestion: {nameAttribute}', [
    'nameAttribute' => $model->topic_name,
]);
/*$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Suggestions'), 'url' => ['index']];*/
$this->params['breadcrumbs'][] = ['label' => $model->topic_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="suggestion-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
