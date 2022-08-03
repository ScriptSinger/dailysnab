<?php
/**
 * Крон - 	каждую минуту проверяет есть ли новая заявка и отправляет пользователям (от их последней даты визита на странице "заявки")
			Не отправляет если пользователь не был на странице "заявки", после последней отправки.
			Если пользователь не был более сутки на странице "заявки", то шлет при новой заявки письмо. 
 */
 
	// новые заявки (добавляются в таблицу "cron_new_buysell" при первой опубликации/активации)
	$sql = "	SELECT c.id, c.buy_sell_id, bs.company_id, bs.urgency_id, bs.data_status_buy_sell_23
			FROM cron_new_buysell c, buy_sell bs
			WHERE c.buy_sell_id=bs.id ";

	$row = PreExecSQL_all($sql,array());

	foreach($row as $k=>$m){

			$sql = "	SELECT 	pvs.id, pvs.company_id,
							TIMESTAMPDIFF(SECOND,pvs.data_last_send_email,NOW()) flag_data_last_send_email, /* 86400 - одни сутки */
							(SELECT email FROM login l WHERE l.id=pvs.login_id) email,
							c.company,
							n1.notification_param_id notification_param_id_10,
							n2.notification_param_id notification_param_id_11
					FROM company c, company_page_visited_send pvs
					LEFT JOIN notification_company_param n1 ON n1.flag=2 AND n1.login_id=pvs.login_id AND n1.company_id=pvs.company_id AND n1.notification_id=10
					LEFT JOIN notification_company_param n2 ON n2.flag=2 AND n2.login_id=pvs.login_id AND n2.company_id=pvs.company_id AND n2.notification_id=11
					WHERE c.id=pvs.company_id AND pvs.page_id=1 
							AND c.id<>".$m['company_id']."
							AND c.active=1
							AND c.flag_account=1
							AND (SELECT email FROM login l WHERE l.id=pvs.login_id) LIKE '%@%'
							AND ( 
								(TIMESTAMPDIFF(SECOND,pvs.data_last_send_email,NOW())) IS NULL
								OR
								(TIMESTAMPDIFF(SECOND,pvs.data_last_send_email,NOW())>86400)
							
							)
							/*
							AND pvs.data_visited<'".$m['data_status_buy_sell_23']."'
							*/  
				";

			$row2 = PreExecSQL_all($sql,array());

			foreach($row2 as $k=>$mm){
				$rez =   'uslovie 0 (interesi)';
				// проверяем компания удавлетворяет "Интересу"
				$sql = "	SELECT bs.id FROM buy_sell bs
						WHERE bs.id=".$m['buy_sell_id']."
								 AND (	bs.status_buy_sell_id IN (3)
											OR ( bs.status_buy_sell_id IN (2) AND bs.company_id IN ( SELECT t.company_id_out FROM subscriptions t WHERE t.company_id_in=".$mm['company_id']." ) ) 
										)
								".$g->SqlCompanyInterests(array('company_id'=>$mm['company_id']))." ";
				$row3 = PreExecSQL_one($sql,array());
				
//echo $mm['company_id'].'***'.$sql.'<br/><br/>';

				if($row3['id']){
					$rez =   'uslovie 1 (uslovie polucheniya)';
					// пользователь указал получать "все заявки" или только "срочные"
					if( (!$mm['notification_param_id_10']||$mm['notification_param_id_10']==1)  || ($m['urgency_id']==1&&(!$mm['notification_param_id_11']||$mm['notification_param_id_11']==1)) ){
							$rez =   'uslovie 2 (sutki ne proshli) ';
							
							if(empty($mm['flag_data_last_send_email'])||$mm['flag_data_last_send_email']>86400){// прошли сутки с последнего уведомления или уведомление не отправлялось (или был на странице "заявки")
									
									$rez =   'uslovie 3 (tehnicheskiy sboy otpravki) ';

									if( $mm['notification_param_id_10']==3 && $m['urgency_id']==1 && (!$mm['notification_param_id_11']||$mm['notification_param_id_11']==1)){// шаблон id=11
										$notification_id = 11;
									}else{
										$notification_id = 10;
									}
									
									//$mm['email'] = 'vdo81@yandex.ru';
									$arr['rez'] = '';
									
									sleep(2);
									$validate_email = (filter_var($mm['email'], FILTER_VALIDATE_EMAIL));
									if($validate_email){
										$arr = $tes->LetterSendNotification(array('notification_id'			=> $notification_id,
																				'email'						=> $mm['email'],
																				'name'						=> $mm['company'] ));
									}
									
									if($arr['rez']){
											// обновляем дату последней отправки (она очищается при посещении пользователем страници "заявки")
											$STH = PreExecSQL(" UPDATE company_page_visited_send SET data_last_send_email=NOW() WHERE id=?; " ,
																				array( $mm['id']));
											echo $mm['company_id'].'<br/>';
									}
									$rez = ($arr['rez'])? 'send' : 'nosend';
									
							}
							
					}
					
				}
				
				// лог send
					$file = $_SERVER['DOCUMENT_ROOT'] .'/send.txt';
					$fp = fopen($file, "a");
					$mytext = date("Y-m-d H:i:s")." -  buy_sell_id=".$m['buy_sell_id']." - email=".$mm['email']." - ".$rez." \r\n\r\n ";
					$test = fwrite($fp, $mytext);
					fclose($fp);		
				///
					
			}
		
		// удаляем новую заявку из "cron_new_buysell"
			$STH = PreExecSQL(" DELETE FROM cron_new_buysell WHERE id=?; " ,
									array( $m['id']));
		
	}

?>