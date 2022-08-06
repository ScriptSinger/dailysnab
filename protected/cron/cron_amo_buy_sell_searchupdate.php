<?php
/**
 * Крон - 	Возвращает предложение (товар) от сторонних ресурсов по searchid (AMO)
 */
 
 error_reporting( E_ALL | E_STRICT );

	// компании, которым отсылаем отчет(уведомление)
	
	
	/*
	1 цикл, перебор до тех пор пока не будет finished=false
	
	*/
	
			
	$sql = "	SELECT id, buy_sell_id, token, searchid, flag_delete
			FROM cron_amo_buy_sell_searchupdate
			ORDER BY id	";
				
	$row = PreExecSQL_all($sql,array());

	foreach($row as $k=>$m){

			$arr['result'] = true;
			$arr['company_id'] = $arr['buy_sell_id'] = '';
			

			// очищаем рании предложения у текущей заявки
			if(!$m['flag_delete']){
				reqDeleteBuySellByQrqId(array('buy_sell_id'=>$m['buy_sell_id']));
				
			}
			///
			
			// ставим признак чтобы не удалялись предложения в reqDeleteBuySellByQrqId
			$STH = PreExecSQL(" UPDATE cron_amo_buy_sell_searchupdate SET flag_delete=1 WHERE buy_sell_id=?; " ,
											array( $m['buy_sell_id'] ));
			
			

			// Получаем и сохраняем в buy_sell данные от сторонних ресурсов
			$arr = $qrq->QrqInsertBuySell(array(	'buy_sell_id'	=> $m['buy_sell_id'],
												'token'			=> $m['token'],
												'searchid'		=> $m['searchid']
												));

			if(!$arr['finished']){
				
				$STH = PreExecSQL(" DELETE FROM cron_amo_buy_sell_searchupdate WHERE buy_sell_id=?; " ,
											array( $m['buy_sell_id'] ));
											
				if($STH&&$arr['company_id']&&$arr['buy_sell_id']){// добавляем флаг, чтобы обновилось предложения не перегружая страницу ( buy_sell_refresh_amo_search )
						$STH = PreExecSQL(" INSERT INTO buy_sell_refresh_amo_search (company_id,buy_sell_id) VALUES (?,?); " ,
											array( $arr['company_id'],$arr['buy_sell_id'] ));
				}
				
			}
				
			/*							
			//
			if(!$arr['result']){
					$arr['errors_message'] = mb_convert_encoding($arr['errors_message'], 'cp1251');
				// лог ссылок
					$file = $_SERVER['DOCUMENT_ROOT'] .'/qwep.txt';
					$fp = fopen($file, "a");
					$mytext = date("Y-m-d H:i:s")." - searchupdate - ".$arr['errors_message']." \r\n ";
					$test = fwrite($fp, $mytext);
					fclose($fp);		
				///	
			}
			*/
			
	}

?>