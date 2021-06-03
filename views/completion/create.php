<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Completion */

$this->title = Yii::t('app', 'Create Completion');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Completions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="completion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
