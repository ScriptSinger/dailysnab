<?php

if ($_SERVER['REMOTE_ADDR'] !== '5.18.234.111') {
    http_response_code(404);
    die;
}

require_once './protected/core/config.php';				// Настройки ядра
require_once './protected/core/functions.php';			// Функции/классы
require_once './protected/core/connect.php';			// Соединение с БД, Функции запросов

ini_set('display_errors', 1);

echo '<pre>';
//passthru('ps aux');
var_dump(PreExecSQL_all('DESCRIBE cron_amo_buy_sell_search_infopart', []));
//var_dump(PreExecSQL('ALTER TABLE cron_amo_buy_sell_search_infopart ADD COLUMN finished TINYINT NOT NULL DEFAULT 0', []));
var_dump(PreExecSQL_all('SELECT * FROM cron_amo_buy_sell_search_infopart', []));
var_dump(PreExecSQL_all('SELECT CURRENT_TIMESTAMP(), FROM_UNIXTIME(UNIX_TIMESTAMP() - 60)', []));
echo '</pre>';

//$f = fopen(__FILE__ . '.lock', 'w');
//
//if (flock($f, LOCK_EX | LOCK_NB)) {
    //echo 'Lock';
    //sleep(10);
    //flock($f, LOCK_UN);
//} else {
    //echo 'No';
//}
//
//fclose($f);
