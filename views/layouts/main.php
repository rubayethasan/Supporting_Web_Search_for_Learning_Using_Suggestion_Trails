<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php

$this->beginBody();

$menu_items = [
    /*['label' => 'Home', 'url' => ['/site/index']],
    ['label' => 'About', 'url' => ['/site/about']],*/
    //['label' => 'Search', 'url' => ['/answers/customsearch']],
    //['label' => 'Suggestion Feed', 'url' => ['/suggestion/feed']]
];
if(Yii::$app->user->isGuest){
/*    $menu_items[] = ['label' => 'Suggestion Feed', 'url' => ['/suggestion/feed/'.Yii::$app->getRequest()->getCookies()->getValue('current_topic_id')]];*/
    //$menu_items[] = ['label' => 'Login', 'url' => ['/site/login']];
}else{
    $menu_items[] = ['label' => 'Searches', 'url' => ['/qryclick/index']];
    $menu_items[] = ['label' => 'Answers', 'url' => ['/answers/index']];
    $menu_items[] = ['label' => 'Suggestions', 'url' => ['/suggestion/index']];
    $menu_items[] = ['label' => 'Observations', 'url' => ['/observation/index']];
    $menu_items[] = ['label' => 'Pages', 'url' => ['/pageviewed/index']];
    $menu_items[] = ['label' => 'Suggestion Modal', 'url' => ['/modaltrace/index']];
    $menu_items[] = ['label' => 'Observation Modal', 'url' => ['/observationmodaltrace/index']];
    $menu_items[] = ['label' => 'Finish', 'url' => ['/completion/index']];
    $menu_items[] = ['label' => 'Idle Users', 'url' => ['/idleusers/index']];
    $menu_items[] = ['label' => 'Completion Code', 'url' => ['/completioncode/index']];
    $menu_items[] = ['label' => 'Topics', 'url' => ['/topics/index']];
    $menu_items[] = ['label' => 'Questions', 'url' => ['/questions/index']];
    $menu_items[] = ['label' => 'BcsCodes', 'url' => ['/bcscode/index']];
    $menu_items[] = '<li>'
        . Html::beginForm(['/site/logout'], 'post')
        . Html::submitButton(
            'Logout (' . Yii::$app->user->identity->username . ')',
            ['class' => 'btn btn-link logout']
        )
        . Html::endForm()
        . '</li>';
}


$guest_id = rand(10000,5000);
$topic_id = rand(1,10);
?>

<input id = "baseurl" type="hidden" value="<?= Yii::$app->request->baseUrl?>">
<input id = "action-id" type="hidden" value="<?= Yii::$app->controller->action->id?>">
<input type="hidden" id="check-guest" value="<?=Yii::$app->user->isGuest?>">
<input type="hidden" id="phase" value="<?=Yii::$app->params['phase']?>">
<div class="wrap">
    <?php



    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => "#",
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menu_items
    ]);



    NavBar::end();
    ?>

    <div class="container">
        <?php

        if(!Yii::$app->user->isGuest) {
            echo Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]);
        }
        echo Alert::widget();
        echo $content;
        ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">SSwST: Supporting Search with Suggestion Trails <?= date('Y') ?></p>

        <!--<p class="pull-right"><?/*= Yii::powered() */?></p>-->
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
