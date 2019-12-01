<?php
$keyboard = [
    ['7', '8', '9'],
    ['4', '5', '6'],
    ['1', '2', '3'],
         ['0']
];

$reply_markup = $telegram->replyKeyboardMarkup([
	'keyboard' => $keyboard, 
	'resize_keyboard' => true, 
	'one_time_keyboard' => true
]);

$response = $telegram->sendMessage([
	'chat_id' => 'CHAT_ID', 
	'text' => 'Hello World', 
	'reply_markup' => $reply_markup
]);

$messageId = $response->getMessageId();

