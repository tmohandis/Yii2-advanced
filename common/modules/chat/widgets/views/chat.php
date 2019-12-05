<?php

use yii\helpers\Html;
?>
<div class="chat col-lg-4">
    <div class="chat-header col-lg-12" id="chat-header">
        Hello here is a chat
    </div>
    <div class="chat-body col-lg-12 center-block" id="chat-body">
        <div class="chat-window" id="chat">
            <?= Html::button('Connect', ['class' => 'send-button chat-connect center-block', 'id' => 'chat-connect']); ?>
        </div>
        <div class="chat-footer col-lg-12 hidden" id="chat-footer">
            <input name="chat-input"> <?= Html::button('Send', ['class' => 'send-button', 'id' => 'chat-send']); ?>
        </div>
    </div>
</div>
</div>