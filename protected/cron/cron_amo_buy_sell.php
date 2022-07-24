<?php
/**
 * Крон - 	Возвращает ответ от сторонних ресурсов (AMO)
 */
 
  error_reporting( E_ALL | E_STRICT );
 

	// 
	$sql = "	SELECT c.id, c.buy_sell_id, c.token, CASE WHEN bsa.value<>'' THEN CASE WHEN POSITION('/' IN bsa.value)>0 THEN SUBSTRING(bsa.value,1,POSITION('/' IN bsa.value)-1) ELSE bsa.value END
														ELSE bs.name END artname
			FROM cron_amo_buy_sell c, buy_sell bs
			LEFT JOIN buy_sell_attribute bsa ON bsa.buy_sell_id=bs.id AND bsa.attribute_id=33
			WHERE c.buy_sell_id=bs.id
			ORDER BY c.data_insert ";

	$row = PreExecSQL_all($sql,array());

	foreach($row as $k=>$m){

			// qrq_id - slov_qrq
			$row_bs = reqBuySell_Amo(array('id' => $m['buy_sell_id']));

			echo $m['buy_sell_id'].'<br/>';

			$arr = $qrq->AmoHtmlSearchbrend(array(	'flag'			=> 1,
													'row_bs'		=> $row_bs,
													'token'			=> $m['token'],
													'artname'		=> $m['artname']
													));
		
			$STH = PreExecSQL(" DELETE FROM cron_amo_buy_sell WHERE id=?; " ,
										array( $m['id'] ));

			// удаляем из cron
			if(!$arr['result']){
					$arr['errors_message'] = mb_convert_encoding($arr['errors_message'], 'cp1251');
				// лог ссылок
					$file = $_SERVER['DOCUMENT_ROOT'] .'/qwep.txt';
					$fp = fopen($file, "a");
					$mytext = date("Y-m-d H:i:s")." - brend - ".$arr['errors_message']." \r\n ";
					$test = fwrite($fp, $mytext);
					fclose($fp);		
				///	
			}
	}
	
	
/*	
			// лог ссылок
				$file = $_SERVER['DOCUMENT_ROOT'] .'/cron.txt';
				$fp = fopen($file, "a");
				$mytext = date("Y-m-d H:i:s")." -  ok1 \r\n ";
				$test = fwrite($fp, $mytext);
				fclose($fp);		
			///
*/
?>