<?php
/**
 * Крон - Удаляет объявления(предложение) пользователей полученных черех ЭТП (AMO)
 */
 
  error_reporting( E_ALL | E_STRICT );
 

	// Очищаем старые полученные данные
		$sql = " SELECT buy_sell_id
				FROM buy_sell_etp_sell be
				WHERE data_insert <= DATE_SUB(NOW(),INTERVAL 1 HOUR) ";

		$row = PreExecSQL_all($sql,array());
		
		foreach($row as $i => $m){
			$sql = "	DELETE FROM buy_sell WHERE id=? ";

			$STH = PreExecSQL($sql,array($m['buy_sell_id']));
		}
	///
	
?>