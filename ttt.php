<?php
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

$r = PreExecSQL_all('SELECT * FROM amo_log_json ORDER BY id DESC LIMIT 20');
var_dump($r);

$r = PreExecSQL_all('SELECT * FROM cron_amo_buy_sell_search_infopart');
var_dump($r);

$r = PreExecSQL_all('SELECT * FROM buy_sell ORDER BY id DESC LIMIT 1');
var_dump($r);
die;

/**
 * Крон - 	Возвращает предложение (товар) от сторонних ресурсов (AMO), страница IhfoPart
 */
 
 error_reporting( E_ALL | E_STRICT );

/*

				// лог ссылок
					$file = $_SERVER['DOCUMENT_ROOT'] .'/cron30.txt';
					$fp = fopen($file, "a");
					$mytext = date("Y-m-d H:i:s")." \r\n ";
					$test = fwrite($fp, $mytext);
					fclose($fp);		
				///	
*/

$start = time();
$lockFile = false;
$logFilePath = __FILE__ . '.log';

PreExecSQL(" DELETE FROM cron_amo_buy_sell_search_infopart WHERE finished < FROM_UNIXTIME(UNIX_TIMESTAMP() - 60); ", []);

while (time() - $start < 60) {
    //if (!$lockFile) {
        //$lockFile = fopen(__FILE__ . '.lock', 'w');
        //usleep(200000);
        //continue;
    //}
//
    //if (flock($lockFile, LOCK_EX)) {
		$sql = "	SELECT c.id, c.token, c.searchid, c.categories_id, c.company_id_out, c.cookie_session
				FROM cron_amo_buy_sell_search_infopart c 
                WHERE finished IS NULL ";

		$row = PreExecSQL_all($sql,array());

		foreach($row as $k=>$m){
            var_dump($k, $m);
				// Получаем и сохраняем в buy_sell данные от сторонних ресурсов
				$arr = $qrq->QrqInsertBuySell(array(	'where'			=> 'infopart',
													'token'			=> $m['token'],
													'searchid'		=> $m['searchid'],
													'categories_id'	=> $m['categories_id'],
													'company_id_out'=> $m['company_id_out'],
													'cookie_session'=> $m['cookie_session']
													));	
                var_dump($arr);
				
				if(!$arr['finished']){				
					$STH = PreExecSQL(" UPDATE cron_amo_buy_sell_search_infopart SET finished = NOW() WHERE id=?; " ,
										array( $m['id'] ));		
                    var_dump("Finish $m[id]");
				}

				usleep(200000);
		}

        //flock($lockFile, LOCK_UN);
    //}
//
    usleep(200000);
}
