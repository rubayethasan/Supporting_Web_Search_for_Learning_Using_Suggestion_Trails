<?php
/**
 * Created by PhpStorm.
 * User: mdrubayethasan
 * Date: 08.04.18
 * Time: 17:57
 */
use yii\helpers\Html;
$this->title = Yii::t('app', Yii::$app->name);
if(Yii::$app->params['phase'] == 2){
?>
<div class="breadcrumb">
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#suggestion-feed-popup-modal" id="modal-active-button">View Previous Suggestions</button>
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#observation-popup-modal" id="observation-modal-active-button">View Previous Experiences</button>
</div>
<!--suggestion feed modal start-->
<div class="modal fade" id="suggestion-feed-popup-modal" role="dialog" data-backdrop="static">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">You can follow previous suggestions to satisfy your information need.</h4>
            </div>

            <div class="modal-body" id="suggestion-feed-popup-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id= "modal-close-button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--suggestion feed modal end-->

<!--suggestion feed modal start-->
<div class="modal fade" id="observation-popup-modal" role="dialog" data-backdrop="static">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Average user experiences from previous searches.</h4>
            </div>

            <div class="modal-body" id="observation-popup-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id= "observation-modal-close-button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--suggestion feed modal end-->

<?php } ?>

<div class="breadcrumb">
    <div>
        <h3>Thanks for your responses! You are now ready to begin the main task. </h3>
        <h4>
            <ul>
                <li>Note that it is mandatory to search and try to learn about the topic <?=$current_topic_subject?>. If "IDLE" behavior is detected, you will not receive the bonus payment.</li>
                <li style="color: red">Please see previous users suggestions and experience during their search on the same topic. This may help to improve your search experience. You can do that by clicking the buttons on top of this page.</li>
                <li style="color: red">For searching use only the search box below. Click on relevant web page links that appear in the search results to learning about the topic.</li>
                <li>When you feel that you have acquired sufficient knowledge, you can proceed to take a final test on the topic of <?=$current_topic_subject?>.</li>
                <li>Note that it is mandatory to search and learn about the topic for at least 1 minute, after that you can proceed to final test.</li>
                <li>We however, encourage you to spend more time to search. The final test will take the average person no more than 2-5 minutes to complete successfully.</li>
                <li>Once you begin the test, you will not be allowed to search the web for answers due to time limits for each question. </li>
            </ul>
        </h4>
    </div>
</div>

<div class="body-content">
    <div class="col-md-12">
        <div class="col-md-4">
            <h3>TOPIC: <?=$current_topic_subject?></h3>
        </div>

        <div class="col-md-5">
            <h3  style="text-align: center;animation: blink 2s infinite; color: red;">
                Please Search Using Below Searchbox
            </h3>
        </div>

        <div class="col-md-2" id = 'proceed-post-search-btn-container' style="text-align: center; margin-bottom: 10px">
            <div id = 'proceed-post-search-dummy' class = 'btn btn-lg btn-success' disabled>
                Proceed to Final Test
            </div>
        </div>
    </div>
    <div class="col-md-12" style="border: 2px solid midnightblue">
        <script type="text/javascript"
                id="bcs_js_snippet"
                src="https://ui.customsearch.ai/api/ux/rendering-js?customConfig=<?=$search_code?>&market=en-US&version=latest&q=">
        </script>
    </div>
</div>
