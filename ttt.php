<?php
require_once './protected/core/config.php';				// Настройки ядра
require_once './protected/core/functions.php';			// Функции/классы
require_once './protected/core/connect.php';			// Соединение с БД, Функции запросов
require_once './protected/core/Requests.php';			// Функции вспомогательных SQL-запросов

$r = PreExecSQL_all('SELECT * FROM amo_log_json ORDER BY id DESC LIMIT 1');
var_dump($r);
