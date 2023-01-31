<?php

// Server
define('SITE_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']);

// Debug
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Database
define('DB_HOST', '192.168.1.103');
define('DB_NAME', 'dombot_bd');
define('DB_USER', 'admin');
define('DB_PASS', 'admin');

// TG
define('TG_TOKEN', '5983231976:AAH7BSy3HG-WP5922U0mUXLGRbPK1Uq_xhY');
define('TG_USER_ID', '483212254');

// Connect
$db_connect = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$db_connect) {
    die('Ошибка подключения к базе данных.');
} else {
    echo 'good';
}
