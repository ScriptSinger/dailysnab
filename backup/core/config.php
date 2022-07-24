<?php
/**
 * Переменные среды
 */

define('DEBUG', true);// флаг - разработка

//ID авторизованного пользователя
if(isset($_SESSION['login_id'])) define('LOGIN_ID', $_SESSION['login_id']); else define('LOGIN_ID', 0);	

//ID аккаунта (компании)
if(isset($_SESSION['company_id'])) define('COMPANY_ID', $_SESSION['company_id']); else define('COMPANY_ID', 0);	

// аккаунт или компания
if(isset($_SESSION['flag_account'])) define('FLAG_ACCOUNT', $_SESSION['flag_account']); else define('FLAG_ACCOUNT', false);

// Pro режим
if(isset($_SESSION['pro_mode'])&&$_SESSION['pro_mode']==1) define('PRO_MODE', true); else define('PRO_MODE', false);

// ID 1c компании , ифентификатор 1с
if(isset($_SESSION['company_id_1c'])) define('COMPANY_ID_1C', $_SESSION['company_id_1c']); else define('COMPANY_ID_1C', 0);	

// авторизация со стороннем ресуром
if(isset($_SESSION['AMO_TOKEN'])) define('AMO_TOKEN', $_SESSION['AMO_TOKEN']); else define('AMO_TOKEN', false);	


// Подключение Номенклатуры (доступность сервиса)
//if(PRO_MODE) define('NOMENCLATURE', true); else define('NOMENCLATURE', false);

//Права в системе
if(isset($_SESSION['prava'][1])) define('PRAVA_1', true); else define('PRAVA_1', false);// Администрирование
if(isset($_SESSION['prava'][2])) define('PRAVA_2', true); else define('PRAVA_2', false);// Пользователь
if(isset($_SESSION['prava'][3])) define('PRAVA_3', true); else define('PRAVA_3', false);// Исполнитель
if(isset($_SESSION['prava'][4])) define('PRAVA_4', true); else define('PRAVA_4', false);// Заказчик (видит компании и цены)
if(isset($_SESSION['prava'][5])) define('PRAVA_5', true); else define('PRAVA_5', false);// Заказчик (не видит компании и цены)


date_default_timezone_set('Asia/Yekaterinburg');


//флаг AJAX запроса
if((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') || ($_SERVER['REQUEST_METHOD'] == 'POST') ) define('AJAX', true);
else define('AJAX', false); //флаг AJAX запроса

//Ошибки
if(DEBUG){
	error_reporting( E_ALL | E_STRICT );
	ini_set('html_errors', 1);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	ini_set('error_prepend_string', '<div id="php-error" class="php-error">');	
//	ini_set('error_prepend_string', '<div id="php-error"><span class="pull-right clickable close-icon"><i class="fa fa-times"></i></span>');
	ini_set('error_append_string', '</div>');	


	if(AJAX){
		ini_set('html_errors', 0);
		ini_set('error_prepend_string', '');
		ini_set('error_append_string', '');
	}
	ini_set('log_errors', 1);
}
else{// Пишим в файл
	error_reporting( E_ALL | E_STRICT );
	ini_set('html_errors', 1);
	ini_set('display_errors',0);
	ini_set('display_startup_errors', 0);
	ini_set('ignore_repeated_errors',1);
	ini_set('log_errors', 1);
	ini_set('error_log', $_SERVER['DOCUMENT_ROOT'].'/PHP_errors.log');
}


define('DOMEN' , 'https://questrequest.ru');// Домен

define('MD5' , 'dai');// md5 - префикс для кодировки


define('reCAPTCHA_SITEKEY' , '6LdT_OIZAAAAABv_JE1A4PyEZpvtNz5Cj94blik3');// reCAPTCHA v2 - SITEKEY
define('reCAPTCHA_SECRETKEY' , '6LdT_OIZAAAAALw8DgpDP9mx2Qzkoiuih01uoXie');// // reCAPTCHA v2 - SECRETKEY

define('SMSRU_TEST' , false); // sms.ru:  true - тестовый режим, false - боевой
define('SMSRU_API_ID' , '7CC6E69B-07DB-261D-EB11-041DBFEA7427'); // sms.ru - api_id

define('DADATA_API' , 'd55a4e93a57b806f2818a1b347358904225e2051'); // dadata.ru - api
define('DADATA_SECRET' , '515a740370ba602b1e4976a648ff2c7bf50e7bbb'); // dadata.ru - secret

define('PRICE_PRO' , '3990'); // Цена пакета Pro
define('PRICE_VIP' , '51000'); // Цена пакета Vip

define('YOOKASSA_API' , 'test_Xv_daiRVyfLilL9IAhlr6Ji0G2FP1HIRlKz4e91XFrA'); // секретный ключ YOOKASSA 
define('YOOKASSA_SHOPID' , '519687'); // ShopId YOOKASSA

define('EMPTY_IMG_AVATAR' , '/images/profile.png'); // путь до пустой Аватарки/Логотипа


define('FILES_PATH' , '/files/');//путь до изображения пользователя
define('FILES_ROOT_PATH' , $_SERVER['DOCUMENT_ROOT'].'/files/');//полный путь до изображения пользователя

					
									
define('CORE_PATH', './protected/core/');				//путь до ядра
define('VIEWS', './protected/views/');					//путь до вьюшек
define('CRON', './protected/cron/');					//путь до cron


?>
