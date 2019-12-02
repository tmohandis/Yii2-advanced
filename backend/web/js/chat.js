"use strict";

var conn = new WebSocket('ws://localhost:8080');
var username = document.getElementById('username').dataset.username;
conn.onopen = function (e) {
    console.log("Connection established!");
    console.log(username);
};

function createMessageBlock(username, text, owner = false) {
    var messageStyle;
    if (owner) {
        messageStyle = "pull-right message col-lg-4 col-md-4 col-sm-4";
    } else {
        messageStyle = "pull-left message col-lg-4 col-md-4 col-sm-4";
    }
    var chatRow = document.createElement('div');
    chatRow.className = "col-lg-12 col-md-12 col-sm-12 chat-row";
    var messageBlock = document.createElement('div');
    messageBlock.className = messageStyle;
    var usernameBlock = document.createElement('div');
    usernameBlock.className = "col-lg-6 chat-username";
    usernameBlock.innerHTML = username;
    var timeBlock = document.createElement('div');
    timeBlock.className = "col-lg-6 chat-time";
    timeBlock.innerHTML = new Date().toLocaleTimeString();
    var textBlock = document.createElement('div');
    textBlock.className = "col-lg-12 chat-text";
    textBlock.innerHTML = text;

    messageBlock.append(usernameBlock);
    messageBlock.append(timeBlock);
    messageBlock.append(textBlock);
    chatRow.append(messageBlock);

    return chatRow;
}


conn.onmessage = function (e) {
    var chat = $("#chat");
    var data = e.data.split('%');
    chat.append(createMessageBlock(data[0], data[1]));
    //chat.append("<div class='col-lg-12 chat-row'><div class='pull-left message col-lg-4'>" + e.data + "</div></div>");
    chat.scrollTop(chat.prop('scrollHeight'));
};

$("#chat-header").click(function() {
   $("#chat-body").slideToggle('slow');
    $(this).toggleClass("active");
    return false;
});


function sendMessage() {
    var input = $("input[name='chat-input']");
    if (input.val() != '') {
        var chat = $("#chat");
        chat.append(createMessageBlock(username, input.val(), true));
        //chat.append("<div class='col-lg-12 chat-row'><div class='pull-right message owner col-lg-4'>" + input.val() + "</div></div>");
        chat.scrollTop(chat.prop('scrollHeight'));
        conn.send(username + '%' + input.val());
        input.val('');
    }
    else alert('Перед отправкой введите тест сообщения');
}


$(".send-button").on("click", function () {
    sendMessage();
});

$("input[name='chat-input']").keyup(function (event) {

    if (event.keyCode == 13) {
        sendMessage();
    }
});