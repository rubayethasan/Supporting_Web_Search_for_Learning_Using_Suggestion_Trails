<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = 'Suggestion Manager';
?>
<div class="site-index">
    <div class="breadcrumb">
        <h4>Total process will be executed according to the process flow below. Please go through the diagram below and after understanding start the process.</h4>
        <a href="<?=Yii::$app->request->baseUrl?>/answers/withoutsearch?u=2345">CLICK ME TO START</a>
    </div>
    <div class="body-content">
        <div style="text-align: center">
            <img src="<?=yii::$app->request->baseUrl?>/images/process-flow.png" alt="process-flow">
        </div>

    </div>
</div>
