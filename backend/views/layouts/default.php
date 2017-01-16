<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2016/9/29
 * Time: 16:44
 */

use backend\assets\AppAsset;
use yii\helpers\Html;
/* @var $this \yii\web\View */
/* @var $content string */

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
</head>




<body class="login-layout my-login-layout">
<?php $this->beginBody() ?>
<?= $content;?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
