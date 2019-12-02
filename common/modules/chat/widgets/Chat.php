<?php
namespace common\modules\chat\widgets;

use common\modules\chat\assets\ChatAsset;
use Yii;
use yii\bootstrap\Widget;
class Chat extends Widget
{
    public function init()
    {
        ChatAsset::register($this->view);
    }

    public function run()
    {
        return $this->render('chat');
    }
}
