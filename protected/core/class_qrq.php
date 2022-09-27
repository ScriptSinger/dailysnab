<?php
	/*
	 *  Захват со стороних ресурсов
	
	!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	пока используются в старой версии на questrequest.com
	
	удалить как перейдем на AMO из базы таблицы 
								cron_qrq_buy_sell, cron_qrq_buy_sell_result, 
								cron_amo_buy_sell_search ,
								qrq_html_question, qrq_html_question_search
								
				убарть из request .php -> reqInsertCronAmoBuysellSearch
								
				убарть из ajax.php -> modal_admin_qrq , save_admin_qrq
								
	!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	 
	 
	 */
	 
class ClassQrq extends HtmlServive 
{
	
	// Получаем json по curl
	function getJsonCurl( $p=array() ){
		
			$url 			= $p['url'];
			$parameters 	= $p['parameters'];
			
			disConnect();

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			curl_close($ch);
			
			$json = json_decode($response);
			
			connect();

		return $json;
	}
	
	
	
	// Получаем токен Amo
	function AuthorizationAmo(){
		
			$url = DOMEN.'/qrq/amo/authorization.php';
		
			$parameters = [];

			$json = self::getJsonCurl(array('url'=>$url,'parameters'=>$parameters));
			
			$token = isset($json->token)? $json->token : '';

		return $token;
	}
	
	
	// Получаем поставщиков Amo
	function AmoVendors(){
		
			$tr = $code = '';
			$i = 0;
			
			$top = 'Поставщики (получение всех поставщиков и их складов)';
		
		
			$url = DOMEN.'/qrq/amo/vendors.php';
		
			$parameters = [
						'token' => AMO_TOKEN
						];

			$json = self::getJsonCurl(array('url'=>$url,'parameters'=>$parameters));
		//vecho($json);

			if(is_array($json)){
				
				foreach ($json as $item=>$m){
					
					$login = $pass = '';

					$id_v		= $m->id;
					$title 		= $m->title;
					$branches 	= $m->branches;
					
					$arr_b = array();
					if(is_array($branches)){
						foreach ($branches as $item_branches){
							$arr_b[ $item_branches->id ] = $item_branches->title;
						}
					}else{
						$arr_b[ 0 ] = '';
					}
					
					
					foreach ($arr_b as $k=>$a){
					
						$i++;
					
						$tr .= '	<tr>
									<td>
										'.$title.'
										<br/>
										'.$a.'
									</td>
									<td>'.$id_v.'<br/>'.$k.'</td>
								</tr>';
								
					}
							
						
				}
				
				if($tr){
					
						$code = '
								<table id="" class="table table-bordered table-hover" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;">
									<tbody>
										'.$tr.'
									</tbody>
								</table>';
				}
				
			}



		return array('top'=>$top , 'code'=>$code);
	}	
	
	
	// добавляем Аккаунт на Amo
	function AmoAccountsadd( $p=array() ){
		
		$in = fieldIn($p, array('vendorid','login','password','parent_id'));
		
		$id = $title = $errors_message = '';
		
			$url = DOMEN.'/qrq/amo/accountsadd.php';
		
			$parameters = [
						'token' 	=> AMO_TOKEN,
						'vendorid' 	=> $in['vendorid'],
						'login' 	=> $in['login'],
						'password' 	=> $in['password'],
						'filialid' 	=> $in['parent_id']

						];

			$json = self::getJsonCurl(array('url'=>$url,'parameters'=>$parameters));

			// пишем лог
			$ins_id = reqInsertAmoLogJson(array('url'=>'accountsadd','parameters'=>$parameters,'json'=>$json,'token'=>AMO_TOKEN));

			//vecho($parameters);
			//vecho($json);

			
			if($json){
				
					$Response	= $json->Response;

					$errors = $Response->errors;
					$errors_message 	= isset($errors[0]->message)?	 	$errors[0]->message 		: '';

					$warnings = $Response->warnings;//errors
					$warnings_message = isset($warnings[0]->message)? 	$warnings[0]->message 	: '';
					
					if( !$errors_message && !$warnings_message ){
						$id 	= $Response->entity->accounts[0]->id;
						$title = $Response->entity->accounts[0]->title;
					}else{
						$errors_message = $errors_message.' '.$warnings_message;
						// пишем ошибку и привязываем к общему json через parent_id
						reqInsertAmoLogJson(array('parent_id'=>$ins_id,'url'=>'accountsadd','parameters'=>$parameters,'json'=>$json,'token'=>AMO_TOKEN));
					}
			}

		return array('id'=>$id , 'title'=>$title , 'errors_message'=>$errors_message);
	}
	
	
	
	// удаляем Аккаунт на Amo
	function AmoAccountsDelete( $p=array() ){
		
		$in = fieldIn($p, array('accounts_id'));
		
		$rez = false;
		
			$url = DOMEN.'/qrq/amo/accountsdelete.php';
		
			$parameters = [
						'token' 	=> AMO_TOKEN,
						'accountid' => $in['accounts_id']
						];

			$json = self::getJsonCurl(array('url'=>$url,'parameters'=>$parameters));
			
			// пишем лог
			$ins_id = reqInsertAmoLogJson(array('url'=>'accountsdelete','parameters'=>$parameters,'json'=>$json,'token'=>AMO_TOKEN));

			//vecho($parameters);
			//vecho($json);
			
			if($json){
				
					$Response	= $json->Response;
					
					$errors = isset($Response->errors)? $Response->errors : '';
					$errors_message 	= isset($errors[0]->message)?	 	$errors[0]->message 		: '';

					$warnings = isset($Response->warnings)? $Response->warnings : '';//errors
					$warnings_message = isset($warnings[0]->message)? 	$warnings[0]->message 	: '';
							
					if( !$errors_message && !$warnings_message ){
								
							$rez = true;
							
					}else{
							
							// пишем ошибку и привязываем к общему json через parent_id
							reqInsertAmoLogJson(array('parent_id'=>$ins_id,'url'=>'accountsdelete','parameters'=>$parameters,'json'=>$json,'token'=>AMO_TOKEN));

							$errors_message = $errors_message.' '.$warnings_message;
							
					}

			}

		return array('rez'=>$rez , 'errors_message'=>$errors_message);
	}
	
	
	// Добавляем в базу задание cron
	function InsertCronAmoBuySell( $p=array() ){
		$ok = false;
		
		//$r = reqLoginCompanyPrava(array('login_id'=>LOGIN_ID,'company_id'=>1052,'one'=>true));// только сотрудник ООО ДИАЛКОМ
		
		//if($r['id']||LOGIN_ID==565){
		
		$r = reqAmoAccountsEtp(array('company_id'=>COMPANY_ID));//есть хотя бы один аккаунт на стороннем ресурсе
		
		if(!empty($r)){
		
			$in = fieldIn($p, array('buy_sell_id'));

			$r = reqBuySell_Amo(array('id' => $in['buy_sell_id']));
			
			// Допустимые категории
			$rc = reqSlovCategories(array('id'=>$r['categories_id']));
			$rc['parent_id'] = (isset($rc['parent_id'])&&!empty($rc['parent_id']))? $rc['parent_id'] : 0;
			$at = array(386,389,388);// допустимые категории 3 уровнея

			if((in_array($rc['parent_id'], $at))&&$r['flag_buy_sell']==2&&($r['status_buy_sell_id']==2||$r['status_buy_sell_id']==3)){
				
					$STH = reqInsertCronAmoBuySell(array('buy_sell_id'=>$in['buy_sell_id']));// добавляем id для cron
					
					if($STH){
						$ok = true;
					}
					
			}
			
		}
		

		return $ok;
	}
	
	
	// Добавляем в базу представление для всплывающего окна (Бренды от поставщиков)
	function AmoHtmlSearchbrend( $p=array() ){
		$code = $tr = $zagolovoc = $errors_message = '';
		
		$result = false;
		
		$arr_n = array();
		
		$row_bs = isset($p['row_bs'])? $p['row_bs'] : array('id'=>'','nomenclature_id'=>'');
		
		
		$url = DOMEN.'/qrq/amo/searchbrend.php';

		$parameters = [
					'token' 		=> $p['token'],
					'searchtext' 	=> $p['artname']
					];

		$json = self::getJsonCurl(array('url'=>$url,'parameters'=>$parameters));
		
		// пишем лог
		$ins_id = reqInsertAmoLogJson(array('url'=>'searchbrend','parameters'=>$parameters,'json'=>$json,'token'=>$p['token']));

		
		
//	vecho($json);		
		if($json){
			

			
			$Response	= $json->Response;

			$errors = $Response->errors;
			$errors_message 	= isset($errors[0]->message)?	 	$errors[0]->message 		: '';

			$warnings = $Response->warnings;//errors
			$warnings_message = isset($warnings[0]->message)? 	$warnings[0]->message 	: '';
			
			if( !$errors_message && !$warnings_message ){
					
					$result = true;
					
					$arr = isset($Response->entity->shortNumbers)&&!empty($Response->entity->shortNumbers)? $Response->entity->shortNumbers : array();
					
					if(!empty($arr)){
						
						if($p['flag']==1){// только через крон если заявки
								// получаем ранее закрепленные бренды за номенклатурой (для проставления галочек) (см. ajax->cron_amo_search)
								$r = reqNomenclatureAmoSearchbrend(array('nomenclature_id'=>$row_bs['nomenclature_id']));
								foreach($r as $i => $m){
									$i++;
									$arr_n[$i] = $m['brand'];
								}
						}
						
						foreach ($Response->entity->shortNumbers as $item){
							
							$brand 	= $item->brand;
							$article 	= $item->article;
							$partname	= $item->partname;
							
							
							$checked = '';
							// только через крон если заявки	
								if($p['flag']==1){
									$key = array_search($brand, $arr_n); // отмечен ранне бренд в данной номенклатуре ставим "галочку"
									if($key){
										$checked = 'checked';
									}
								}
							///
							
							
							$tr .= '	<tr>
										<td>'.$article.'</td>
										<td>
											<input type="checkbox" class="checkbox_qrq_article_id_'.$row_bs['id'].'" data-brand="'.$brand.'" value="" '.$checked.'/>
											'.$brand.'
										</td>
										<td>'.$partname.'</td>
									</tr>';
						}
					}else{
						$errors_message = 'Нет значений';
					}
			}else{
					$errors_message = $errors_message.' '.$warnings_message;
					
					// пишем ошибку и привязываем к общему json через parent_id
					reqInsertAmoLogJson(array('parent_id'=>$ins_id,'url'=>'searchbrend','parameters'=>$parameters,'json'=>$json,'token'=>$p['token']));

					
			}


			if($p['flag']==1){// только через крон если заявки

					if($tr){
						$code = '
								<div style="margin-top:20px;">
									<small>Заявка</small> <strong>'.$row_bs['name'].'</strong>
								</div>
								<table id="" class="table table-bordered table-hover" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;">
									<tbody>
										'.$tr.'
									</tbody>
								</table>
								'.$this->Input(	array(	'type'			=> 'button',
														'class'			=> 'change-btn form_buy_sell_hidden cron_amo_search',
														'value'			=> 'Записать',
														'data'			=> array(	'buy_sell_id'	=> $row_bs['id'],
																					'token'			=> $p['token'],
																					'searchtext'	=> $p['artname']
																					)
													)
											).'
								'.$this->Input(	array(	'type'			=> 'button',
														'class'			=> 'change-btn form_buy_sell_hidden delete_amo_html_searchbrend',
														'value'			=> 'Пропустить',
														'data'			=> array('buy_sell_id'=>$row_bs['id'])
													)
											).'
								';
							
							// очищаем и сохраняем html представление 
							$STH = PreExecSQL(" DELETE FROM amo_html_searchbrend WHERE buy_sell_id=?; " ,
																array( $row_bs['id'] ));
							reqInsertAmoHtmlSearchbrend(array('buy_sell_id'=>$row_bs['id'],'html'=>$code));
							/// 
							
					}
					
			}
			elseif($p['flag']==2){// из поискового поля, пользователь в поиске задает

					if($tr){
						$code = '
								<div style="margin-top:20px;">
									<small>Поиск</small> <strong>'.$p['artname'].'</strong>
								</div>
								<table id="" class="table table-bordered table-hover" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;">
									<tbody>
										'.$tr.'
									</tbody>
								</table>
								'.$this->Input(	array(	'type'			=> 'button',
														'class'			=> 'change-btn form_buy_sell_hidden search_brend_etp',
														'value'			=> 'Найти',
														'data'			=> array('categories_id' => $p['categories_id'])
													)
											).'
								'.$this->Input(	array(	'type'			=> 'button',
														'class'			=> 'change-btn form_buy_sell_hidden no_search_brend_etp',
														'value'			=> 'Пропустить'
													)
											).'
								';
					}
					
			}
			
					
		}
		

		return array( 'result' => $result , 'errors_message'=>$errors_message , 'code'=>$code );
	}
	
	// Получение бренда из /qrq/amo/searchbrend.php
	function getAmoHtmlSearchbrend( $p=array() ){
		
		$tr = '';
		$row = reqAmoHtmlSearchbrend(array('buy_sell_id'=>$p['buy_sell_id']));
		
		$tr = $row['html'];
			
		return array('content'=>$tr);
	}
	
	// получить Searchid по бренду и поставщикам
	function getSearchidBySearch( $p=array() ){

		$result = false;
		$errors_message = $searchid = '';
		//$in = fieldIn($p, array('buy_sell_id','article_id','brand'));
		
		
		$url = DOMEN.'/qrq/amo/search.php';


		$parameters = [
					'token' 		=> $p['token'],
					'brand' 		=> $p['brand'],
					'searchtext' 	=> $p['searchtext'],
					'accountid' 	=> $p['accountid']
					];


		$json = self::getJsonCurl(array('url'=>$url,'parameters'=>$parameters));
	
		// пишем лог
		$ins_id = reqInsertAmoLogJson(array('url'=>'search','parameters'=>$parameters,'json'=>$json,'token'=>$p['token']));
	

		
		if($json){
			
			$Response	= $json->Response;
	
			$errors = isset($Response->errors)? $Response->errors : '';
			$errors_message 	= isset($errors[0]->message)?	 	$errors[0]->message 		: '';

			$warnings = isset($Response->warnings)? $Response->warnings : '';//errors
			$warnings_message = isset($warnings[0]->message)? 	$warnings[0]->message 	: '';
//var_dump($json);
//var_dump($warnings);
			if( !$errors_message && !$warnings_message ){
				
					$searchid = $Response->entity->searchId;
					
					
			}else{
					$errors_message = $errors_message.' '.$warnings_message;
					
					// пишем ошибку и привязываем к общему json через parent_id
					reqInsertAmoLogJson(array('parent_id'=>$ins_id,'url'=>'search','parameters'=>$parameters,'json'=>$json,'token'=>$p['token']));

					
					vecho($errors_message);
			}
			
		}


		return array( 'searchid' => $searchid , 'errors_message'=>$errors_message );
	}
	
	
	// Добавляем в buy_sell предложения полученные после Searchid
	function QrqInsertBuySell( $p=array() ){

		$result = false;
		$flag_finished = 0;
		$errors_message = $r_p['company_id'] = $r_p['id'] = $finished = '';
		
		$in = fieldIn($p, array('where','buy_sell_id','login_id','company_id','categories_id','qrq_id','company_id_out','cookie_session'));
		
		$parent_id 	= 0;
		$categories_id	= $in['categories_id'];
		$get_buy_sell_id = $get_company_id = 0;
		$urgency_id = 5;
		
		
		
		$url = DOMEN.'/qrq/amo/searchupdate.php';
		

		$parameters = [
					'token' 		=> $p['token'],
					'searchid' 		=> $p['searchid']
					];


		$json = self::getJsonCurl(array('url'=>$url,'parameters'=>$parameters));
	
		// пишем лог
		$ins_id = reqInsertAmoLogJson(array('url'=>'searchupdate','parameters'=>$parameters,'json'=>$json,'token'=>$p['token']));
	
		if($in['where']=='buy_sell'){
			$r_p = reqBuySell_Amo(array('id' => $p['buy_sell_id']));
			$parent_id 		= $r_p['id'];
			$categories_id		= $r_p['categories_id'];
			$get_buy_sell_id 	= $r_p['id'];
			$get_company_id 	= $r_p['company_id'];
			$urgency_id 		= $r_p['urgency_id'];
			$url 				= 'offer';
			$flag_buy_sell 	= 2;
			$status 			= 10;
		}elseif($in['where']=='infopart'){
			$url 			= 'sell_etp';
			$flag_buy_sell = 1;
			$status 		= 2;
		}
		

		// в массив Бренд
		$arr3 = array();
		$row = reqAttributeValue(array('categories_id'=>$categories_id,'attribute_id'=>3,'flag'=>'buy_sell'));
		foreach($row as $i => $m){
			$arr3[ $m['id'] ] = mb_strtolower($m['attribute_value']);
		}
		///
		
		if($json){
			
			$Response	= $json->Response;
	
			$errors = isset($Response->errors)? $Response->errors : '';
			$errors_message 	= isset($errors[0]->message)?	 	$errors[0]->message 		: '';

			$warnings = isset($Response->warnings)? $Response->warnings : '';//errors
			$warnings_message = isset($warnings[0]->message)? 	$warnings[0]->message 	: '';
//var_dump($json);
//var_dump($warnings);
			
			if( !$errors_message && !$warnings_message ){
				
				//vecho($Response);
					
				if(isset($Response->entity->results)){
					
					foreach ($Response->entity->results as $item){
						
						$accountId 	= $item->accountId;
						$items 		= $item->items;
						
						$finished = $item->finished;
						if( $finished && !$flag_finished ){
							$finished = true;
						}else{
							$flag_finished = true;
							$finished = false;
						}
						
						
						// получаем qrq_id для привязки заявки к поставщику
							$r_aq = reqAmoAccountsEtp(array('accounts_id' => $accountId));
							$qrq_id 		= $r_aq['qrq_id'];
							$login_id		= $r_aq['login_id_etp'];
							$company_id	= $r_aq['company_id_etp'];
						///
						//vecho($qrq_id);
						
						if($qrq_id&&$login_id&&$company_id){
						
								$cities_id 	= 1;// по умолчанию
								
								//vecho($items);
								foreach ($items as $item){
										
										$item_id 		= $item->itemId;
										$title 		= $item->title;
										$comments 	= $item->notes;
										$brand 		= $item->brand;
										$article 		= $item->article;
										$delivery 		= $item->delivery;
										$city 		= $item->city;
										
										$cost		= $item->price->value;
										$amount		= $item->quantity->value;
										
										$delivery = preg_replace('/[^0-9]/', '', $delivery);
										
										if($city){// привязываем город
											$rc = reqAmoCitiesCitiesId(array('amo_cities_id'=>$city));
											$cities_id = !empty($rc['cities_id'])? $rc['cities_id'] : $cities_id;
										}
										
										vecho($qrq_id.'**'.$item_id.'**'.$title.'**'.$comments.'**'.$cost.'**'.$amount);
										
										$arr = reqInsertBuySell(array(	'login_id'			=> $login_id,
																		'company_id'		=> $company_id,
																		'company_id2'		=> 0,
																		'parent_id'			=> $parent_id,
																		'copy_id'			=> 0,
																		'flag_buy_sell'		=> $flag_buy_sell,
																		'status'			=> $status,
																		'name'				=> $title,
																		'url'				=> $url,
																		'cities_id'			=> $cities_id,
																		'categories_id'		=> $categories_id,
																		'urgency_id'		=> $urgency_id,
																		'currency_id'		=> 1,
																		'cost'				=> $cost,
																		'form_payment_id'	=> 1,
																		'amount'			=> $amount,
																		'comments'			=> $comments,
																		'comments_company'	=> '',
																		'responsible'		=> '',
																		'availability'		=> '',
																		'qrq_id'			=> $qrq_id,
																		'item_id'			=> $item_id
																		
																		));
																								
																			
										if($arr['STH']){// сохраняем параметры
												
												if($in['where']=='infopart'){
													// сохраняем понимание какая компания запросила объявления(предложение)
													$STH = PreExecSQL(" INSERT INTO buy_sell_etp_sell (buy_sell_id, company_id, cookie_session) VALUES (?,?,?); " ,
																				array( $arr['buy_sell_id'],$in['company_id_out'],$in['cookie_session'] ));
												}
								
										
												// есть ли такой Бренд в нашей базе
													// сохраняем бренд какой вернулся (учитывая регистр)
													$STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, value) VALUES (?,?,?); " ,
																						array( $arr['buy_sell_id'],2,$brand ));
												
													$key = array_search(mb_strtolower($brand), $arr3, true);
													
													if($key){
															$STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, attribute_value_id) VALUES (?,?,?); " ,
																							array( $arr['buy_sell_id'],3,$key ));	
													}else{
															// Если нет добавляем в slov_attribute_value -> attribute_value и возвращаем attribute_value_id 
															$arr_p = $this->ProverkaAndInsertSlovAttributeValue(array('flag'				=> 'qrq',
																													'categories_id'		=> $categories_id,
																													'attribute_id'		=> 3,
																													'attribute_value'	=> $brand ));
															$attribute_value_id 		= $arr_p['attribute_value_id']; 
															if($attribute_value_id){
																$arr3[ $attribute_value_id ] = mb_strtolower($brand);// добавляем новое значение, чтобы повторно не добавлять
																$STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, attribute_value_id) VALUES (?,?,?); " ,
																								array( $arr['buy_sell_id'],3,$attribute_value_id ));	
															}

													}
												///
												// сохраняем Артикул
													$STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, value) VALUES (?,?,?); " ,
																						array( $arr['buy_sell_id'],33,$article ));
												
												/*
												// сохраняем Код склада
												if($pCodeSklad){
													$STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, value) VALUES (?,?,?); " ,
																						array( $arr['buy_sell_id'],5,$pCodeSklad ));
												}
												// сохраняем ID детали
												if($pDetailId){
													$STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, value) VALUES (?,?,?); " ,
																						array( $arr['buy_sell_id'],6,$pDetailId ));
												}
												*/
												// сохраняем Срок (дн)
												if($delivery){
													$STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, value) VALUES (?,?,?); " ,
																						array( $arr['buy_sell_id'],7,$delivery ));
												}
										}
																		
																		
																		
								}
						}else{
							vecho('accountId = '.$accountId.' не найден в системе (не привязан)');
						}
						
					}
				}
			}else{
					$errors_message = $errors_message.' '.$warnings_message;
					
					// пишем ошибку и привязываем к общему json через parent_id
					reqInsertAmoLogJson(array('parent_id'=>$ins_id,'url'=>'searchupdate','parameters'=>$parameters,'json'=>$json,'token'=>$p['token']));

					
					vecho($errors_message);
			}
			
		}


		return array('finished' => $flag_finished , 'errors_message'=>$errors_message , 'company_id'=>$get_company_id , 'buy_sell_id'=>$get_buy_sell_id );
	}
	
	
	// Покупаем у стороннего ресурса
	function AmoOrderBuySell( $p=array() ){
		
		$in = fieldIn($p, array('amount','where'));
		$errors_message = $code = $json = '';
		
		$row_bs = $p['row'];
		
		if($row_bs['qrq_id']>0){
			
			
				$ra = reqAmoAccountsEtp_AccountsidByCompanyid(array('qrq_id'=>$row_bs['qrq_id'],'company_id'=>COMPANY_ID));// получаем accountid
						
			
			// 1 - Добавление товара в корзину
			
				$url = DOMEN.'/qrq/amo/cartadd.php';

				$parameters = [
							'token' 		=> AMO_TOKEN,
							'itemid' 		=> $row_bs['item_id'],
							'quantity' 		=> $p['amount'],
							'accountid' 	=> $ra['accounts_id']
							];

				$json = self::getJsonCurl(array('url'=>$url,'parameters'=>$parameters));
				//vecho($parameters);
				//vecho($json);
				if($json){
					
					// пишем лог
					$ins_id = reqInsertAmoLogJson(array('url'=>'cartadd','parameters'=>$parameters,'json'=>$json,'token'=>AMO_TOKEN));
					
					//vecho($parameters);
					//vecho($json);
					
					$Response	= isset($json->Response)? $json->Response : '';
					
					$errors = isset($Response->errors)? $Response->errors : '';
					$errors_message 	= isset($errors[0]->message)?	 	$errors[0]->message 		: '';

					$warnings = isset($Response->warnings)? $Response->warnings : '';//errors
					$warnings_message = isset($warnings[0]->message)? 	$warnings[0]->message 	: '';
			//var_dump($errors);
			//var_dump($warnings);
					if( !$errors_message && !$warnings_message ){
							
							
							/*
							$rap = reqAmoAccountsBasketParam(array('accounts_id'=>$ra['accounts_id']));
							$param = $rap['param'];
							*/
							// 2 - Получение корзины (без получении корзины не оформить заказ), появиться форма
							
							$url = DOMEN.'/qrq/amo/basket.php?token='.AMO_TOKEN.'&accountid='.$ra['accounts_id'].'&amount='.$p['amount'].'&buy_sell_id='.$row_bs['id'].'&where='.$in['where'];//.'&pparam='.$param
							$code = file_get_contents($url);
							//vecho($url);
							//vecho($code);
	/*
							$url = DOMEN.'/qrq/amo/basket.php';

							$parameters = [
										'token' 		=> AMO_TOKEN,
										'accountid' 	=> $ra['accounts_id'],
										'amount' 		=> $p['amount'],
										'buy_sell_id' 	=> $row_bs['id'],
										'where' 		=> $in['where'],
										'param'			=> $param
										];

							$code = self::getJsonCurl(array('url'=>$url,'parameters'=>$parameters));
							//vecho($code);
	*/
					}else{
						$errors_message = $errors_message.' '.$warnings_message;
						
						// пишем ошибку и привязываем к общему json через parent_id
						reqInsertAmoLogJson(array('parent_id'=>$ins_id,'url'=>'cartadd','parameters'=>$parameters,'json'=>$json,'token'=>AMO_TOKEN));
						
					}
					
				}
				
		}


		return array('error'=>$errors_message,'code'=>$code,'json'=>$json);
	}
	
	
	
	// добавить к аккаунту "Этп" vendorid с наименованием
	function AdminTrEtpAccountVendorid( $p=array() ){
		
		$in = fieldIn($p, array('company_id','flag'));
		
		$code = '';
		
		$arr_empty = array(array('id'=>0,'promo'=>'','flag_autorize'=>'','vendorid'=>'','qrq'=>''));
		
		$r = ($in['flag']=='add_new')? 	$arr_empty
										: reqSlovQrq(array('company_id'=>$in['company_id']));
										
		$r = (!empty($r))? $r : $arr_empty;
		

		foreach($r as $i => $m){
				
				$button_connect = '';
				if($m['id']>0){
					$button_connect = (!$m['flag_amo_accounts_etp'])? 	'<span class="btn-blue connect_admin_slov_qrq" data-id="'.$m['id'].'" data-company_id="'.$in['company_id'].'" data-flag="insert">Подключить</span>' 
																	: '<span class="btn-blue connect_admin_slov_qrq" data-id="'.$m['id'].'" data-company_id="'.$in['company_id'].'" data-flag="delete">Отключить</span>';
				}
				
				$code .= '	<div class="profile-wrapper company-wrapper">
									<div class="profile-info">
										<div class="form-group">
											<label for="active" class="">Промо</label>
											<label class="switch">
												'.$this->Input(	array(	'type'		=> 'checkbox',
																		'id'		=> 'promo'.$m['id'],
																		'class'		=> 'primary',
																		'value'		=> ($m['promo']==1)? '1' 		: '',
																		'dopol'		=> ($m['promo']==1)? 'checked' 	: ''
																		)
																).'
												<span class="slider round"></span>
											</label>
										</div>
									</div>
									<div class="profile-info">
										<div class="form-group">
											<label for="active" class="">Без входа</label>
											<label class="switch">
												'.$this->Input(	array(	'type'		=> 'checkbox',
																		'id'		=> 'flag_autorize'.$m['id'],
																		'class'		=> 'primary',
																		'value'		=> ($m['flag_autorize']==1)? '1' 		: '',
																		'dopol'		=> ($m['flag_autorize']==1)? 'checked' 	: ''
																		)
																).'
												<span class="slider round"></span>
											</label>
										</div>
									</div>
									<div class="profile-info">
										<div class="form-group">
											'.$this->Input(	array(	'type'			=> 'text',
																	'id'			=> 'vendorid'.$m['id'],
																	'class'			=> 'form-control',
																	'value'			=> $m['vendorid'],
																	'placeholder'	=> 'vendorid'
																)
														).'
										</div>
									</div>
									<div class="profile-info">
										<div class="form-group">
											'.$this->Input(	array(	'type'			=> 'text',
																	'id'			=> 'qrq'.$m['id'],
																	'class'			=> 'form-control',
																	'value'			=> $m['qrq'],
																	'placeholder'	=> 'Наименование'
																)
														).'
										</div>
									</div>
									<div class="form-group">
											<span class="btn-blue save_admin_slov_qrq" data-id="'.$m['id'].'" data-company_id="'.$in['company_id'].'">Сохранить</span>
									</div>
									<div class="form-group">
											'.$button_connect.'
									</div>
							</div>
							';
		}
	
		$code = ($m['id'])? 	$code.'
							<div class="form-group">
									<span class="btn-blue add_tr_admin_slov_qrq" data-company_id="'.$in['company_id'].'">Добавить vendorid</span>
							</div>'
							: $code;
	
	
	
		return $code;
	}
	
	
	// Добавить задание в CRON (получить результат предложений после выбора брендов страница InfoPart)
	function InsertcronAmoBuySellSearchInfopart( $p=array() ){

		$ok = false;

		$categories_id = $p['categories_id'];

		foreach($p['values'] as $k=>$m){
			
				$r = reqAmoAccountsEtp_AccountsidByCompanyid(array('company_id'=>COMPANY_ID));

				
				foreach($r as $kk=>$mm){// далее вызываем в ./cron/cron_amo_buy_sell_search_infopart.php
						
						// получаем searchid для дальнейшего сохранения в крон
							$arr = self::getSearchidBySearch(array(	'token'				=> $_SESSION['AMO_TOKEN'],
																	'brand'				=> $m['brand'],
																	'searchtext'		=> $p['searchtext'],
																	'accountid'			=> $mm['accounts_id']	));
							/*if($arr['searchid']){
								$STH = reqInsertCronAmoBuysellSearchUpdate(array(	'buy_sell_id'		=> $in['buy_sell_id'],
																					'token'				=> $in['token'],
																					'searchid'			=> $arr['searchid']	));
							}
							*/
						///
						if($arr['searchid']){
								$STH = PreExecSQL(" INSERT INTO cron_amo_buy_sell_search_infopart (token,searchid,login_id,company_id,categories_id,qrq_id,company_id_out,cookie_session) VALUES (?,?,?,?,?,?,?,?); " ,
													array( $_SESSION['AMO_TOKEN'],$arr['searchid'],$mm['login_id'],$mm['company_id'],$categories_id,$mm['qrq_id'],COMPANY_ID,COOKIE_SESSION ));
								if($STH){
									$ok = true;
								}
						}
				}
				
		}
		
		return array('ok'=>$ok);
		
	}
	
	
	/* переделано в 
	// получить результат предложений после выбора брендов (cron/cron_amo_buy_sell_search_infopart.php)
	function getSellByAmoAccountsEtp( $p=array() ){
	
		$errors_message = '';

		$url = DOMEN.'/qrq/amo/search.php';

		$parameters = [
					'token' 		=> $p['token'],
					'brand'			=> $p['brand'],
					'searchtext'	=> $p['searchtext'],
					'accountid' 	=> $p['accountid']
					];


		$json = self::getJsonCurl(array('url'=>$url,'parameters'=>$parameters));
	
		
		
		// в массив Бренд
		$arr3 = array();
		$row = reqAttributeValue(array('categories_id'=>$p['categories_id'],'attribute_id'=>3,'flag'=>'buy_sell'));
		foreach($row as $i => $mv){
			$arr3[ $mv['id'] ] = mb_strtolower($mv['attribute_value']);
		}
		///
		
		
		if($json){
			
			$Response	= $json->Response;
	
			$errors = isset($Response->errors)? $Response->errors : '';
			$errors_message 	= isset($errors[0]->message)?	 	$errors[0]->message 		: '';

			$warnings = isset($Response->warnings)? $Response->warnings : '';//errors
			$warnings_message = isset($warnings[0]->message)? 	$warnings[0]->message 	: '';
		//var_dump($json);
		//var_dump($warnings);
			if( !$errors_message && !$warnings_message ){
				
					$result = true;
					
					foreach ($Response->entity->results as $item){
						
						$items 		= $item->items;

						$cities_id 	= 33653;// НАДО Фактический...думаем
						
						//vecho($items);
						foreach ($items as $item){
								
								$item_id 		= $item->itemId;
								$title 		= $item->title;
								$comments 	= $item->notes;
								$brand 		= $item->brand;
								$article 		= $item->article;
								$delivery 		= $item->delivery;
								
								$cost		= $item->price->value;
								$amount		= $item->quantity->value;
								
								$delivery = preg_replace('/[^0-9]/', '', $delivery);
								
								//vecho($qrq_id.'**'.$item_id.'**'.$title.'**'.$comments.'**'.$cost.'**'.$amount);
								
								$arr = reqInsertBuySell(array(	'login_id'			=> $p['login_id'],
																'company_id'		=> $p['company_id'],
																'company_id2'		=> 0,
																'parent_id'			=> 0,
																'copy_id'			=> 0,
																'flag_buy_sell'		=> 1, // объявление
																'status'			=> 2,
																'name'				=> $title,
																'url'				=> 'sell_etp',
																'cities_id'			=> $cities_id,
																'categories_id'		=> $p['categories_id'],
																'urgency_id'		=> 5,
																'currency_id'		=> 1,
																'cost'				=> $cost,
																'form_payment_id'	=> 1,
																'amount'			=> $amount,
																'comments'			=> $comments,
																'comments_company'	=> '',
																'responsible'		=> '',
																'availability'		=> '',
																'qrq_id'			=> $p['qrq_id'],
																'item_id'			=> $item_id
																
																));
																
																	
								if($arr['STH']){// сохраняем параметры
								
										// сщхраняем понимание какая компания запросила объявления(предложение)
										$STH = PreExecSQL(" INSERT INTO buy_sell_etp_sell (buy_sell_id, company_id, cookie_session) VALUES (?,?,?); " ,
																				array( $arr['buy_sell_id'],$p['company_id_out'],$p['cookie_session'] ));
										
								
										// есть ли такой Бренд в нашей базе
											// сохраняем бренд какой вернулся (учитывая регистр)
											$STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, value) VALUES (?,?,?); " ,
																				array( $arr['buy_sell_id'],2,$brand ));
										
											$key = array_search(mb_strtolower($brand), $arr3, true);
											
											if($key){
													$STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, attribute_value_id) VALUES (?,?,?); " ,
																					array( $arr['buy_sell_id'],3,$key ));	
											}else{
													// Если нет добавляем в slov_attribute_value -> attribute_value и возвращаем attribute_value_id 
													$arr_p = $this->ProverkaAndInsertSlovAttributeValue(array('flag'				=> 'qrq',
																											'categories_id'		=> $categories_id,
																											'attribute_id'		=> 3,
																											'attribute_value'	=> $brand ));
													$attribute_value_id 		= $arr_p['attribute_value_id']; 
													if($attribute_value_id){
														$arr3[ $attribute_value_id ] = mb_strtolower($brand);// добавляем новое значение, чтобы повторно не добавлять
														$STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, attribute_value_id) VALUES (?,?,?); " ,
																						array( $arr['buy_sell_id'],3,$attribute_value_id ));	
													}

											}
										///
										// сохраняем Артикул
											$STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, value) VALUES (?,?,?); " ,
																				array( $arr['buy_sell_id'],33,$article ));
									
										// сохраняем Срок (дн)
										if($delivery){
											$STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, value) VALUES (?,?,?); " ,
																				array( $arr['buy_sell_id'],7,$delivery ));
										}
								}
																
														
																
						}
						
						
					}
			}else{
					$errors_message = $errors_message.' '.$warnings_message;
					
			}
			
		}
						
						
		return array('error'=>$errors_message);
	}
	*/
	
	
	// Получение текста ошибки из json возвращаемое Этп
	function getErrorsMessageByJson( $p=array() ){	
	
		$json = $p['json'];
		
		$Response	= $json->Response;
					
		$errors = isset($Response->errors)? $Response->errors : '';
		
		$errors_message 	= isset($errors[0]->message)?	 	$errors[0]->message 		: '';
		$errors_code 		= isset($errors[0]->code)?	 	$errors[0]->code 		: '';
		
		$errors_message1 	= isset($errors[1]->message)?	 	$errors[1]->message 		: '';
		$errors_code1 	= isset($errors[1]->code)?	 	$errors[1]->code 		: '';

		$warnings 		= isset($Response->warnings)?	 $Response->warnings : '';
		$warnings_message = isset($warnings[0]->message)? 	$warnings[0]->message 	: '';
		$warnings_code 	= isset($warnings[0]->code)? 		$warnings[0]->code 	: '';
		
		$errors_message = $errors_message.' '.$warnings_message;//по умолчанию
		
		if($errors_code==0 && $warnings_code>0){
				$errors_code 		= $warnings_code;
				$errors_message 	= $warnings_message;
		}

		if($errors_code1){
				$errors_code 		= $errors_code1;
				$errors_message 	= $errors_message1;
		}
		
	
		return $errors_message;
	}
	
	
	
	function ProverkaErrorsMessageByAmoNameErrorEtp( $p=array() ){	
	
		$in = fieldIn($p, array('errors_message','buy_sell_id','amount','where'));
	
		$rez	= $next_etp = false;
		$button_next_etp = $errors_message = '';
	
		$r = reqAmoNameErrorEtp();
		
		foreach($r as $i => $m){
			
				$pos = strpos($in['errors_message'], $m['name_error_etp']);
				if ($pos === false) {
					//
				} else {
					$rez				= true;
					$next_etp			= $m['next_etp'];
					$errors_message 	= $m['name_error_qrq'];
					break;
				}
			
		}


		$button_next_etp = $this->Input(	array(	'type'			=> 'button',
											'class'			=> 'change-btn form_buy_sell_hidden next_etp_stop_amo_basket',
											'value'			=> 'Пропустить'
										)
								);

		if($next_etp){
			$button_next_etp = 
						'<div style="margin-top:30px;">
							'.$this->Input(	array(	'type'			=> 'button',
													'class'			=> 'change-btn form_buy_sell_hidden next_etp_next_amo_basket',
													'value'			=> 'Оформить',
													'data'			=> array(	'buy_sell_id' 	=> $in['buy_sell_id'],
																				'amount'		=> $in['amount'],
																				'where'			=> $in['where'] )
											)
										).'
							'.$button_next_etp.'
						</div>';
		}else{
			$button_next_etp = 
						'<div style="margin-top:30px;">
							'.$button_next_etp.'
						</div>';
		}


		$code = '<div style="padding:20px;">'.$errors_message.$button_next_etp.'</div>';
		



		return array( 'rez'=>$rez , 'next_etp'=>$next_etp , 'code'=>$code );
	}


	// посадить к нам в базу города из qwep
	function InsertAmoCity( $p=array() ){
		
		
		$url = 'https://questrequest.ru/qrq/amo/city.php';
		
		$parameters = [
					'token' 		=> '73b7d210f74223b6cf3f35f63b8da6ed63fd45c8'
					];

		$json = self::getJsonCurl(array('url'=>$url,'parameters'=>$parameters));

			
		if($json){
			

			
			$Response	= $json->Response;

			$errors = $Response->errors;
			$errors_message 	= isset($errors[0]->message)?	 	$errors[0]->message 		: '';

			$warnings = $Response->warnings;//errors
			$warnings_message = isset($warnings[0]->message)? 	$warnings[0]->message 	: '';
			
			if( !$errors_message && !$warnings_message ){
					
				
				$STH = PreExecSQL(" DELETE FROM amo_cities; " ,
														array());
				
				foreach ($Response->entity->cities as $item){
						
						$id 		= $item->id;
						$rid 		= $item->rid;
						$title 	= $item->title;
						
						// сохраняем
						$STH = PreExecSQL(" INSERT INTO amo_cities (id, rid, title) VALUES (?,?,?); " ,
														array( $id,$rid,$title ));
									
						
				}
					
			}
			
		}
		

		return '';
	}



	
}
?>