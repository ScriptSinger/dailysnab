<?php
/**
 * Крон - по истечению 30 дней, меняем статус (заявки/объявления) с Опубликованные и Активные на -> Не опубликованные
 */


	$sql = "	SELECT bs.id, bs.company_id, bs.flag_buy_sell, bs.status_buy_sell_id FROM buy_sell bs
			WHERE bs.status_buy_sell_id IN (2,3) AND (TO_DAYS(NOW()) - TO_DAYS(bs.data_status_buy_sell_23) + 1)>30 ";

	$row = PreExecSQL_all($sql,array());

	foreach($row as $k=>$m){
		
			$STH = PreExecSQL(" UPDATE buy_sell SET status_buy_sell_id=?, data_status_buy_sell_23='NULL' WHERE id=?; " ,
									array( 1,$m['id']));
			if($STH){
				$ok = true;
				$bs->SaveCacheBuySell(array('buy_sell_id'=>$m['id'],'flag_buy_sell'=>$m['flag_buy_sell']));
				// Оповещение
				echo $m['id'].'<br/>';
				$cn->StartNotification(array(	'flag'						=> 'buy_sell',
												'tid'						=> $m['id'],
												'company_id'				=> $m['company_id'],
												'status_buy_sell_id'		=> 1,
												'old_status_buy_sell_id' 	=> $m['status_buy_sell_id'],
												'flag_buy_sell'				=> $m['flag_buy_sell'] ));
				
			}
			
	}

?>