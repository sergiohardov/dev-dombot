<?php

$getQuery = array(
    "url" => "https://dombot.thelookway.com/index.php",
);
$ch = curl_init("https://api.telegram.org/bot" . TG_TOKEN . "/setWebhook?" . http_build_query($getQuery)); // Добавить хук
// $ch = curl_init("https://api.telegram.org/bot" . TG_TOKEN . "/deleteWebhook?" . http_build_query($getQuery)); // Удалить хук

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);

$resultQuery = curl_exec($ch);
curl_close($ch);

echo $resultQuery;
