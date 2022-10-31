<?php
/**
 * Крон - 	Закэшировать мои заявки/объявления из таблицы buy_sel
 */
	$code = '';

	// по n запись в цикл, исключаем ранее обработанные
	$sql = "	SELECT bs.id, bs.flag_buy_sell 
			FROM buy_sell bs
			WHERE bs.status_buy_sell_id IN (1,2,3,4,11,12,14,15)
					/*AND bs.login_id=565*/
					AND bs.company_id>0 AND bs.login_id>0 AND bs.categories_id>0
					AND NOT bs.id IN ( SELECT t.buy_sell_id FROM buy_sell_cache t )
			ORDER BY bs.id DESC LIMIT  50  ";

	$row = PreExecSQL_all($sql,array());

	foreach($row as $k=>$m){

			$bs->SaveCacheBuySell(array('buy_sell_id'=>$m['id'],'flag_buy_sell'=>$m['flag_buy_sell']));
			//echo $m['id'].'<br/>';

	}

?>