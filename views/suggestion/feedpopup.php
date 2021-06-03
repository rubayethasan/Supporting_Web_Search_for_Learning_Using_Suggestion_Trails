<div>
    <h4>Suggestion topic: <?= $topic_name ?></h4>
</div>
<div>
    <?php foreach($suggestios as $suggestion){?>
        <div class = "sug-single">
            <div class = "sug-header">
                Rating:<span id="rating-<?=$suggestion['id']?>"><?= number_format($suggestion['rating'], 2, '.', ',') ?></span>
            </div>
            <div class = "sug-body sug-text" id="<?=$suggestion['id']?>">
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
</div>


