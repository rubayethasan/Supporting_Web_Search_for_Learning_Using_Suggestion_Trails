<?php
use kartik\range\RangeInput;

if(isset($avg_observation_1) && $avg_observation_1 != ''){
?>
<div class = "sug-single">
    <div class = "sug-body sug-text">

        <label class="control-label">Average time spent.</label>
        <?= RangeInput::widget([
            'name' => 'avg_observation_1',
            'value' => number_format($avg_observation_1, 2, '.', ',').'/5.00',
            'id' => 'avg_observation_1',
            'html5Container' => ['style' => 'width:30%'],
            'html5Options' => ['min' => 1, 'max' => 5,'disabled' => true],
            'options' => ['disabled' => true, 'class' => 'text-center'],
            'addon' => [
                'prepend' => ['content'=>'<span class="text-danger">Short Time (1)</span>'],
                'preCaption' => "<span class='input-group-addon'><span class='text-success'>Long Time (5) </span></span>",
                ]
        ]);?>

        <label class="control-label">Average number of queries fired.</label>
        <?= RangeInput::widget([
            'name' => 'avg_observation_2',
            'value' => number_format($avg_observation_2, 2, '.', ',').'/5.00',
            'id' => 'avg_observation_2',
            'html5Container' => ['style' => 'width:30%'],
            'html5Options' => ['min' => 1, 'max' => 5,'disabled' => true],
            'options' => ['disabled' => true, 'class' => 'text-center'],
            'addon' => [
                'prepend' => ['content'=>'<span class="text-danger">Few Queries (1)</span>'],
                'preCaption' => "<span class='input-group-addon'><span class='text-success'>Many Queries (5) </span></span>",
            ]
        ]);?>

        <label class="control-label">Average perceived complexity of this search task.</label>
        <?= RangeInput::widget([
            'name' => 'avg_observation_3',
            'value' => number_format($avg_observation_3, 2, '.', ',').'/5.00',
            'id' => 'avg_observation_3',
            'html5Container' => ['style' => 'width:30%'],
            'html5Options' => ['min' => 1, 'max' => 5,'disabled' => true],
            'options' => ['disabled' => true, 'class' => 'text-center'],
            'addon' => [
                'prepend' => ['content'=>'<span class="text-danger">Easy (1)</span>'],
                'preCaption' => "<span class='input-group-addon'><span class='text-success'>Complex (5) </span></span>",
            ]
        ]);?>

    </div>
</div>

<?php }else{
    echo "No previous observations for this topic.";
} ?>


