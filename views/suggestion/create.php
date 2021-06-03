<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Suggestion */

$this->title = Yii::t('app', Yii::$app->name);
?>
<div class="suggestion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
