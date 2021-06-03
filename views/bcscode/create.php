<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Bcscode */

$this->title = Yii::t('app', 'Create Bcscode');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bcscodes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bcscode-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
