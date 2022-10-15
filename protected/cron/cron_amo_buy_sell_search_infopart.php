<?php
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

PreExecSQL(" DELETE FROM cron_amo_buy_sell_search_infopart WHERE data_insert < FROM_UNIXTIME(UNIX_TIMESTAMP() - 60); ", []);

while (time() - $start < 60) {
    if (!$lockFile) {
        $lockFile = fopen(__FILE__ . '.lock', 'w');
        usleep(400000);
        continue;
    }

    if (flock($lockFile, LOCK_EX)) {
		$sql = "	SELECT c.id, c.token, c.searchid, c.categories_id, c.company_id_out, c.cookie_session
				FROM cron_amo_buy_sell_search_infopart c ";

		$row = PreExecSQL_all($sql,array());

		foreach($row as $k=>$m){


				// Получаем и сохраняем в buy_sell данные от сторонних ресурсов
				$arr = $qrq->QrqInsertBuySell(array(	'where'			=> 'infopart',
													'token'			=> $m['token'],
													'searchid'		=> $m['searchid'],
													'categories_id'	=> $m['categories_id'],
													'company_id_out'=> $m['company_id_out'],
													'cookie_session'=> $m['cookie_session']
													));				
				
				usleep(100000);
		}

        flock($lockFile, LOCK_UN);
    }

    usleep(200000);
}

if ($lockFile) {
    fclose($lockFile);
}
										

?>