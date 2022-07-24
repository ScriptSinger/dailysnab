<?php
/**
 * Крон - 	Возвращает предложение (товар) от сторонних ресурсов (AMO)
 */
 
 error_reporting( E_ALL | E_STRICT );

	// компании, которым отсылаем отчет(уведомление)
	
	
	/*
	Сделать 2 цикла:
		1 - Только заявка
		2 - По брендам перебор
	
	*/
	
			
	$sql = "	SELECT q.buy_sell_id, bs.company_id
			FROM cron_amo_buy_sell_search q, buy_sell bs
			WHERE bs.id=q.buy_sell_id
			GROUP BY q.buy_sell_id
			ORDER BY q.buy_sell_id  LIMIT 5 ";
				
	$row = PreExecSQL_all($sql,array());

	foreach($row as $k=>$m){

			$arr['result'] = true;
			$arr['company_id'] = $arr['buy_sell_id'] = '';

			// очищаем рании предложения у текущей заявки
				reqDeleteBuySellByQrqId(array('buy_sell_id'=>$m['buy_sell_id'],));
			///
		
			$sql = "	SELECT q.id, q.buy_sell_id, q.token, q.brand, q.searchtext, 
							(
								SELECT GROUP_CONCAT(DISTINCT qw.accounts_id) 
								FROM (
											SELECT (SELECT t.login_id FROM company t WHERE t.id=ae.company_id LIMIT 1) login_id,
													ae.company_id, ae.qrq_id, ae.accounts_id
											FROM slov_qrq sq, amo_accounts_etp ae
											WHERE sq.company_id=ae.company_id AND ae.qrq_id=sq.id AND ae.accounts_id>0 AND sq.promo=1 
											UNION ALL 
											SELECT (SELECT t.login_id FROM company t WHERE t.id=(SELECT t.company_id FROM slov_qrq t WHERE t.id=ae.qrq_id LIMIT 1) LIMIT 1) login_id,
													(SELECT t.company_id FROM slov_qrq t WHERE t.id=ae.qrq_id LIMIT 1) company_id,
													ae.qrq_id,
													CASE WHEN ae.flag_autorize=1 THEN (SELECT t.accounts_id FROM amo_accounts_etp t WHERE t.qrq_id=ae.qrq_id AND t.flag_autorize=3) 
																ELSE ae.accounts_id END accounts_id
											FROM amo_accounts_etp ae
											WHERE ae.company_id=".$m['company_id']."
										) qw
								WHERE qw.accounts_id>0
							) accounts_ids
					FROM cron_amo_buy_sell_search q
					WHERE q.buy_sell_id=".$m['buy_sell_id']."
					ORDER BY q.buy_sell_id ";

			$row2 = PreExecSQL_all($sql,array());

			foreach($row2 as $k2=>$m2){

					sleep(5);

					// Получаем и сохраняем в buy_sell данные от сторонних ресурсов
					$arr = $qrq->QrqInsertBuySell(array('buy_sell_id'	=> $m2['buy_sell_id'],
														'token'			=> $m2['token'],
														'brand'			=> $m2['brand'],
														'searchtext'	=> $m2['searchtext'],
														'accountid'		=> $m2['accounts_ids']
														));
														
			}
			
			
			$STH = PreExecSQL(" DELETE FROM cron_amo_buy_sell_search WHERE buy_sell_id=?; " ,
										array( $m['buy_sell_id'] ));
										
			if($STH&&$arr['company_id']&&$arr['buy_sell_id']){// добавляем флаг, чтобы обновилось предложения не перегружая страницу ( buy_sell_refresh_amo_search )
					$STH = PreExecSQL(" INSERT INTO buy_sell_refresh_amo_search (company_id,buy_sell_id) VALUES (?,?); " ,
										array( $arr['company_id'],$arr['buy_sell_id'] ));
			}
			
										
			// удаляем из cron
			if(!$arr['result']){
					$arr['errors_message'] = mb_convert_encoding($arr['errors_message'], 'cp1251');
				// лог ссылок
					$file = $_SERVER['DOCUMENT_ROOT'] .'/qwep.txt';
					$fp = fopen($file, "a");
					$mytext = date("Y-m-d H:i:s")." - search - ".$arr['errors_message']." \r\n ";
					$test = fwrite($fp, $mytext);
					fclose($fp);		
				///	
			}

			
	}

?>