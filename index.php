<?php

session_start();


require_once './protected/core/config.php';				// Настройки ядра
require_once './protected/core/functions.php';			// Функции/классы
require_once './protected/core/connect.php';			// Соединение с БД, Функции запросов
require_once './protected/core/Requests.php';			// Функции вспомогательных SQL-запросов

require_once './protected/core/class_htmlelement.php';	// класс html элементов
require_once './protected/core/class_service.php';		// класс настроек
require_once './protected/core/class_template.php';		// класс шаблонов
require_once './protected/core/class_forms.php';		// класс форм и элементов форм
require_once './protected/core/class_template_email_sms.php';
require_once './protected/core/class_buysell.php';		// класс действия представления с Заявкой/Предложением/Объявлением
require_once './protected/core/class_notification.php';	// Оповещения/Уведомления
require_once './protected/core/class_qrq.php';			// Захват со стороних ресурсов
require_once './protected/core/class_api.php';			// Захват со стороних ресурсов

// phpmailer
require_once './protected/source/phpmailer/class.phpmailer.php';	// phpmailer отправка писем smtp
require_once './protected/source/phpmailer/class.pop3.php';			// phpmailer отправка писем smtp
require_once './protected/source/phpmailer/class.smtp.php';			// phpmailer отправка писем smtp


$e		= new HtmlElement();
$g		= new HtmlServive();
$t		= new HtmlTemplate();
$f		= new HtmlForms();
$tes		= new HtmlTemplateEmailSms();
$bs		= new HtmlBuySell();
$cn		= new ClassNotification();
$qrq		= new ClassQrq();
$api		= new ClassApi();


argsRoute();// преобразование route

//vecho($_SESSION);


if(getArgs(0)=='cron'){// задания крон
	
		$key = getArgs(1);
		$path = CRON.$key.'.php';
		if( file_exists($path) ){
			require $path;
		}
		
}else{

		$g->CookieSession();//создаем cookie с идентификатором сессии

		if( AJAX ) {
			require './protected/core/ajax.php';
		}
		else require './protected/views/index.php';

}

disConnect();

?>
