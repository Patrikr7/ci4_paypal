<?php

// BANCO DE DADOS
defined('HOSTNAME') || define('HOSTNAME', 'localhost');
defined('USERNAME') || define('USERNAME', 'root');
defined('PASSWORD') || define('PASSWORD', 'senac');
defined('DATABASE') || define('DATABASE', 'ci4_paypal');


defined('BASE_URL') || define('BASE_URL', (!empty($_SERVER['HTTPS']) ? 'https://' . preg_replace('/index.php.*/', '', $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME']) : 'http://' . preg_replace('/index.php.*/', '', $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'])));

// DADOS PAYPAL
defined('PAYPAL_CLIENT_ID') || define('PAYPAL_CLIENT_ID', 'seu_client_id');
defined('PAYPAL_SECRET') || define('PAYPAL_SECRET', 'seu_secret');