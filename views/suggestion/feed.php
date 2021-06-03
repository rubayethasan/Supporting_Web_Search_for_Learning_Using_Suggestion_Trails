<?php
/**
 * Created by PhpStorm.
 * User: mdrubayethasan
 * Date: 08.03.18
 * Time: 04:03
 */
use yii\helpers\Html;
$this->title = Yii::t('app', Yii::$app->name);
?>
<div class="breadcrumb">
    <h4>Please rate at least 5 of the suggestions given by previous users while searching for <?= $topic_name ?> .</h4>
    <p>After rating 5 suggestions you can click the FINISH button.You will then receive a completion code.</p>

</div>

<div id = 'proceed-finish-btn-container' style="text-align: center; margin-bottom: 10px">
    <div id = 'proceed-finish-dummy' class = 'btn btn-lg btn-success' disabled>
        Finish and Get Completion Code
    </div>
</div>
<div>
    <h4>Suggestions for Topic "<?= $topic_name ?>"</h4>
</div>
<div>
    <?php foreach($suggestios as $suggestion){?>
        <div class = "sug-single">
            <div class = "sug-header">
                Rating:<span id="rating-<?=$suggestion['id']?>"><?= number_format($suggestion['rating'], 2, '.', ',') ?></span>
            </div>
            <div class = "sug-body">
                <?= $suggestion['suggestion'] ?>
            </div>
            <div class = "sug-footer">
            <span>
                <span class="thumbs-up-image">
                    <img id="thumbs_up-<?=$suggestion['id']?>" class="<?=$suggestion['thumbs_up_image_class']?>" src="<?=Yii::$app->request->baseUrl?>/images/thumbs-up.png" alt="thumbsup">
                </span>
                <span id="thumbs_up_count-<?=$suggestion['id']?>" class="thumbs-up-count">
                    <?= $suggestion['thumbs_up'] ?>
                </span>
            </span>
                <span>
                <span class="thumbs-down-image">
                    <img id="thumbs_down-<?=$suggestion['id']?>" class="<?=$suggestion['thumbs_down_image_class']?>" src="<?=Yii::$app->request->baseUrl?>/images/thumbs-down.png" alt="thumbsdown">
                </span>
                <span id="thumbs_down_count-<?=$suggestion['id']?>" class="thumbs-down-count">
                    <?= $suggestion['thumbs_down'] ?>
                </span>
            </span>
            </div>
        </div>
    <?php }?>

    <?php

    if(sizeof($suggestios) < 5){
        $demo_suggestion = [
            "Search for ".$topic_name,
            "Read content of the search result pages.",
            "Search for similar topics.",
            "Follow the instructions written above in page."
        ];
        $demo_suggestion_limit = 5 - sizeof($suggestios);
        for($i = 0; $i < $demo_suggestion_limit ; $i++){?>
            <div class = "sug-single" style="background-color: darkgrey">
                <div class = "sug-header">
                    Rating:<span>0.00</span>
                </div>
                <div class = "sug-body"><?= $demo_suggestion[$i]?></div>
                <div class = "sug-footer">
                    <span>
                        <span class="thumbs-up-image">
                            <img id="thumbs_updemo-<?=$i?>" class="enable_img" src="<?=Yii::$app->request->baseUrl?>/images/thumbs-up.png" alt="thumbsup">
                        </span>
                        <span class="thumbs-up-count">
                            0
                        </span>
                    </span>
                    <span>
                        <span class="thumbs-down-image">
                            <img id="thumbs_downdemo-<?=$i?>" class="enable_img" src="<?=Yii::$app->request->baseUrl?>/images/thumbs-down.png" alt="thumbsdown">
                        </span>
                        <span class="thumbs-down-count">
                            0
                        </span>
                    </span>
                </div>
            </div>

    <?php
        }
    } ?>
</div>



