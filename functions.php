<?php
require 'config.php';

function getListDomains($connect)
{
    $request = mysqli_query($connect, "SELECT `domain_name` FROM `domain`");
    $result = mysqli_fetch_all($request);
    $list = [];
    foreach ($result as $item) {
        $list[] = $item[0];
    }
    return $list;
}
function getDomainInfo($connect, $domain)
{
    $request = mysqli_query($connect, "SELECT * FROM `domain` WHERE `domain_name` LIKE '$domain'");
    $result = mysqli_fetch_assoc($request);

    $string = "<b>Проект</b>: " . $result["domain_name"] . "\n";
    $string .= "<b>Админка</b>: " . $result["domain_url"] . "\n";
    $string .= "<b>Логин</b>: " . $result["wp_login"] . "\n";
    $string .= "<b>Пароль</b>: " . $result["wp_password"] . "\n";
    $string .= "<b>Имя БД</b>: " . $result["bd_name"] . "\n";
    $string .= "<b>Юзер БД</b>: " . $result["bd_user"] . "\n";
    $string .= "<b>Пароль БД</b>: " . $result["bd_password"];

    return $string;
}

function tgKeybordDomains($db_connect)
{
    $list = getListDomains($db_connect);
    $arr = [];

    foreach ($list as $item) {
        $arr[] = [
            'text' => $item,
            'callback_data' => strtolower($item),
        ];
    }
    return $arr;
}

function tgSendMessage($query)
{
    $ch = curl_init('https://api.telegram.org/bot' . TG_TOKEN . '/sendMessage?' . http_build_query($query));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $result = curl_exec($ch);
    curl_close($ch);

    // $jsonDate = json_decode($result, true);
    // var_dump($jsonDate);
}
