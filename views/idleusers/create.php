<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Idleusers */

$this->title = Yii::t('app', 'Create Idleusers');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Idleusers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="idleusers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
