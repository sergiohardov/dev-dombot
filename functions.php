<?php
require 'config.php';

// System //
function initHook($dev = true, $install = true)
{

    $dev ? $url = DEVELOP_URL : $url = SITE_URL;
    $install ? $hook = "/setWebhook?" : $hook = '/deleteWebhook?';

    $data = array(
        "url" => $url . "/index.php",
    );

    $ch = curl_init("https://api.telegram.org/bot" . TG_TOKEN . $hook . http_build_query($data)); // Удалить хук

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);

    $response = curl_exec($ch);
    curl_close($ch);

    echo $url . '<br>';
    return $response;
}

// Data Base //
function db()
{
    try {
        return new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . "; charset=utf8", DB_USER, DB_PASS, [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}
function db_query($sql = '')
{
    if (empty($sql)) return false;
    return db()->query($sql);
}
function db_exec($sql = '')
{
    if (empty($sql)) return false;
    return db()->exec($sql);
}

// Helpers //
function getListDomains()
{
    $request = db_query("SELECT `domain_name` FROM `domain`")->fetchAll();

    $list = [];
    foreach ($request as $item) {
        $list[] = $item['domain_name'];
    }
    return $list;
}

// Telegram //
// Методы
function tgSendMessage($query)
{
    $ch = curl_init('https://api.telegram.org/bot' . TG_TOKEN . '/sendMessage?' . http_build_query($query));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $result = curl_exec($ch);
    curl_close($ch);
}

// Включение клавиатуры внизу
function tgSendKeyboard()
{
    $data = [
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

    tgSendMessage($data);
}

// Кнопки клавиатуры внизу 
function tgKeyboardShowDomains()
{

    $domains = getListDomains();
    $arr = [];

    foreach ($domains as $domain) {
        $arr[] = [
            'text' => $domain,
            'callback_data' => strtolower($domain),
        ];
    }

    $arr = array_chunk($arr, 3);

    $data = [
        'chat_id' => TG_USER_ID,
        'text' => 'Список доменов:',
        'parse_mode' => 'html',
        'reply_markup' => json_encode(
            [
                'inline_keyboard' => $arr,
            ],
        ),
    ];

    tgSendMessage($data);
}
function tgKeyboardRemove()
{
    $query = [
        'chat_id' => TG_USER_ID,
        'text' => 'Клавиатура убрана...',
        'reply_markup' => json_encode([
            'remove_keyboard' => true
        ]),
    ];
    tgSendMessage($query);
}

// Кнопки под сообщением
function getDomainInfo($domain)
{
    $request = db_query("SELECT * FROM `domain` WHERE `domain_name` LIKE '$domain'")->fetch();

    $string = "<b>Проект</b>: " . $request["domain_name"] . "\n";
    $string .= "<b>Админка</b>: " . $request["domain_url"] . "\n";
    $string .= "<b>Логин</b>: " . $request["wp_login"] . "\n";
    $string .= "<b>Пароль</b>: " . $request["wp_password"] . "\n";
    $string .= "<b>Имя БД</b>: " . $request["bd_name"] . "\n";
    $string .= "<b>Юзер БД</b>: " . $request["bd_user"] . "\n";
    $string .= "<b>Пароль БД</b>: " . $request["bd_password"];

    return $string;
}
