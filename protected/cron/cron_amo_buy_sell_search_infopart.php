<?php
/**
 * Крон - 	Возвращает предложение (товар) от сторонних ресурсов (AMO), страница IhfoPart
 */
 
 error_reporting( E_ALL | E_STRICT );


				
		$sql = "	SELECT c.id, c.token, c.brand, c.searchtext, c.accountid, c.login_id, c.company_id, c.qrq_id, 
						c.categories_id, c.company_id_out, c.cookie_session
				FROM cron_amo_buy_sell_search_infopart c ";

		$row = PreExecSQL_all($sql,array());

		foreach($row as $k=>$m){

				sleep(5);

				// Получаем и сохраняем в buy_sell данные от сторонних ресурсов
				$arr = $qrq->getSellByAmoAccountsEtp(array(	'token'			=> $m['token'],
															'brand'			=> $m['brand'],
															'searchtext'	=> $m['searchtext'],
															'accountid'		=> $m['accountid'],
															'login_id'		=> $m['login_id'],
															'company_id'	=> $m['company_id'],
															'categories_id'	=> $m['categories_id'],
															'qrq_id'		=> $m['qrq_id'],
															'company_id_out'=> $m['company_id_out'],
															'cookie_session'=> $m['cookie_session']
															));
															
				$STH = PreExecSQL(" DELETE FROM cron_amo_buy_sell_search_infopart WHERE id=?; " ,
									array( $m['id'] ));										

		}


		
										

?>