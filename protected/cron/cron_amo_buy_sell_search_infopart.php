<?php
/**
 * Крон -    Возвращает предложение (товар) от сторонних ресурсов (AMO), страница IhfoPart
 */

error_reporting(E_ALL | E_STRICT);

/*

				// лог ссылок
					$file = $_SERVER['DOCUMENT_ROOT'] .'/cron30.txt';
					$fp = fopen($file, "a");
					$mytext = date("Y-m-d H:i:s")." \r\n ";
					$test = fwrite($fp, $mytext);
					fclose($fp);		
				///	
*/


$sql = "	SELECT c.id, c.token, c.searchid, c.categories_id, c.company_id_out, c.cookie_session
				FROM cron_amo_buy_sell_search_infopart c ";

$row = PreExecSQL_all($sql, array());

echo "Rows: ".count($row);

foreach ($row as $k => $m) {
    echo ".";


    // Получаем и сохраняем в buy_sell данные от сторонних ресурсов
    $arr = $qrq->QrqInsertBuySell(array('where' => 'infopart',
        'token' => $m['token'],
        'searchid' => $m['searchid'],
        'categories_id' => $m['categories_id'],
        'company_id_out' => $m['company_id_out'],
        'cookie_session' => $m['cookie_session']
    ));


    if (!$arr['finished']) {
        $STH = PreExecSQL(" DELETE FROM cron_amo_buy_sell_search_infopart WHERE id=?; ",
            array($m['id']));
    }


//				sleep(5);
}


?>