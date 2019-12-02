<?php
/**
 * Created by PhpStorm.
 * User: Ghost
 * Date: 02.12.2019
 * Time: 0:49
 */

namespace common\modules\chat\assets;


use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class ChatAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/chat.css',
    ];
    public $js = [
        'js/chat.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
