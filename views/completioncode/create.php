<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Completioncode */

$this->title = Yii::t('app', 'Create Completioncode');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Completioncodes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="completioncode-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
