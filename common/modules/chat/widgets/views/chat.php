<?php

use yii\helpers\Html;
?>
<div class="chat col-lg-4">
    <div class="chat-header col-lg-12" id="chat-header">
        Hello here is a chat
    </div>
    <div class="chat-body col-lg-12 center-block" id="chat-body">
        <div class="chat-window" id="chat">
        </div>
        <div class="chat-footer col-lg-12">
            <input name="chat-input"> <?= Html::button('Send', ['class' => 'send-button']); ?>
        </div>

    </div>
</div>
</div>