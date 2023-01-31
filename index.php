<?php
require 'functions.php';
// require 'inithook.php';
require 'loggdata.php';


if ($data['callback_query']) {
    $getQuery = [
        'chat_id' => TG_USER_ID,
        'text' => getDomainInfo($db_connect, $data['callback_query']['data']),
        'parse_mode' => 'html'
    ];

    tgSendMessage($getQuery);
}

if ($data['message']['text'] === 'Список доменов') {
    $getQuery = [
        'chat_id' => TG_USER_ID,
        'text' => 'Список доменов:',
        'parse_mode' => 'html',
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                tgKeybordDomains($db_connect)
            ],
        ]),
    ];
    tgSendMessage($getQuery);
}

if ($data['message']['text'] === 'Показать клавиатуру' || $data['message']['text'] === '/start') {
    $getQuery = [
        'chat_id' => TG_USER_ID,
        'text' => 'Клавиатура добавлена...',
        'reply_markup' => json_encode(array(
            'keyboard' => array(
                array(
                    array(
                        'text' => 'Список доменов',
                        'callback_data' => 'list',
                    ),
                    array(
                        'text' => 'Убрать клавиатуру',
                        'callback_data' => 'keyboard',
                    )
                )
            ),
            'one_time_keyboard' => TRUE,
            'resize_keyboard' => TRUE,
        )),
    ];
    tgSendMessage($getQuery);
}

if ($data['message']['text'] === 'Убрать клавиатуру') {
    $getQuery = [
        'chat_id' => TG_USER_ID,
        'text' => 'Клавиатура убрана...',
        'reply_markup' => json_encode([
            'remove_keyboard' => true
        ]),
    ];
    tgSendMessage($getQuery);
}
