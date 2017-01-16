<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/sims.css',
        'css/style.css',
        'css/login.css',
        'css/chosen.css',
    ];
    public $js = [
//        'js/jquery-2.0.3.min.js',
//        'js/chosen.jquery.min.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
