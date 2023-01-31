<?php

// Server
define('SITE_URL', 'https://' . $_SERVER['HTTP_HOST']);
define('DEVELOP_URL', 'https://' . (!empty($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : 'error'));

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
