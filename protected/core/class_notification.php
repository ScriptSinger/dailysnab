<?php
	/*
	 *  Оповещения
	 */
	 
class ClassNotification extends HtmlTemplateEmailSms
{	

	// Оповещение (проверяем, формируем, отправляем)
	function StartNotification( $p=array() ){
		
		$in = fieldIn($p, array('flag','notification_id','status_buy_sell_id','tid','parent_id','company_id','company_id2',
							'flag_buy_sell','old_status_buy_sell_id','flag_sam'));
																			// flag_sam - признак не отправлять самому себе
		
		$notification_id = $company_id = $page_id = '';

		// Оповещение связанное с Заявками/Объявлениями
		if($in['flag']=='buy_sell'){
			
				// оповещение при "НЕ опубликованные" CRON
				if($in['status_buy_sell_id']==1){
					
						if($in['flag_buy_sell']==1){
							$notification_id	= 8;
							$page_id		= 4;// id - slov_page
						}elseif($in['flag_buy_sell']==2){
							$notification_id	= 3;
							$page_id		= 3;// id - slov_page
						}
						
						$company_id = $in['company_id'];

				}
				// оповещение при "ПРЕДЛОЖЕНИЕ"
				elseif($in['status_buy_sell_id']==10){
						$notification_id	= 2;
						$page_id		= 2;
						
						$row_bs = reqBuySell(array('id'=>$in['parent_id']));
						$company_id = $row_bs['company_id'];

				}
				// оповещение при "КУПИТЬ"
				elseif($in['status_buy_sell_id']==11){
						
						$notification_id	= 5;
						$page_id		= 5;
						$company_id 	= $in['company_id2'];
						
				}
				// оповещение при "ИСПОЛНЕНИИ"
				elseif($in['status_buy_sell_id']==12){
						
						$notification_id	= 7;
						$page_id		= 6;
						$company_id 	= $in['company_id2'];
						
				}
				// оповещение при "ВОЗВРАТ"
				elseif($in['status_buy_sell_id']==14){
						
						$notification_id	= 6;
						$page_id		= 7;
						$company_id 	= $in['company_id2'];
						
				}				
			
		}
		// Оповещение связанное с Подписка
		elseif($in['flag']=='subscriptions'){
				
				//$r = reqNotification(array('notification_id'=>$in['notification_id'],'company_id'=>$in['company_id'],'tid'=>$in['tid']));
				//if(empty($r)){
					$company_id 	= $in['company_id'];
					$notification_id	= $in['notification_id'];
					$page_id		= 8;
				//}
			
		}
		
		
		
		
		if($notification_id&&$company_id){
			
			// Выбираем ВСЕХ сотрудников компании для Оповещения
			$row = reqLoginCompanyPravaByNotification(array('company_id'=>$company_id,'flag_sam'=>$in['flag_sam']));
			foreach($row as $i => $m){
				
				$flag_send = true;// по умолчанию
				
				// проверяем условия интересов у сотрудника (оповещать или не оповещать)
				if($in['flag']=='buy_sell'){
					
					// проверяем это сотрудник или владелец компании
					$rp = reqMyBuySell_ProverkaInvite(array('login_id'=>$m['login_id'],'company_id'=>$m['company_id'] ));
					$flag_interests_invite = (!empty($rp))? true : false;
					
					$rbs = reqMyBuySellCache(array(	'id'					=> $in['tid'],
													'flag_interests_invite' => $flag_interests_invite,
													'login_id_interests'	=> $m['login_id'],
													'company_id_interests'	=> $m['company_id'] ));
					$flag_send = !empty($rbs)? true : false;
				}
				///
			
				//vecho($flag_send.'*'.$m['login_id']);
			
				if($flag_send){
							
							$r = reqSlovNotification(array(	'id'		=> $notification_id,
															'login_id'	=> $m['login_id'],
															'company_id'=> $m['company_id'],
															'page_id'	=> $page_id ));// Настройки оповещения пользователя
							
							// разрешено уведомление на "сайте"
								if(!$r['notification_param_id1']||$r['notification_param_id1']==1){
										reqInsertNotification(array('notification_id'	=> $notification_id,
																	'login_id'			=> $m['login_id'],
																	'company_id'		=> $m['company_id'],
																	'tid'				=> $in['tid'] ));
								}
							// разрешено уведомление на "email" в момент события
								if(!$r['notification_param_id2']||$r['notification_param_id2']==1){
									//
									if(empty($r['flag_data_last_send_email'])||$r['flag_data_last_send_email']>86400){// прошли сутки с последнего уведомления или уведомление не отправлялось (или был на странице)
										
											if($page_id){// отмечаем отправку компании письма, чтобы не отправлять второй раз (при менее суток - 86400)
												self::FixCompanyPageVisitedSend(array(	'page_id'				=> $page_id,
																						'login_id'				=> $m['login_id'],
																						'company_id'			=> $m['company_id'],
																						'data_last_send_email'	=> 'NOW()' ));
											}
									
											//$m['email'] = 'vdo81@yandex.ru';
											$validate_email = (filter_var($mm['email'], FILTER_VALIDATE_EMAIL));
											if($validate_email){
												$this->LetterSendNotification(array(	'notification_id'			=> $notification_id,
																					'tid'						=> $in['tid'],
																					'email'						=> $m['email'],
																					'login_id'					=> $m['login_id'],
																					'company_id'				=> $m['company_id'],
																					'name'						=> $m['name_account'],
																					'flag_buy_sell'				=> $in['flag_buy_sell'],
																					'old_status_buy_sell_id'	=> $in['old_status_buy_sell_id'] ));
											}
									}
									
								}
							
				}
						
			}
					
		}
		
		
		return array('rez'=>'');
	}


	// фиксируем последнее посещение 
	function FixCompanyPageVisitedSend( $p=array() ){
			$p['login_id']					= isset($p['login_id'])? 					$p['login_id']					: 0;
			$p['company_id']				= isset($p['company_id'])? 					$p['company_id']				: 0;
			$p['data_visited']				= isset($p['data_visited'])? 				$p['data_visited']				: 'NULL';
			$p['data_last_send_email'] 		= isset($p['data_last_send_email'])? 		$p['data_last_send_email']	 	: 'NULL';
				
			reqDeleteCompanyPageVisitedSend(array(	'page_id'		=> $p['page_id'],
													'login_id'		=> $p['login_id'],
													'company_id'	=> $p['company_id'] ));
			
			reqInsertCompanyPageVisitedSend(array(	'page_id'				=> $p['page_id'],
													'login_id'				=> $p['login_id'],
													'company_id'			=> $p['company_id'],
													'data_visited'			=> $p['data_visited'],
													'data_last_send_email'	=> $p['data_last_send_email'] ));

		return '';
	}
	
	// модальное окно информации о новых заказ, привязанных к 1с номенклатуре и контрагентов
	function ModalLogoNotification( $p=array() ){
		
		$qrq		= new ClassQrq();
		
		$code = '';
		$arr_tr = array();
		// оповещение о новых заявказ
		$kol_notification = reqNotificationMenu(array('id'=>1011));
		if($kol_notification){
			$code .= '	<div>
							Появилось '.$kol_notification.' заявок соответствующих вашим интересам
						</div>
						<a href="/buy?interests=true" class="profile-btn request-btn" target="_blank">Перейти</a>
						'.$this->Input(array(	'type'			=> 'button',
											'class'			=> 'profile-btn request-btn',
											'value'			=> 'пропустить',
											'data'			=> array('id'=>0)
										));
		}
		
		// оповещение о не привязанной номенклатуры 1с и не привязанном контрагенте
		$dostup_vip = false;
		if(PRO_MODE){
			$r_vip = reqCompanyVipFunction(array('company_id'=>COMPANY_ID,'vip_function_id'=>1,'one'=>true)); // включена ли функция работы с 1С
			if(!empty($r_vip)){
					$dostup_vip = true;
			}
		}
				
				$r = reqNo_1c_NomenclatureCompanyCategories();
				$tr = '';
				foreach($r as $i => $m){
					
					if($dostup_vip){
						// не привязанные номенклатуры к 1с (только купленные)
						if($m['flag']==1){
								$create_1c_nomenclature = (!$m['1c_nomenclature_out'])? $this->Input(array(	'type'			=> 'button',
																										'id'			=> 'create_1c_nomenclature'.$m['id'].'',
																										'class'			=> 'profile-btn request-btn create_1c_nomenclature',
																										'value'			=> 'Создать в 1С',
																										'data'			=> array('id'=>$m['id'])
																									)) : '';
								
								$tr .= '	<div id="div_no_1cnomenclature'.$m['id'].'" style="margin-top:20px;">
											Номенклатура <span style="font-weight:bold;">'.$m['name'].'</span> не привязана к 1С
											<div>
												'.$this->Input(array(	'type'			=> 'button',
																	'class'			=> 'profile-btn request-btn modal_nomenclature',
																	'value'			=> 'Привязать',
																	'data'			=> array('id'=>$m['id'],'where'=>'logo_notification')
																)
														).'
												'.$create_1c_nomenclature.'
												'.$this->Input(array(	'type'			=> 'button',
																	'class'			=> 'profile-btn request-btn notification_logo_propustit',
																	'value'			=> 'пропустить',
																	'data'			=> array('id'=>$m['id'],'flag'=>1)
																)).'
											</div>
										</div>';
						}
						// не привязанные компании(поставщики) к 1с (только купленные)
						elseif($m['flag']==2){
								$tr .= '	<div id="div_no_1company'.$m['id'].'" style="margin-top:20px;">
											Пользователь <span style="font-weight:bold;">'.$m['name'].'</span> не привязана к 1С
											<div>
												<a href="/company-profile/'.$m['id'].'" class="profile-btn request-btn" target="_blank">Привязать</a>
												'.$this->Input(array(	'type'			=> 'button',
																	'class'			=> 'profile-btn request-btn notification_logo_propustit',
																	'value'			=> 'пропустить',
																	'data'			=> array('id'=>$m['id'],'flag'=>2)
																)).'
											</div>
										</div>';
						}
						// не привязанные категории к 1с категориям	
						elseif($m['flag']==3){
								$tr .= '	<div id="div_no_1ccategories'.$m['id'].'" style="margin-top:20px;">
											Категория <span style="font-weight:bold;">'.$m['name'].'</span> не привязана к 1С
											<div>
												'.$this->Input(array(	'type'			=> 'button',
																	'class'			=> 'profile-btn request-btn get_form_bind_1c_typenom',
																	'value'			=> 'Привязать',
																	'data'			=> array('id'=>$m['id'],'where'=>'logo_notification')
																)
														).'
												'.$this->Input(array(	'type'			=> 'button',
																	'class'			=> 'profile-btn request-btn notification_logo_propustit',
																	'value'			=> 'пропустить',
																	'data'			=> array('id'=>$m['id'],'flag'=>3)
																)).'
											</div>
										</div>
										
										<div id="div_bind_1c_typenom'.$m['id'].'" class="div_bind_1c_typenom"></div>
										';
						}
						
					}//end dostup_vip
						
					// бренды выбор с qwep
					if($m['flag']==4){
							$arr = $qrq->getAmoHtmlSearchbrend(array('buy_sell_id'=>$m['id']));
							$tr .= $arr['content'];
					}
					
				}

		
		$code .= $tr;

	
		return $code;
	}
	
	
	// отменяем пропустить в notification_logo_propustit
	function ClearNotificationLogoPropustit( $p=array() ){
		
		$in = fieldIn($p, array('nomenclature_id','company_id','company_id2','categories_id'));
		
		// возвращаем пропущенную номенклатуру
		if($in['nomenclature_id']){
				$STH = PreExecSQL(" DELETE FROM notification_logo_propustit WHERE company_id=? AND flag=1 AND tid=? " ,
														array( $in['company_id'] , $in['nomenclature_id'] ));
		}
		
		if($in['company_id']){
				$STH = PreExecSQL(" DELETE FROM notification_logo_propustit WHERE company_id=? AND flag=2 AND tid=? " ,
														array( $in['company_id'] , $in['company_id2'] ));
		}
		
		if($in['categories_id']){
				$STH = PreExecSQL(" DELETE FROM notification_logo_propustit WHERE company_id=? AND flag=3 AND tid=? " ,
														array( $in['company_id'] , $in['categories_id'] ));
		}
	
		return '';
	}
	
	
}
?>