<?php
require 'functions.php';
require 'loggdata.php';

// var_dump(initHook(true, true));


if ($data['message']['text'] === 'Показать клавиатуру' || $data['message']['text'] === '/start') {
    tgSendKeyboard();
}

if ($data['message']['text'] === 'Список доменов') {
    $query = [
        'chat_id' => TG_USER_ID,
        'text' => 'Список доменов:',
        'parse_mode' => 'html',
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                tgKeyboardShowDomains()
            ],
        ]),
    ];
    tgSendMessage($query);
}

if ($data['message']['text'] === 'Убрать клавиатуру') {
    tgKeyboardRemove();
}

if ($data['callback_query']) {
    $getQuery = [
        'chat_id' => TG_USER_ID,
        'text' => getDomainInfo($data['callback_query']['data']),
        'parse_mode' => 'html'
    ];

    tgSendMessage($getQuery);
}
