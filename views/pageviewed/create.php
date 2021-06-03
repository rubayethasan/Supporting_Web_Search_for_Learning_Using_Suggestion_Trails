<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Pageviewed */

$this->title = Yii::t('app', 'Create Pageviewed');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pagevieweds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pageviewed-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
