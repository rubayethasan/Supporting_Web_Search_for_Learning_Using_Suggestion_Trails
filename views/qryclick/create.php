<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Qryclick */

$this->title = Yii::t('app', 'Create Qryclick');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Qryclicks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qryclick-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
