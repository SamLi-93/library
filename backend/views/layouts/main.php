<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script src="//cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/chosen/1.6.2/chosen.jquery.js"></script>
    <script src="//cdn.bootcss.com/chosen/1.6.2/chosen.jquery.min.js"></script>
    <link href="//cdn.bootcss.com/chosen/1.6.2/chosen.css" rel="stylesheet">
</head>
<body>
<?php $this->beginBody() ?>

<div class="sims_top navbar navbar-default">
    <span class="sims_top1"></span>
    <span class="sims_top3" style="width:30px;">欢迎 </span>
    <span class="sims_top2"><?= empty(Yii::$app->user->identity->name) ? '' : Yii::$app->user->identity->name;?></span>
    <span class="sims_top3"> 图书馆后台管理系统！ </span>
    <span class="sims_top4"></span>
    <span class="sims_top5" id="stimer"></span>
    <span class="logout fright"><a href='../default/logout'>退出</a></span>
</div>

<div class="main-container" id="main-container">
    <div class="main-container-inner">
        <div class="sims_left sidebar" id="sidebar">
            <dt class="sims_list_on">后台管理</dt>
            <dd class="left_cons">
<!--                <a href="--><?//= \yii\helpers\Url::to(['project/index']) ?><!--" class="--><?//= Yii::$app->controller->id == 'project'? 'left_con_on' : 'left_con'; ?><!--">项目管理</a>-->
<!--                <a href="--><?//= \yii\helpers\Url::to(['videomaking/index']) ?><!--" class="--><?//= Yii::$app->controller->id == 'videomaking'? 'left_con_on' : 'left_con'; ?><!--" >课程管理</a>-->
                <a href="<?= \yii\helpers\Url::to(['bookborrow/index']) ?>" class="<?= Yii::$app->controller->id == 'bookborrow'? 'left_con_on' : 'left_con'; ?>">图书借阅</a>
                <a href="<?= \yii\helpers\Url::to(['readerrecommand/index']) ?>" class="<?= Yii::$app->controller->id == 'readerrecommand'? 'left_con_on' : 'left_con'; ?>">读者推荐</a>
                <a href="<?= \yii\helpers\Url::to(['postmaterial/index']) ?>" class="<?= Yii::$app->controller->id == 'postmaterial'? 'left_con_on' : 'left_con'; ?>" >发布素材</a>
                <a href="<?= \yii\helpers\Url::to(['source/index']) ?>" class="<?= Yii::$app->controller->id == 'source'? 'left_con_on' : 'left_con'; ?>" >图文消息管理</a>
                <a href="<?= \yii\helpers\Url::to(['material/index']) ?>" class="<?= Yii::$app->controller->id == 'material'? 'left_con_on' : 'left_con'; ?>" >素材管理</a>
                <a href="<?= \yii\helpers\Url::to(['bookorder/index']) ?>" class="<?= Yii::$app->controller->id == 'bookorder'? 'left_con_on' : 'left_con'; ?>" >图书预约</a>
                <a href="<?= \yii\helpers\Url::to(['lectureorder/index']) ?>" class="<?= Yii::$app->controller->id == 'lectureorder'? 'left_con_on' : 'left_con'; ?>" >讲座订票</a>
                <a href="<?= \yii\helpers\Url::to(['lecturerelease/index']) ?>" class="<?= Yii::$app->controller->id == 'lecturerelease'? 'left_con_on' : 'left_con'; ?>" >讲座发布</a>
                <a href="<?= \yii\helpers\Url::to(['bookpayment/index']) ?>" class="<?= Yii::$app->controller->id == 'bookpayment'? 'left_con_on' : 'left_con'; ?>" >图书扣款</a>
                <a href="<?= \yii\helpers\Url::to(['autoreply/index']) ?>" class="<?= Yii::$app->controller->id == 'autoreply'? 'left_con_on' : 'left_con'; ?>" >自动回复</a>
                <a href="<?= \yii\helpers\Url::to(['account/index']) ?>" class="<?= Yii::$app->controller->id == 'account'? 'left_con_on' : 'left_con'; ?>" >账户管理</a>
                <a href="<?= \yii\helpers\Url::to(['setting/index']) ?>" class="<?= Yii::$app->controller->id == 'setting'? 'left_con_on' : 'left_con'; ?>" >设置管理</a>

            </dd>
        </div>
        <div class="main-content">
            <div class="page-content">
            </div>
        </div>
    </div>
</div>


<?= $content;?>

<?php $this->endBody() ?>
</body>
<script>
    $(document).ready(function(){
        $('.left_con').click(
            function(){
                $(this).addClass("left_con_on");
                $(this).removeClass("left_con");
            }
        );
    });
</script>
</html>
<?php $this->endPage() ?>
