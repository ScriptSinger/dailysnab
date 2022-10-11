<?php
	/*
	 *  Действия представления с Заявкой/Предложением/Объявлением
	 */
	 
class HtmlBuySell extends HtmlServive 
{
	
	// Проверка можно ли совершать действие изменять статус
	function ProverkaActionBuySell( $p=array() ){
		$ok = false;
		$code = '';
		$in = fieldIn($p, array('buy_sell_id','status_id'));// status_id - статус выбранный пользователем

		$r = isset($p['row'])? $p['row'] : reqBuySell_SaveBuySell(array('id'=>$in['buy_sell_id']));

		
		if( ($r['flag_buy_sell']==1||$r['flag_buy_sell']==2)&&$r['status_buy_sell_id']==1&&($in['status_id']==2||$in['status_id']==3||$in['status_id']==4)){// Не опубликованные может Опубликовать, Активировать, в Архив
				
				if( ($in['status_id']==2||$in['status_id']==3) && (PRAVA_2||PRAVA_3) ){
						if($r['categories_id']==1302){
							$code = 'Выберите категорию';
						}else{
							// проверка обязательности заполненных полей
							$arr = self::ProverkaEmptyCategoriesAttributeBuySell(array('row'=>$r));
							if($arr['ok']){
								$ok = true;
							}else{
								$code = $arr['code'];
							}
						}
				}elseif($in['status_id']==4){
					$ok = true;
				}
		}elseif( ($r['flag_buy_sell']==1||$r['flag_buy_sell']==2)&&$r['status_buy_sell_id']==2&&($in['status_id']==1||$in['status_id']==3||$in['status_id']==4)){
				if( ($in['status_id']==3) && (PRAVA_2||PRAVA_3) ){
					$ok = true;
				}elseif($in['status_id']==1||$in['status_id']==4){
					$ok = true;
				}
		}elseif( ($r['flag_buy_sell']==1||$r['flag_buy_sell']==2)&&$r['status_buy_sell_id']==3&&($in['status_id']==1||$in['status_id']==2||$in['status_id']==4)){
				if( ($in['status_id']==2) && (PRAVA_2||PRAVA_3) ){
					$ok = true;
				}elseif($in['status_id']==1||$in['status_id']==4){
					$ok = true;
				}
		}elseif( ($r['flag_buy_sell']==1||$r['flag_buy_sell']==2)&&$r['status_buy_sell_id']==4&&($in['status_id']==1||$in['status_id']==2||$in['status_id']==3)){
				if( ($in['status_id']==2||$in['status_id']==3) && (PRAVA_2||PRAVA_3) ){
					$ok = true;
				}elseif($in['status_id']==1){
					$ok = true;
				}
		}elseif( ($r['flag_buy_sell']==2)&&$r['status_buy_sell_id']==11&&($in['status_id']==12||$in['status_id']==13||$in['status_id']==14)){// статус Куплено и можно ...
				$ok = true;
		}elseif( ($r['flag_buy_sell']==2)&&$r['status_buy_sell_id']==12&&($in['status_id']==13||$in['status_id']==14)){// статус Исполнено и можно ...
				$ok = true;
		}elseif( ($r['flag_buy_sell']==2)&&$r['status_buy_sell_id']==14&&($in['status_id']==13)){// статус Возврат и можно ...
				$ok = true;
		}elseif( ($r['flag_buy_sell']==2)&&$r['status_buy_sell_id']==15&&($in['status_id']==13)){// статус Возвращено и можно ...
				$ok = true;
		}elseif( ($r['flag_buy_sell']==2)&&$r['status_buy_sell_id']==15&&($in['status_id']==13&&(!$r['company_id']==COMPANY_ID))){// статус Возвращено и можно ...
				$ok = true;
		}
		/*
		if($r['categories_id']==1302){
			if($in['status_id']==4){
				$ok = true;
			}else{
				$ok = false;
			}
		}
		*/
		return array('ok'=>$ok,'code'=>$code,'buy_sell'=>$r);
	}
	
	// проверка обязательности заполненных полей 
	function ProverkaEmptyCategoriesAttributeBuySell( $p=array() ){
		
		$row_bs = $p['row'];
		
		$ok = true;// по умолчанию
		$arr = array();
		$code = '';
		//vecho($r);
		if($row_bs['amount']=='0.00'){
			$arr[] = 'Количество';
		}
		
		$r = reqProverkaEmptyCategoriesAttributeBuySell(array('buy_sell_id'=>$row_bs['id'],'categories_id'=>$row_bs['categories_id']));
		foreach($r as $i=>$m){
			$arr[] = $m['attribute'];
		}
		
		if(!empty($arr)){
			$code = 'Укажите обязательные поля: '.implode(', ',$arr);
			$ok = false;
		}


		return array('ok'=>$ok,'code'=>$code);
	}


	// Предложения с количеством к Заявке (страница мои заявки)
	function ActionBuySell( $p=array() ){
		
		$in = $p['row'];
		
		// Получение минимальной цены и количестка
		$r_min = reqMyBuySell_OfferMinCost(array('buy_sell_id'=>$in['id']));
		
		
		$ok = false;
		$code = '';
		$status_id = $button_class = $flag_buy_sell = '';
		$arr_status = $arr_button = array();

		$cl_ma = 'action_buy_sell'; // по умолчанию

		if($in['login_id']<>LOGIN_ID){
				$cl_ma 		= 'modal_buy_sell';
				$flag_buy_sell = $in['flag_buy_sell'];
		}


		// Определяем набор действий связанных со статусом:
		
		// Заявка - Не опубликованная
		if( ($in['company_id']==COMPANY_ID) && ($in['flag_buy_sell']==1||$in['flag_buy_sell']==2) && $in['status_buy_sell_id']==1 ){
				$ok 			= true;
				$arr_status 	= array(2 => array('в Опубликованные',$cl_ma,false,$flag_buy_sell),
									3 => array('Активировать',$cl_ma,false,$flag_buy_sell),
									4 => array('в Архив','action_buy_sell') );
		}
		// Заявка - Опубликованная
		elseif( ($in['company_id']==COMPANY_ID) && ($in['flag_buy_sell']==1||$in['flag_buy_sell']==2) && $in['status_buy_sell_id']==2 ){
				$ok 			= true;
				$arr_status 	= array(1 => array('в Неопубликованные','action_buy_sell'),
									3 => array('Активировать','action_buy_sell'),
									4 => array('в Архив','action_buy_sell') );
		}
		// Заявка - Активная
		elseif( ($in['company_id']==COMPANY_ID) && ($in['flag_buy_sell']==1||$in['flag_buy_sell']==2) && $in['status_buy_sell_id']==3 ){
				$ok 			= true;
				$arr_status 	= array(1 => array('в Неопубликованные','action_buy_sell'),
									2 => array('в Опубликованные','action_buy_sell'),
									4 => array('в Архив','action_buy_sell') );
				$button_class 	= 'action_buy_sell';
		}
		// предложение - Купленные
		elseif( ($in['company_id']==COMPANY_ID) && ($in['flag_buy_sell']==2) && $in['status_buy_sell_id']==11 ){
				$ok 			= true;
				$arr_status 	= array(12	=> array('Исполнено','form_buy_sell',$in['categories_id']),
									14	=> array('на Возврат','form_buy_sell',$in['categories_id']),
									13	=> array('Отменить','action_buy_sell'));
		}
		// предложение - Исполнено
		elseif( ($in['company_id']==COMPANY_ID) && ($in['flag_buy_sell']==2) && $in['status_buy_sell_id']==12 ){
				$ok 			= true;
				$arr_status 	= array(14	=> array('на Возврат','form_buy_sell',$in['categories_id']),
									13	=> array('Отменить','action_buy_sell'));
		}
		// предложение - Возврат
		elseif( ($in['flag_buy_sell']==2) && $in['status_buy_sell_id']==14 ){
				if($in['company_id']==COMPANY_ID){// ( !!! в заявке !!! )
					$ok 			= true;
					$arr_status 	= array(13	=> array('Отменить','action_buy_sell'));					
				}elseif($in['company_id2']==COMPANY_ID){// ( !!! в объявление !!! )
					$ok 			= true;
					$arr_status 	= array(15	=> array('Возвращено','form_buy_sell',$in['categories_id']));					
					
				}

		}
		// предложение - Возвращено
		elseif( ($in['flag_buy_sell']==2) && $in['status_buy_sell_id']==15 ){
				if($in['company_id']==COMPANY_ID){// ( !!! в заявке !!! )
					//$ok 			= true;
					//$arr_status 	= array(13	=> array('Подтвердить?','action_buy_sell'));					
				}elseif($in['company_id2']==COMPANY_ID){// ( !!! в объявление !!! )
					$ok 			= true;
					$arr_status 	= array(13	=> array('Отменить','action_buy_sell'));
				}

		}
		// Заявка - Архив
		elseif( ($in['flag_buy_sell']==1||$in['flag_buy_sell']==2) && $in['status_buy_sell_id']==4 ){
				$ok 			= true;
				$arr_status 	= array(2 => array('в Опубликованные',	'action_buy_sell'),
									3 => array('Активировать',		'action_buy_sell') );
		}
		// Актив - Не выдан
		elseif( $in['flag_buy_sell']==4 && $in['status_buy_sell_id']==21 ){
				$ok 			= true;
				$arr_status 	= array(22 	=> array('Выдать',		'modal_assets_issue'),
									222	=> array('Опубликовать','action_assets'),
									24 	=> array('Продано',		'modal_assets_sell')
									);
		}
		// Актив - Выдан
		elseif( $in['flag_buy_sell']==4 && $in['status_buy_sell_id']==22 ){
				$ok 			= true;
				$arr_status 	= array(23 	=> array('Сдать',		'modal_assets_handover'),
									222	=> array('Опубликовать','action_assets'),
									24 	=> array('Продано',		'modal_assets_sell')
									);
		}
		// Актив - Сдан
		elseif( $in['flag_buy_sell']==4 && $in['status_buy_sell_id']==23 ){
				$ok 			= true;
				$arr_status 	= array(23 	=> array('Переместить',		'modal_assets_handover')
									);
		}
		// Склад - На складе
		elseif( $in['flag_buy_sell']==5 && $in['status_buy_sell_id']==31 ){
				if($in['kol_stock']==1){
						// выбираем склады пользователя для "переместить"
							$arr = array();
							$rs = reqStock(array('not_id'=>$in['stock_id']));
							foreach($rs as $i => $mm){
								$arr[ $mm['id'] ] = array( 'Переместить в "'.$mm['stock'].'"' , 'action_stock_move', $mm['stock'] , false , $mm['id'] );
							}
						///
						$ok 			= true;
						$arr_status 	= $arr + array(
											33	=> array('Выдать',					'modal_stock_issue'),
											32 	=> array('Резерв',					'modal_stock_reserve'),
											333 => array('Разместить объявление',	''),
											334 => array('Продать',					'modal_stock_sell'),
											335 => array('Переместить в активы',	'action_stock_move_assets')
											);
				}elseif($in['kol_stock']>1){
						$str 		= $this->format_by_count($in['kol_stock'], 'товар', 'товара', 'товаров');
						$value 		= $in['kol_stock'].' '.$str;
						$ok 			= true;
						$arr_status 	= array( 
											337 => array($value,'action_stock_nomenclature' , false , false , false , $in['nomenclature_id'] )
										);
				}
		}
		// Склад - Выдано
		elseif( $in['flag_buy_sell']==5 && $in['status_buy_sell_id']==33 ){

						$ok 			= true;
						$arr_status 	= array( 
											338 => array( 'Вернуть','save_stock_issue_cancel' )
										);
		}
		
		
		// Заявка - Опубликованная или Активная
		//if( $in['url_priznak']=='buy' && $in['flag_buy_sell']==2 && ($in['status_buy_sell_id']==2||$in['status_buy_sell_id']==3) ){
				if( $in['flag_buy_sell']<>5 && ($r_min['flag_offer_min_cost'] || $r_min['flag_offer_min_cost2']) ){// есть предложение
						$flag_offer_min_cost = ($r_min['flag_offer_min_cost'])? $r_min['flag_offer_min_cost'] : $r_min['flag_offer_min_cost2'];
						$arr_offer 	= explode('*',$flag_offer_min_cost);
						if($arr_offer[2]){
							$r = reqBuySellActionOfferMinCost(array('id'=>$arr_offer[2]));
							if($r['company_id']==COMPANY_ID){
									$kol_notification_offer	= ($r_min['kol_notification_offer'])? ' <span class="badge badge-warning">'.$r_min['kol_notification_offer'].'</span>' : '';
									$min_cost = 'от '.$this->nf($arr_offer[0]);
									if(PRAVA_5){
										$min_cost = 'Предложения';
									}
									$value 		= $min_cost.' ('.$arr_offer[1].')'.$kol_notification_offer;
									$button_class_offer 	= 'btn btn-primary btn-sm modal_offer_buy';
									$arr_button[] = self::ButtonAction(array(	'type'			=> 'button',
																			'buy_sell_id'	=> $arr_offer[2],
																			'status_id'		=> $status_id,
																			'value'			=> $value,
																			'button_class'	=> $button_class_offer,
																			'categories_id'	=> '',
																			'flag_buy_sell'	=> '',
																			'stock_id'		=> '',
																			'nomenclature_id' => $r['nomenclature_id'] ));
							}
						}
				}
		//}
		
		/*
		// Склад (товары к номенклатуре)
			$in['kol_stock'] = isset($in['kol_stock'])? $in['kol_stock'] : '';
			if( $in['kol_stock']>1 ){
					$str = $this->format_by_count($in['kol_stock'], 'товар', 'товара', 'товаров');
					$value 		= $in['kol_stock'].' '.$str;
					$button_class 	= 'btn btn-primary btn-sm action_stock_nomenclature';
					$arr_button[] = self::ButtonAction(array(	'type'			=> 'button',
															'buy_sell_id'	=> $in['id'],
															'status_id'		=> '',
															'value'			=> $value,
															'button_class'	=> $button_class,
															'categories_id'	=> '',
															'flag_buy_sell'	=> '',
															'nomenclature_id' => $in['nomenclature_id'] ));
			}
		*/
		
		
		// удаляем не которые кнопки по правам
		if(PRAVA_4||PRAVA_5){
			unset($arr_status);
			//$ok = false;
			//unset($arr_status[3]);
		}
//vecho($arr_status);
		if( (!empty($arr_status)&&$ok) /*&& ( $r_min['flag_offer_min_cost'] || $r_min['flag_offer_min_cost2'] )*/ ){		
				if(count($arr_status)>1||(!empty($arr_status)&&!empty($arr_button))){// более одного действия

					foreach($arr_status as $status_id => $arr){
							$nstatus 			= $arr[0];
							$button_class 		= $arr[1];
							$categories_id 	= isset($arr[2])? $arr[2] : '';
							$flag_buy_sell 	= isset($arr[3])? $arr[3] : '';
							$stock_id 		= isset($arr[4])? $arr[4] : '';
							$nomenclature_id 	= isset($arr[5])? $arr[5] : '';
							if(empty($arr_button)){
								$type = 'button';
								$button_class2 = 'btn btn-primary btn-sm '.$button_class;
							}else{
								$type = 'a';
								$button_class2 = 'dropdown-item '.$button_class;
							}
							$arr_button[] = self::ButtonAction(array(	'type'			=> $type,
																	'buy_sell_id'	=> $in['id'],
																	'status_id'		=> $status_id,
																	'value'			=> $nstatus,
																	'button_class'	=> $button_class2,
																	'categories_id'	=> $categories_id,
																	'flag_buy_sell'	=> $flag_buy_sell,
																	'stock_id'		=> $stock_id,
																	'nomenclature_id'=> $nomenclature_id	));
					}
					
					$arr_drop = array();
					$i = 1;
					for($i=1 ; $i<=count($arr_button)-1 ; $i++){
						$arr_drop[] = $arr_button[ $i ];
					}
					
					$code = '<div class="btn-group">
								'.$arr_button[0].'
								<button type="button" class="btn btn-sm btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<span class="sr-only"></span>
								</button>
								<div class="dropdown-menu">
									'.implode('',$arr_drop).'
								</div>
							</div>';
				}else{// одно действие (кнопка)
					foreach($arr_status as $status_id => $arr){
							$nstatus 			= $arr[0];
							$button_class 		= $arr[1];
							$categories_id 	= isset($arr[2])? $arr[2] : '';
							$flag_buy_sell 	= isset($arr[3])? $arr[3] : '';
							$stock_id 		= isset($arr[4])? $arr[4] : '';
							$nomenclature_id 	= isset($arr[5])? $arr[5] : '';
							$code = self::ButtonAction(array(	'type'			=> 'button',
																'buy_sell_id'	=> $in['id'],
																'status_id'		=> $status_id,
																'value'			=> $nstatus,
																'button_class'	=> 'request-btn request-hidden-btn '.$button_class,
																'categories_id'	=> $categories_id,
																'flag_buy_sell'	=> $flag_buy_sell,
																'stock_id'		=> '',
																'nomenclature_id'=> $nomenclature_id  ));
					}
				}
		}
			
		return $code;
	}


	// Кнопка действие 
	function ButtonAction( $in=array() ){

		$code = $this->Input(	array(	'type'			=> $in['type'],
									'class'			=> $in['button_class'].'',
									'value'			=> $in['value'],
									'data'			=> array( 'id' => $in['buy_sell_id'] , 'status' => $in['status_id'] ,
																'categories_id' 	=> $in['categories_id'],
																'flag_buy_sell' 	=> $in['flag_buy_sell'],
																'nomenclature_id' 	=> $in['nomenclature_id'],
																'stock_id' 			=> $in['stock_id'],
																'flag'	=> 1 )
								)
						);
			
		return $code;
	}


	// изменение статуса Заявки/Предложения/Объявления
	function UpdateStatusBuySell( $p=array() ){
		$in = fieldIn($p, array('buy_sell_id','status'));
		
		$code = $dop_sql = '';
		$ok = $STH = false;
		$flag_limit = true;// по умолчанию
		
		
		$arr = self::ProverkaActionBuySell( array(	'buy_sell_id'	=> $in['buy_sell_id'],
													'status_id'		=> $in['status'] ));

		if($arr['ok']){
				// Проверка - Опубликовываем/Активируем 
					if($in['status']==2||$in['status']==3){
						
							if($in['status']==3){// проверяем лимит на Активные объявления/заявки
									$r = $arr['buy_sell'];
									$arr_p = self::ProverkaLimitBuySell(array('flag_buy_sell'=>$r['flag_buy_sell'],'categories_id'=>$r['categories_id']));
									$flag_limit	= $arr_p['ok'];
									$code 	= $arr_p['code'];
									
							}
							
							
					
					}
				///
						// Проверка на категорию  [categories_id]
				//		if($arr["buy_sell"]["categories_id"]=='1302'){
				//			$code 	= 'Выберите категорию';
				//		}					
				

				
				if( ($in['status']==1||$in['status']==2||$in['status']==3||$in['status']==4) && $flag_limit ){
						
						$r = reqBuySell_SaveBuySell(array('id' => $in['buy_sell_id']));
						$flag_cron_new_buysell = false;
						$sql_data = '';
						if( (!$r['data_status_buy_sell_23']) && ($in['status']==2||$in['status']==3) ){// Опубликовываем||Активная, фиксируем дату при первой опубл или активации
							$sql_data = ' , data_status_buy_sell_23=NOW() ';
							$flag_cron_new_buysell = true;
						}
					
					
						$STH = PreExecSQL(" UPDATE buy_sell SET status_buy_sell_id=? ".$sql_data." WHERE company_id=? AND id=?; " ,
													array( $in['status'],COMPANY_ID,$in['buy_sell_id'] ));
						if($STH){
							$ok = true;
							if($flag_cron_new_buysell){// Добавляем - Id новой завки , чтобы через крон по ней отправить оповещение
									reqInsertСronNewBuysell(array('buy_sell_id'=>$in['buy_sell_id']));
							}
						}
						
				}
				// действие "Отменено"
				elseif( $in['status']==13 ){
						
						$row_bs = reqBuySell_SaveBuySell(array('id'=>$in['buy_sell_id']));					
						
						// Отменено в "Купленных"
						if($row_bs['status_buy_sell_id']==11){
							
							if($row_bs['copy_id']){// отмена покупки от предложения к заявки (при покупки объявления copy_id не создается)
							
								$r_n1 = reqBuySell_SaveBuySell(array('id'=>$row_bs['copy_id']));// заявка родитель
								
								$STH = PreExecSQL(" UPDATE buy_sell SET active=? , nomenclature_id=0 WHERE id=? AND company_id=?; " ,
											array( 2,$in['buy_sell_id'],COMPANY_ID ));

								/*$STH = PreExecSQL(" DELETE FROM buy_sell WHERE company_id=? AND id=?; " ,
														array( COMPANY_ID,$in['buy_sell_id'] ));*/
								if($STH&&$r_n1['parent_id']&&$r_n1['copy_id']){
									
									// проверка на Создание новой заявки при "Отменить"
									self::ChangeStatusBuy(array(	'buy_sell_id'				=> $r_n1['parent_id'],
																	'copy_id'					=> $r_n1['copy_id'],
																	'amount'					=> $row_bs['amount'],
																	'data_insert'				=> $row_bs['data_insert'],// дата текущей записи
																	'where_status'				=> 11,
																	'status'					=> 13 ));
									/*// удаляем копию заявки
										$STH = PreExecSQL(" DELETE FROM buy_sell WHERE company_id=? AND id=?; " ,
															array( COMPANY_ID,$row_bs['copy_id'] ));*/
								}
								
							}else{// при покупки объявления
							
								$STH = PreExecSQL(" DELETE FROM buy_sell WHERE company_id=? AND id=?; " ,
														array( COMPANY_ID,$in['buy_sell_id'] ));
														
							}
													
						}
						// Отменено в "Исполнено"
						elseif($row_bs['status_buy_sell_id']==12){
						
							$STH = PreExecSQL(" DELETE FROM buy_sell WHERE company_id=? AND id=?; " ,
													array( COMPANY_ID,$in['buy_sell_id'] ));
													
							$r_n1 = reqBuySell_SaveBuySell(array('id'=>$row_bs['parent_id']));// родитель
							if($STH){
									self::ChangeStatusBuy(array(	'row'			=> $r_n1,
																	'status'		=> 12 ));
									// удаляем  оповещение
										$STH = PreExecSQL(" DELETE FROM notification WHERE notification_id=7 AND tid=?; " ,
																		array( $in['buy_sell_id'] ));
										$STH = PreExecSQL(" DELETE FROM notification_cron_send_1800 WHERE notification_id=7 AND tid=?; " ,
																		array( $in['buy_sell_id'] ));
									///
							}
						}
						// Отменено в "Возврат"
						elseif($row_bs['status_buy_sell_id']==14){
						
							$STH = PreExecSQL(" DELETE FROM buy_sell WHERE company_id=? AND id=?; " ,
													array( COMPANY_ID,$in['buy_sell_id'] ));
													
							$r_n1 = reqBuySell_SaveBuySell(array('id'=>$row_bs['parent_id']));// родитель
							
							if($STH){
									self::ChangeStatusBuy(array(	'row'			=> $r_n1,
																	'status'		=> 14 ));
								// удаляем  оповещение
									$STH = PreExecSQL(" DELETE FROM notification WHERE notification_id=6 AND tid=?; " ,
																	array( $in['buy_sell_id'] ));
									$STH = PreExecSQL(" DELETE FROM notification_cron_send_1800 WHERE notification_id=6 AND tid=?; " ,
																	array( $in['buy_sell_id'] ));
								///
							}
						}
						// Отменено в "Возвращено" - в Объявлениях
						elseif( $row_bs['status_buy_sell_id']==15 && ($row_bs['company_id2']==COMPANY_ID) ){
						
							$STH = PreExecSQL(" DELETE FROM buy_sell WHERE company_id2=? AND id=?; " ,
													array( COMPANY_ID,$in['buy_sell_id'] ));
													
							$r_n1 = reqBuySell_SaveBuySell(array('id'=>$row_bs['parent_id']));// родитель
							
							if($STH){
									self::ChangeStatusBuy(array(	'row'			=> $r_n1,
																	'status'		=> 15 ));
							}
						}						
						
						if($STH){
							$ok = true;
							/*
							// создание новой заявки при "Отменить"
							self::ChangeStatusBuy(array(	'buy_sell_id'				=> $r_n1['parent_id'],
															'copy_id'					=> $r_n1['copy_id'],
															'amount'					=> $row_bs['amount'],
															'data_insert'				=> $row_bs['data_insert'],// дата текущей записи
															'where_status'				=> $row_bs['status_buy_sell_id'],
															'status'					=> 13 ));
							*/
						}
						
				}
		}else{
			$code = $arr['code'];
		}

		return array('ok'=>$ok,'code'=>$code,'row_bs'=>$arr['buy_sell']);
	}


	// создание новой заявки при "Отмене" или "Возврат"
	function ChangeStatusBuy( $p=array() ){
		$ok = false;
		$in = fieldIn($p, array('buy_sell_id','status','where_status','data_insert','amount','copy_id','company_id','login_id'));
		
		$login_id 		= isset($in['login_id'])? 	$in['login_id'] 		: LOGIN_ID;
		$company_id 	= isset($in['company_id'])? 	$in['company_id'] 	: COMPANY_ID;
		
		// Куплено
		if($in['status']==11){
		
				// проверяем, если количество больше или равно в заявке
				$r = reqProverkaAmountBuy(array('buy_sell_id' => $in['buy_sell_id'] , 'flag' => 11));
				if($r['flag_amount']){// меняем статус у ЗАЯВКИ на "исполнено"
						$STH = PreExecSQL(" UPDATE buy_sell SET status_buy_sell_id=? WHERE id=? AND company_id=?; " ,
									array( 5,$in['buy_sell_id'],$company_id ));
						if($STH){
							$ok = true;
						}
				}
						
		}
		// "Исполнено" или "Возврат"
		elseif($in['status']==12||$in['status']==14){
			
				$row_bs = isset($p['row'])? $p['row'] : array();
				$rf = reqProverkaAmountBuy(array('buy_sell_id' => $row_bs['id'] , 'flag' => 12 , 'status'=>$in['status']));
				if(!$rf['flag_amount']){
					$active = 1;
				}else{
					$active = 2;	
				}
				
				// количество "Исполнено" больше или равно количеству "Куплено", меняем видимость у "Купленого"
				$STH = PreExecSQL(" UPDATE buy_sell SET active=? WHERE id=? AND company_id=?; " ,
							array( $active,$row_bs['id'],$company_id ));
				if($STH){
					$ok = true;
				}
				
				/// если ВОЗВРАТ
					if( $in['status']==14 && ($in['where_status']==11||$in['where_status']==12) ){// при "Возврате" из купленных или исполненных создаем новую заявку

						$arr2 = self::CopyRowBuySell(array(	'buy_sell_id'	=> $in['buy_sell_id'],
															'parent_id'		=> 0,
															'copy_id'		=> 0,
															'login_id'		=> $login_id,
															'company_id'	=> $company_id,
															'status'		=> 2,
															'amount'		=> $in['amount'] ));
						
						//  формируем и сохраняем html представление "строки" "Мои заявки/объявление"
							self::SaveCacheBuySell(array('buy_sell_id'=>$arr2['buy_sell_id'],'flag_buy_sell'=>2));	
						///

					}
				///
		}
		// "Отменено"
		elseif($in['status']==13){// where_status - откуда произошла отмена

				if( $in['where_status']==11 ){// "Отмена" в Купленных
					
					// проверяем сколько прошло дней с момента смены статуса
					$r = reqProverkaDay(array('data_insert'=>$in['data_insert']));
					//vecho($r);
					if( $r['kol_day']>1 ){// прошло с момента покупки более одного дня, создаем заявку с этим количеством
							/*
							self::CopyRowBuySell(array(	'buy_sell_id'	=> $in['buy_sell_id'],
														'parent_id'		=> 0,
														'copy_id'		=> 0,
														'login_id'		=> LOGIN_ID,
														'company_id'	=> COMPANY_ID,
														'status'		=> 2,
														'amount'		=> $in['amount'] ));
							*/
							/* 16-05-2021
							self::CopyRowBuySell(array(	'buy_sell_id'	=> $in['buy_sell_id'],
														'parent_id'		=> $in['buy_sell_id'],
														'copy_id'		=> $in['copy_id'],
														'login_id'		=> LOGIN_ID,
														'company_id'	=> COMPANY_ID,
														'status'		=> 11,
														'amount'		=> $in['amount'] ));
							*/
							$arr2 = self::CopyRowBuySell(array(	'buy_sell_id'	=> $in['buy_sell_id'],
																'parent_id'		=> $in['buy_sell_id'],
																'copy_id'		=> 0,
																'login_id'		=> $login_id,
																'company_id'	=> $company_id,
																'status'		=> 2,
																'amount'		=> $in['amount'] ));
														
							//  формируем и сохраняем html представление "строки" "Мои заявки/объявление"
								self::SaveCacheBuySell(array('buy_sell_id'=>$arr2['buy_sell_id'],'flag_buy_sell'=>2));	
							///

					}else{// проверяем количество и если купленых-исполненных меньше, то активируем или опубликовываем заявку
							// сработает ТОЛЬКО в случае с Отменой КУПЛЕННЫХ - проверяем, если количество меньше в заявке
							$rf = reqProverkaAmountBuy(array('buy_sell_id' => $in['buy_sell_id'] , 'flag' => 11));
							//vecho($in['buy_sell_id']);
							//vecho($rf);
							if(!$rf['flag_amount']){// меняем статус у ЗАЯВКИ на "опубликовано или активная"
									$STH = PreExecSQL(" UPDATE buy_sell SET status_buy_sell_id=? WHERE id=? AND company_id=?; " ,
												array( 2,$in['buy_sell_id'],$company_id ));
									if($STH){
										$ok = true;
									}
							}
					}
					
				}
		}
		// "Возвращено"
		elseif($in['status']==15){
			
				$row_bs = isset($p['row'])? $p['row'] : array();
				
				$rf = reqProverkaAmountBuy(array('buy_sell_id' => $row_bs['id'] , 'flag' => 15));
				if(!$rf['flag_amount']){
					$active = 1;
				}else{
					$active = 2;	
				}
				
				// количество "Возвращено" больше или равно количеству "Возврат", меняем видимость у "Возврат"
				$STH = PreExecSQL(" UPDATE buy_sell SET active=? WHERE id=? AND company_id2=?; " ,
							array( $active,$row_bs['id'],$company_id ));
				if($STH){
					$ok = true;
				}
		}

		return '';
	}

	
	// проверяем лимит на Активные объявления/заявки
	function ProverkaLimitBuySell( $p=array() ){
			$code = '';
			
			$in = fieldIn($p, array('flag_buy_sell','categories_id'));
			
			$ok = true;
			
			if($in['flag_buy_sell']==1){// продажа
				$pole = 'limit_sell';
				$str1	 = 'Объявления';
			}elseif($in['flag_buy_sell']==2){// покупка
				$pole = 'limit_buy';
				$str1	 = 'Заявки';
			}
		
			$r		= reqSlovCategories(array('id' => $in['categories_id']));
			$r_k	= reqCountBuySellByCompany(array('categories_id' => $in['categories_id'],'flag_buy_sell'=>$in['flag_buy_sell']));

			if($r_k['kol']>=$r[ $pole ]){
				$code = 'Лимит активации '.$str1.' исчерпан';
				$ok = false;
			}
			
		return array('ok'=>$ok,'code'=>$code);
	}
	
	
	// Копия заявки (клон заявки)
	function CopyRowBuySell( $p=array() ){
			$code = '';
			
			$in = fieldIn($p, array('buy_sell_id','copy_id','login_id','company_id','company_id2','amount','cost',
									'status','flag_buy_sell','glav_flag_buy_sell','currency_id','form_payment_id',
									'stock_id','assets_id','company_id3'));
			
			$in['parent_id'] = (isset($p['parent_id']))? 	$p['parent_id'] : '';
			$in['glav_flag_buy_sell'] = ($in['glav_flag_buy_sell'])? $in['glav_flag_buy_sell'] : $in['flag_buy_sell'];

			$row_bs 			= reqBuySell_SaveBuySell(array('id'=>$in['buy_sell_id']));
		
			$flag_buy_sell = ($in['flag_buy_sell'])? 					$in['flag_buy_sell']	: $row_bs['flag_buy_sell'];
			$amount 		= ($in['amount'])? 							$in['amount'] 		: $row_bs['amount'];
			$cost 		= ($in['cost'])? 							$in['cost'] 			: $row_bs['cost'];
			$parent_id 	= ($in['parent_id']||$in['parent_id']===0)? 	$in['parent_id'] 	: $row_bs['parent_id'];
			$copy_id 	= ($in['copy_id'])? 							$in['copy_id'] 		: 0;
			$login_id 		= ($in['login_id'])? 						$in['login_id'] 		: $row_bs['login_id_bs'];
			$company_id 	= ($in['company_id'])? 						$in['company_id'] 	: $row_bs['company_id'];
			$company_id2 	= ($in['company_id2'])? 						$in['company_id2'] 	: 0;
			$currency_id 	= ($in['currency_id'])? 						$in['currency_id'] 	: $row_bs['currency_id'];
			$form_payment_id 	= ($in['form_payment_id'])? 				$in['form_payment_id'] 	: $row_bs['form_payment_id'];
			$stock_id 	= ($in['stock_id'])? 						$in['stock_id'] 		: $row_bs['stock_id'];
			$assets_id 	= ($in['assets_id'])? 						$in['assets_id'] 	: $row_bs['assets_id'];
			$company_id3 	= ($in['company_id3'])? 						$in['company_id3'] 	: $row_bs['company_id3'];
			
			
			$amount_buy = $amount;// по умолчанию (покупаемое количество)
			
			if($in['status']==6){// копия заявки
				$url = 'copy';
			}elseif($in['status']==11&&$in['glav_flag_buy_sell']==2){// покупка в заявках
				$url = 'buy';
				$r = reqBuySell_SaveBuySell(array('id'=>$row_bs['parent_id']));
				$row_bs['nomenclature_id'] 	= $r['nomenclature_id'];
				$row_bs['responsible_id']	= $r['responsible_id'];
				$stock_id	= $r['stock_id'];
				$assets_id	= $r['assets_id'];
				$company_id3	= $r['company_id3'];
				// пересчитываем, если надо, количество при фасовке или отличной от ед.изм заявки
					$amount = self::BuyAmountByUnit(array('row_bs' => $row_bs,'amount' => $amount));
				///
			}elseif($in['status']==11&&$in['glav_flag_buy_sell']==5){// покупка в склад
				$url = 'stock_sell';
				$stock_id	= 0;
			}else{
				$url 	= $this->rus2translit($row_bs['name']);
			}

			$arr = reqInsertBuySell(array(	'login_id'			=> $login_id,
											'company_id'		=> $company_id,
											'company_id2'		=> $company_id2,
											'parent_id'			=> $parent_id,
											'copy_id'			=> $copy_id,
											'flag_buy_sell'		=> $flag_buy_sell,
											'status'			=> $in['status'],
											'name'				=> $row_bs['name'],
											'url'				=> $url,
											'cities_id'			=> $row_bs['cities_id'],
											'categories_id'		=> $row_bs['categories_id'],
											'urgency_id'		=> $row_bs['urgency_id'],
											'currency_id'		=> $currency_id,
											'cost'				=> $cost,
											'cost1'				=> $row_bs['cost1'],
											'form_payment_id'	=> $form_payment_id,
											'amount'			=> $amount,
											'amount1'			=> $row_bs['amount1'],
											'unit_id1'			=> $row_bs['unit_id1'],
											'amount2'			=> $row_bs['amount2'],
											'unit_id2'			=> $row_bs['unit_id2'],
											'amount_buy'		=> $amount_buy,
											'comments'			=> $row_bs['comments'],
											'comments_company'	=> $row_bs['comments_company'],
											'responsible_id'	=> $row_bs['responsible_id'],
											'availability'		=> $row_bs['availability'],
											'nomenclature_id'	=> $row_bs['nomenclature_id'],
											'multiplicity'		=> $row_bs['multiplicity'],
											'min_party'			=> $row_bs['min_party'],
											'stock_id'			=> $stock_id,
											'assets_id'			=> $assets_id,
											'company_id3'		=> $company_id3
											));
			if($arr['STH']){
					$buy_sell_id = $arr['buy_sell_id'];
					$ok = true;
					// атрибуты копированной записи
					$ra = reqBuySellAttribute(array('buy_sell_id'=>$row_bs['id']));
					foreach($ra as $i => $m){
						$STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, attribute_value_id, value) VALUES (?,?,?,?); " ,
												array( $buy_sell_id,$m['attribute_id'],$m['attribute_value_id'],$m['value'] ));
					}
					
					if($in['status']==11){// Удаляем пропустить при покупки
							
							$STH = PreExecSQL(" DELETE FROM notification_logo_propustit WHERE flag=2 and tid=?; " ,
												array( $company_id2 ));
							
					}
			}
			
		
		return array('buy_sell_id'=>$buy_sell_id);
	}
	
	
	// Копия ФАЙЛОВ заявки/объявления
	function CopyFileBuySell( $p=array() ){
			$code = '';
			
			$in = fieldIn($p, array('buy_sell_id','id'));

			$ra = reqBuySellFiles(array('buy_sell_id'=>$in['buy_sell_id']));
			foreach($ra as $i => $m){
					$STH = PreExecSQL(" INSERT INTO buy_sell_files (buy_sell_id, path, name_file, type_file) VALUES (?,?,?,?) " ,
																	array( $in['id'],$m['path'],$m['name_file'],$m['type_file'] ));
			}
			
		
		return '';
	}
	
	// Insert/Update Номенклатура
	function NomenclatureInsertUpdate( $p=array() ){

		$in = fieldIn($p, array('id','name','categories_id','1c_nomenclature_id','flag','buy_sell_id'));
		$post = $p['post'];

		$ok = $STH = $nomenclature_id = $categories_id = $flag_1c = false;	
		$code = 'Нельзя сохранить';
		$error_required = array();
		
		if(!$in['id']){// СОЗДАНИЕ

					
					$arr = reqInsertNomenclature(array(	
														'name'					=> $in['name'],
														'categories_id'			=> $in['categories_id'],
														'1c_nomenclature_id'	=> $in['1c_nomenclature_id']
														));
					if($arr['STH']){
							$nomenclature_id 	= $arr['nomenclature_id'];
							$categories_id		= $in['categories_id'];
							$ok = true;
							if($in['buy_sell_id']){// добавляем в заявку номенклатуру
									$STH = PreExecSQL(" UPDATE buy_sell SET nomenclature_id=? WHERE id=?; " ,
													array( $nomenclature_id,$in['buy_sell_id'] ));
							}
					}
					
		}else{// РЕДАКТИРОВАНИЕ
				
				$r = reqNomenclature(array('id' => $in['id']));
				
				$categories_id	= $r['categories_id'];
				$in['1c_nomenclature_id']	= ($in['1c_nomenclature_id'])? $in['1c_nomenclature_id'] : $r['1c_nomenclature_id'];
				
				$STH = PreExecSQL(" UPDATE nomenclature SET name=? , 1c_nomenclature_id=? WHERE id=? AND company_id=?; " ,
										array( $in['name'],$in['1c_nomenclature_id'],$in['id'],COMPANY_ID ));
				if($STH){
					$nomenclature_id = $in['id'];
					$ok = true;
					$flag_1c			= ($in['1c_nomenclature_id'])? true : false;
				}
		}
		

		
		// Сохранение динамических параметров
		if($nomenclature_id){
			$bsa_id = array();
			$STH = PreExecSQL(" DELETE FROM nomenclature_attribute WHERE nomenclature_id=?; " ,
															array( $nomenclature_id ));

			$pole1 = 'buy_type_attribute_id';
			$pole2 = 'buy_flag_value';
			$pole3 = 'no_empty_buy';
			
			
			$row = reqCategoriesAttribute(array('categories_id'=>$categories_id));

			foreach($row as $i=>$m){
				$elem = 'elem_'.$m['attribute_id'];
				$arr = isset($post[ $elem ])? $post[ $elem ] : array();
				$flag_value 	= $m[ $pole2 ];
				$no_empty	= $m[ $pole3 ];

				if($m[ $pole1 ]==2){// Цифровой период
					if(is_array($arr)){
						$arr[0] = isset($arr[0])? $arr[0] : '';
						$arr[1] = isset($arr[1])? $arr[1] : '';
						if($arr[0]<>$arr[1]){
							$arr = implode('-',$arr);
						}else{
							$arr = $arr[0];
						}
					}
				}

				
				if(!empty($arr)){
						
						if($flag_value==1){// связь по id
							$pole = 'attribute_value_id';
						}elseif($flag_value==2){// значение введенное пользователем
							$pole = 'value';
						}
						if(is_array($arr)){
							foreach($arr as $v){
									$STH = PreExecSQL(" INSERT INTO nomenclature_attribute (nomenclature_id, attribute_id, ".$pole.") VALUES (?,?,?); " ,
															array( $nomenclature_id,$m['attribute_id'],$v ));
							}
						}else{
									$STH = PreExecSQL(" INSERT INTO nomenclature_attribute (nomenclature_id, attribute_id, ".$pole.") VALUES (?,?,?); " ,
															array( $nomenclature_id,$m['attribute_id'],$arr ));
						}
				}else{
					if($no_empty){
						$error_required[] = $m['attribute'];
					}
				}
				
			}
			
			
		}
		if(!empty($error_required)){
			$code = 'Заполните: '.implode(', ',$error_required);
			$ok = false;
		}
	
		return array('ok'=>$ok,'code'=>$code,'flag_1c'=>$flag_1c,'nomenclature_id'=>$nomenclature_id);
	}
	
	
	
	// Обновляем и пересчитываем количество "amount" и "cost" , если у категории указано фасовка
	function UpdateBuySellByPacking( $p=array() ){
		
		$in = fieldIn($p, array('buy_sell_id','categories_id','status','cost','amount','amount1','unit_id1','amount2','unit_id2'));
		
		$in['cost'] = $in['cost']? $in['cost'] : 0;
		
		$rc 	= reqSlovCategories(array('id' => $in['categories_id']));

		if($rc['unit_group_id']){ // указана у категории группа фасовки (т.е две ед.изменения - это ШТУКИ и ВЫБРАНАЯ пользователем)

			// рассчитываем "расчетное количество" (приведенное при фасовке)
				if($in['unit_id2']&&$in['amount2']){// выбрано ШТУКИ и другая ед.измерения
						$r = reqSlovUnitFormula(array('unit_id'=>$rc['unit_id'],'unit_id1'=>$in['unit_id2']));
					
						$amount = $aa = $in['amount1']*$in['amount2'];
						if($r['formula']){
							$amount = str_replace('{NUMBER}',$aa,$r['formula']);
							$amount = eval("return $amount;");
						}
						
						$r 		= reqSlovUnitFormula(array('unit_id'=>$in['unit_id2'],'unit_id1'=>$rc['unit_id']));

						$cost = $aa = $in['cost']/$in['amount2'];
						if($r['formula']){
							$cost = str_replace('{NUMBER}',$aa,$r['formula']);
							$cost = eval("return $cost;");
						}
						
				}elseif($in['unit_id1']&&!$in['unit_id2']&&($rc['unit_id']<>$in['unit_id1'])){
						$r 		= reqSlovUnitFormula(array('unit_id'=>$rc['unit_id'],'unit_id1'=>$in['unit_id1']));
						$amount 	= str_replace('{NUMBER}',$in['amount1'],$r['formula']);
						$amount 	= eval("return $amount;");
						$in['amount2'] 	= 0;
						
						$r 		= reqSlovUnitFormula(array('unit_id'=>$in['unit_id1'],'unit_id1'=>$rc['unit_id']));
						//vecho($in);
						$cost = $aa = $in['cost']/$in['amount1'];
						if($r['formula']){
							$cost = str_replace('{NUMBER}',$aa,$r['formula']);
							$cost = eval("return $cost;");						
						}
				}elseif($rc['unit_id']==$in['unit_id1']){// выбрана одна и тажа ед.изм у категории и пользователем
						$amount 			= $in['amount1'];
						$in['amount2'] 	= 0;
						
						$cost 			= $in['cost'];
				}else{// выбрана одна и тажа ед.изм у категории и пользователем
						$amount 			= $in['amount'];
						$in['amount1'] 	= 0;
						$in['amount2'] 	= 0;
						
						$cost 			= $in['cost'];
				}
			///
			
			$STH = PreExecSQL(" UPDATE buy_sell SET amount=?, amount1=?, unit_id1=?, amount2=?, unit_id2=?, cost=?, cost1=? WHERE id=?; " ,
											array( $amount,$in['amount1'],$in['unit_id1'],$in['amount2'],$in['unit_id2'],$cost,$in['cost'],$in['buy_sell_id'] ));
						
			if($STH){
				
			}
		}
		
		return '';
	}
	
	
	// Возвращает пересчитаное количество "amount" и "cost" , если у категории указано фасовка или отличная ед.изм.
	function BuyAmountByUnit( $p=array() ){
		
		$in = fieldIn($p, array('amount'));
		$row_bs = $p['row_bs'];
		//vecho($row_bs);
		$amount = $in['amount'];// по умолчанию

		if($row_bs['unit_group_id']){ // указана у категории группа фасовки (т.е две ед.изменения - это ШТУКИ и ВЫБРАНАЯ пользователем)
					
			// рассчитываем "расчетное количество" (приведенное при фасовке)
				if($row_bs['unit_id2']&&$row_bs['amount2']){// выбрано ШТУКИ и другая ед.измерения
						if($row_bs['unit_id']==$row_bs['unit_id2']){
								$amount = $in['amount']*$row_bs['amount2'];
						}else{
								$r = reqSlovUnitFormula(array('unit_id'=>$row_bs['unit_id'],'unit_id1'=>$row_bs['unit_id2']));
								
								$aa = $in['amount']*$row_bs['amount2'];
								$amount = str_replace('{NUMBER}',$aa,$r['formula']);
								$amount = eval("return $amount;");
						}
						
				}elseif($row_bs['unit_id1']&&!$row_bs['unit_id2']&&($row_bs['unit_id']<>$row_bs['unit_id1'])){
						$r 		= reqSlovUnitFormula(array('unit_id'=>$row_bs['unit_id'],'unit_id1'=>$row_bs['unit_id1']));
						$amount 	= str_replace('{NUMBER}',$in['amount'],$r['formula']);
						$amount 	= eval("return $amount;");
						
				}
			///

		}
	
		return $amount;
	}


	// формируем и сохраняем html представление "строки" "Мои заявки"
	function SaveCacheBuySell( $p=array() ){
		
		$t = new HtmlTemplate();
		
		$in = fieldIn($p, array('buy_sell_id','flag_buy_sell','flag_cache'));

		$STH = false;

		$tr_1 = $tr_2 = '';
			
		$row = reqMyBuySell(array('id'=>$in['buy_sell_id']));

		if($in['flag_buy_sell']==2 && !empty($row)){// формируем строку "Мои заявки"

			$tr_2 = $t->TrMyBuy(array('m'=>$row,'cache'=>true,'flag_cache'=>$in['flag_cache']));
			
		}
		
		if( ( $in['flag_buy_sell']==1 || ( $in['flag_buy_sell']==2 && ($row['status_buy_sell_id']>=10) ) ) &&!empty($row) ){// формируем строку "Мои объявления" и Активы
			
			$tr_1 = $t->TrMySell(array('m'=>$row,'cache'=>true));
			
		}
		

		if( $tr_2 || $tr_1 ){// сохраняем cache 
			$STH = PreExecSQL(" DELETE FROM buy_sell_cache WHERE buy_sell_id=?; " ,
											array( $in['buy_sell_id'] ));
			if($STH){
					$STH = PreExecSQL(" INSERT INTO buy_sell_cache (buy_sell_id,cache_2,cache_1) VALUES (?,?,?); " ,
											array( $in['buy_sell_id'] , $tr_2 , $tr_1 ));
			}
		}


		return $STH;
	}

	
	// добавляем на склад товар 
	function AddStock( $p=array() ){
		
		$in = fieldIn($p, array('flag','buy_sell_id','categories_id'));
		
		// добавляем товар на склад при исполнении заявки
		if( ($in['flag']=='status_buy_sell_id12') && (COMPANY_ID==1070) ){ 
		
				// проверяем , если категория не отмечена как "В актив" (определяется в админке у категории)
				$r = reqSlovCategories(array('id'=>$in['categories_id']));
				if(!$r['assets']){
						// проверяем, есть ли у пользователя склад (при включении в админке "функции склад", создается склад по умолчанию)
						$rs = reqStock(array('flag'=>'add_stock','company_id'=>COMPANY_ID));
						if($rs['id']){
							self::CopyRowBuySell(array(	'buy_sell_id'	=> $in['buy_sell_id'],
														'parent_id'		=> $in['buy_sell_id'],
														'flag_buy_sell'	=> 5,
														'stock_id'		=> $rs['id'],
														'status'		=> 31 ));
						}
				}
		}
		
		return '';
	}
	
	
	
	// сохранить Купить - Предложение/Объявление
	function SaveBuyOffer( $p=array() ){
		
		$t 	= new HtmlTemplate();
		$cn	= new ClassNotification();
		
		$in = fieldIn($p, array('flag','buy_sell_id','categories_id','amount','where'));
		
		$code = '';
		$flag_clear_parent = false;
		
		$row_bs = $p['row_bs'];
		
		$parent_id = $row_bs['parent_id'];
		
			// создаем копию заявки на момент покупки
			$arr['buy_sell_id'] = 0;
			if($row_bs['flag_buy_sell']==2){
					$glav_flag_buy_sell = 2;
					$arr = self::CopyRowBuySell(array(	'buy_sell_id'	=> $row_bs['parent_id'],
														'parent_id'		=> $row_bs['parent_id'],
														'copy_id'		=> $row_bs['parent_id'],
														'status'		=> 6 ));
			}else{// в случае покупки объявления копию не делаем
					
					$glav_flag_buy_sell = 1;
					$row_bs['flag_buy_sell'] 	= 2;
			}
				
			// создаем "Покупку", с параметрами от "Предложения", со ссылкой на созданную копию заявки
			// в случае объявления flag_buy_sell=2
				$arr2 = self::CopyRowBuySell(array(	'buy_sell_id'	=> $in['buy_sell_id'],
													'parent_id'		=> $in['buy_sell_id'],
													'copy_id'		=> $arr['buy_sell_id'],
													'login_id'		=> LOGIN_ID,
													'company_id'	=> COMPANY_ID,
													'company_id2'	=> $row_bs['company_id'],
													'flag_buy_sell'	=> $row_bs['flag_buy_sell'],
													'status'		=> 11,
													'amount'		=> $in['amount'],
													'glav_flag_buy_sell'		=> $glav_flag_buy_sell ));
				
				if($arr2['buy_sell_id']){
					$ok 		= true;
					// сохраняем Файлы (привязываем к новой записи)
					//if($glav_flag_buy_sell==1){
						self::CopyFileBuySell(array('buy_sell_id'=>$in['buy_sell_id'],'id'=>$arr2['buy_sell_id']));
					//}
					
					//  формируем и сохраняем html представление "строки" "Мои заявки/объявление"
						self::SaveCacheBuySell(array('buy_sell_id'=>$arr2['buy_sell_id'],'flag_buy_sell'=>$row_bs['flag_buy_sell']));	
					///
					
					// меняем статус у ЗАЯВКИ на "исполнено", после "Покупки"
						self::ChangeStatusBuy(array('buy_sell_id'=>$row_bs['parent_id'],'status'=>11));
						
					// Оповещение
					
						$cn->StartNotification(array(	'flag'				=> 'buy_sell',
														'tid'				=> $arr2['buy_sell_id'],
														'status_buy_sell_id'=> 11,
														'company_id2'		=> $row_bs['company_id'] ));
					
					// отменяем пропустить в notification_logo_propustit
						$row_bs = reqBuySell_SaveBuyOffer(array('id'=>$row_bs['parent_id']));
						$cn->ClearNotificationLogoPropustit(array(	'company_id'		=> COMPANY_ID,
																	'nomenclature_id'	=> $row_bs['nomenclature_id'],
																	'company_id2'		=> $row_bs['company_id'],
																	'categories_id'		=> $row_bs['categories_id'] ));
					
					
				}
				
				if($in['where']=='modal_offer11'){// получаем строку для обновления , при покупке
						
						$row = reqBuySell_Offer(array( 'id' => $in['buy_sell_id'] ));
						$row_amount_buy = reqBuySell_Offer_AmountBuy(array('id' => $in['buy_sell_id']));//купленное количество по этой заявке
						$amount_parent = $row_bs['amount'] - $row_amount_buy['amount_buy'];
						// class_template
						$arr 	= $t->TrModalOffer(array(	'row'			=> $row,
															'parent_id'		=> $in['buy_sell_id'],
															'amount_parent'	=> $amount_parent	));
						$code = $arr['tr'];
						
						
						// проверяем скрывать строку tr заявки (чье предложение мы купили)
						$row_p = reqBuySell_SaveBuyOffer(array('id'=>$row['parent_id']));
						if($row_p['status_buy_sell_id']==5){
							$flag_clear_parent = true;
						}
				}
				
		return array( 'ok'=>$ok , 'code'=>$code , 'flag_clear_parent'=>$flag_clear_parent , 'parent_id'=>$parent_id );
	}
	
	
	// Проверить доступность пользователя к не опубликованным заявкам
	function GetUrlBuySellOne( $p=array() ){
		
		$in = fieldIn($p, array('buy_sell_id'));
		
		$r = reqBuySell_buysellone(array('id'=>$in['buy_sell_id']));
		
		$url = $code = '';
		$ok = false;
		
		
		if( $r['flag_subscriptions_company_in'] && $r['status_buy_sell_id']==2 ){// подписан на компанию чья опубликованная заявка
			
				$url = '/' . $r['url_cities'] . '/' . $r['url_categories'] . '/' . $r['url'];
				$ok = true;
		}else{
				$code = 'Чтоб увидеть подробности вам нужно подписаться на пользователя';
		}
		
		return array('ok'=>$ok , 'code'=>$code , 'url'=>$url);
	}	
	
}
?>