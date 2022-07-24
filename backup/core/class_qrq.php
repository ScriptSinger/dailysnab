<?php
	/*
	 *  Захват со стороних ресурсов
	удалить как перейдем на AMO из базы таблицы 
								cron_qrq_buy_sell, cron_qrq_buy_sell_result, 
								qrq_html_question, qrq_html_question_search
	 
	 
	 */
	 
class ClassQrq extends HtmlServive 
{
	
	// Получаем json по curl
	function getJsonCurl( $p=array() ){
		
			$url 			= $p['url'];
			$parameters 	= $p['parameters'];

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			curl_close($ch);
			
			$json = json_decode($response);

		return $json;
	}
	
	
	
	// Получаем токен Amo
	function AuthorizationAmo(){
		
			$url = 'https://questrequest.ru/qrq/amo/authorization.php';
		
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
		
		
			$url = 'https://questrequest.ru/qrq/amo/vendors.php';
		
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
					
						$delete = $add = '';
					
						// сохранены ли параметры у нас
							$r = reqAmoAccounts(array( 'vendorid'=>$id_v , 'company_id'=>COMPANY_ID , 'flag'=>'one'));
							//vecho($r);
							$id = $r['id'];
							if($id){
								$login 	= $r['login'];
								$pass 	= $r['password'];
								$delete	= '<span class="blue-button delete_amo_accounts" data-id="'.$id.'" data-id_v="'.$id_v.'" data-name="'.$title.'">удалить</span>';
							}else{
								$add		= '<span class="blue-button view_form_accountsadd" title="добавить поставщика" style="font-size:24px;"
																data-id="'.$id_v.'">+</span>';
							}
						///
						
						$tr .= '	<tr>
									<td>
										'.$title.'
										<br/>
										'.$a.' '.$add.' '.$delete.'
										<div id="div_form_accountsadd'.$id_v.'" style="display:none;">
											<div class="form-group">
												'.$this->Input(	array(	'type'			=> 'text',
																		'id'			=> 'login'.$i.'',
																		'value'			=> $login,
																		'placeholder'	=> 'Логин'
																	)
															).'
											</div>
											<div class="form-group">
												'.$this->Input(	array(	'type'			=> 'text',
																		'id'			=> 'pass'.$i.'',
																		'value'			=> $pass,
																		'placeholder'	=> 'Пароль'
																	)
															). '
											</div>
											<div class="form-group">
												'.$this->Input(	array(	
																		'type'			=> 'button',
																		'id'			=> 'button_'.$id_v.'',
																		'class'			=> 'btn-success save_accountsadd',
																		'value'			=> 'Записать',
																		'data'			=> array('value'=>$id_v,'i'=>$i,'id'=>$id,'parent_id'=>$k)
																	)
															). '
											</div>
										<div>
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
		
			$url = 'https://questrequest.ru/qrq/amo/accountsadd.php';
		
			$parameters = [
						'token' 	=> AMO_TOKEN,
						'vendorid' 	=> $in['vendorid'],
						'login' 	=> $in['login'],
						'password' 	=> $in['password'],
						'filialid' 	=> $in['parent_id']

						];

			$json = self::getJsonCurl(array('url'=>$url,'parameters'=>$parameters));

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
					}
			}

		return array('id'=>$id , 'title'=>$title , 'errors_message'=>$errors_message);
	}
	
	
	
	// удаляем Аккаунт на Amo
	function AmoAccountsDelete( $p=array() ){
		
		$in = fieldIn($p, array('accounts_id'));
		
		$rez = false;
		
			$url = 'https://questrequest.ru/qrq/amo/accountsdelete.php';
		
			$parameters = [
						'token' 	=> AMO_TOKEN,
						'accountid' => $in['accounts_id']
						];

			$json = self::getJsonCurl(array('url'=>$url,'parameters'=>$parameters));

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
		
		$r = reqAmoAccounts(array('company_id'=>COMPANY_ID , 'flag'=>'one'));//есть хотя бы один аккаунт на стороннем ресурсе
		
		if(!empty($r)){
		
			$in = fieldIn($p, array('buy_sell_id'));

			$r = reqBuySell(array('id' => $in['buy_sell_id']));
			
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
		$code = $tr = $zagolovoc = '';
		
		$result = false;
		
		$row_bs = $p['row_bs'];
		
		$url = 'https://questrequest.ru/qrq/amo/searchbrend.php';

		$parameters = [
					'token' 		=> $p['token'],
					'searchtext' 	=> $p['artname']
					];

		$json = self::getJsonCurl(array('url'=>$url,'parameters'=>$parameters));
			
			
		if($json){
			

			
			$Response	= $json->Response;

			$errors = $Response->errors;
			$errors_message 	= isset($errors[0]->message)?	 	$errors[0]->message 		: '';

			$warnings = $Response->warnings;//errors
			$warnings_message = isset($warnings[0]->message)? 	$warnings[0]->message 	: '';
			
			if( !$errors_message && !$warnings_message ){
					
					$result = true;
					
					foreach ($Response->entity->shortNumbers as $item){
						
						$brand 	= $item->brand;
						$article 	= $item->article;
						$partname	= $item->partname;
						
						$tr .= '	<tr>
									<td>'.$article.'</td>
									<td>
										<input type="checkbox" class="checkbox_qrq_article_id_'.$row_bs['id'].'" data-brand="'.$brand.'" value=""/>
										'.$brand.'
									</td>
									<td>'.$partname.'</td>
								</tr>';
					}
			}else{
					$errors_message = $errors_message.' '.$warnings_message;
			}

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
		

		return array('result' => $result , 'errors_message'=>$errors_message);
	}
	
	// Получение бренда из /qrq/amo/searchbrend.php
	function getAmoHtmlSearchbrend( $p=array() ){
		
		$tr = '';
		$row = reqAmoHtmlSearchbrend();
		foreach($row as $i => $m){
			$tr .= $m['html'];
		}
			
		return array('content'=>$tr);
	}
	
	// Добавляем в buy_sell предложения
	function QrqInsertBuySell( $p=array() ){

		$result = false;
		//$in = fieldIn($p, array('buy_sell_id','article_id','brand'));
		
		
		//$url = 'https://questrequest.ru/qrq/amo/search.php';
		$url = 'https://itel-app.ru/amo/search.php';
		//$url = 'https://dailysnab.beget.tech/qrq/amo/search.php';


		$parameters = [
					'token' 		=> $p['token'],
					'brand' 		=> $p['brand'],
					'searchtext' 	=> $p['searchtext'],
					'accountid' 	=> $p['accountid']
					];

		$json = self::getJsonCurl(array('url'=>$url,'parameters'=>$parameters));
	

	
		$r_p = reqBuySell(array('id' => $p['buy_sell_id']));
		

		// в массив Бренд
		$arr3 = array();
		$row = reqAttributeValue(array('categories_id'=>$r_p['categories_id'],'attribute_id'=>3,'flag'=>'buy_sell'));
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
				
					$result = true;
					
					foreach ($Response->entity->results as $item){
						
						$accountId 	= $item->accountId;
						$items 		= $item->items;
						
						
						// получаем qrq_id для привязки заявки к поставщику
							$r_aq = reqAmoAccounts(array('accounts_id' => $accountId , 'flag' => 'one'));
							$qrq_id 		= $r_aq['qrq_id'];
							$login_id		= $r_aq['login_id'];
							$company_id	= $r_aq['company_id_qrq'];
						///
						//vecho($qrq_id);
						
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
								
								vecho($qrq_id.'**'.$item_id.'**'.$title.'**'.$comments.'**'.$cost.'**'.$amount);
								
								$arr = reqInsertBuySell(array(	'login_id'			=> $login_id,
																'company_id'		=> $company_id,
																'company_id2'		=> 0,
																'parent_id'			=> $r_p['id'],
																'copy_id'			=> 0,
																'flag_buy_sell'		=> 2,
																'status'			=> 10,
																'name'				=> $title,
																'url'				=> 'offer',
																'cities_id'			=> $cities_id,
																'categories_id'		=> $r_p['categories_id'],
																'urgency_id'		=> $r_p['urgency_id'],
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
																											'categories_id'		=> $r_p['categories_id'],
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
						
					}
			}else{
					$errors_message = $errors_message.' '.$warnings_message;
					vecho($errors_message);
			}
			
		}


		return array('result' => $result , 'errors_message'=>$errors_message);
	}
	
	
	// Покупаем у стороннего ресурса
	function AmoOrderBuySell( $p=array() ){
		
		$in = fieldIn($p, array('amount','where'));
		$errors_message = $code = '';
		
		$row_bs = $p['row'];
		
		if($row_bs['qrq_id']>0){
			
			// 1 - Добавление товара в корзину
			
				$url = 'https://questrequest.ru/qrq/amo/cartadd.php';

				$parameters = [
							'token' 		=> AMO_TOKEN,
							'itemid' 		=> $row_bs['item_id'],
							'quantity' 		=> $p['amount']
							];

				$json = self::getJsonCurl(array('url'=>$url,'parameters'=>$parameters));
				
				$Response	= $json->Response;
				
				$errors = isset($Response->errors)? $Response->errors : '';
				$errors_message 	= isset($errors[0]->message)?	 	$errors[0]->message 		: '';

				$warnings = isset($Response->warnings)? $Response->warnings : '';//errors
				$warnings_message = isset($warnings[0]->message)? 	$warnings[0]->message 	: '';
		//var_dump($errors);
		//var_dump($warnings);
				if( !$errors_message && !$warnings_message ){
						
						
						$ra = reqAmoAccounts(array('qrq_id'=>$row_bs['qrq_id']));// получаем accountid
						
						// 2 - Получение корзины (без получении корзины не оформить заказ), появиться форма
						
						//$url = 'https://itel-app.ru/amo/basket.php?token='.AMO_TOKEN.'&accountid='.$ra['accounts_id'];
						$url = 'https://questrequest.ru/qrq/amo/basket.php?token='.AMO_TOKEN.'&accountid='.$ra['accounts_id'].'&amount='.$p['amount'].'&buy_sell_id='.$row_bs['id'].'&where='.$in['where'];

						$code = file_get_contents($url);
					
				}else{
					$errors_message = $errors_message.' '.$warnings_message;
				}
				
		}


		return array('error'=>$errors_message,'code'=>$code);
	}
	
	
	
	
	
	
	
	/*
	
	OLD
	
	*/
	
	
	
	
	// Доступ к ресурсу Autopiter, Armtek и ...
	function DostupQrq( $p=array() ){
		
		$in = fieldIn($p, array('qrq_id'));

		if($in['qrq_id']==1){// Autopiter 
			$user_id 		= '656881';
			$password	= '123456';
			$login_id		= 566;// в системе (40 старый)
			$company_id 	= 1071;// в системе (83 старый)
		}elseif($in['qrq_id']==2){// Armtek
			$user_id 		= 'snabdaily@gmail.com';
			$password	= 'Ar299792458';
			$login_id		= 567;// в системе (41 старый)
			$company_id 	= 1074;// в системе (85 старый)
		}

		return array('user_id'=>$user_id,'password'=>$password,'login_id'=>$login_id,'company_id'=>$company_id);
	}
	
	
	// Получаем данные по запросу с Autopiter
	function getResponseQrq( $p=array() ){

		$in = fieldIn($p, array('qrq_id','artname','artid','flag','count','brand','codesklad','detailid','price'));

		$in['artname'] = trim($in['artname']);
		
		$in['artid'] = str_replace(' ','',$in['artid']);

		$response = $url = '';
		
		$protocol=$_SERVER['PROTOCOL'] = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https' : 'http';

		if($in['qrq_id']==1){// Autopiter
			
			$arr = self::DostupQrq(array('qrq_id'=>1));
			
			if($in['flag']=='offer'){
				$url = $protocol.'://'.$_SERVER['SERVER_NAME'].'/qrq/autopiter/api/offers.php';
				//$url = $protocol.'://'.$_SERVER['SERVER_NAME'].'/qrq/autopiter/api/offers.php?artname='.$in['artname'].'&userid='.$arr['user_id'].'&password='.$arr['password'];
				//$response = file_get_contents($url);
			}elseif($in['flag']=='result'){
				$url = $protocol.'://'.$_SERVER['SERVER_NAME'].'/qrq/autopiter/api/result.php';
				//$url = $protocol.'://'.$_SERVER['SERVER_NAME'].'/qrq/autopiter/api/result.php?artid='.$in['artid'].'&userid='.$arr['user_id'].'&password='.$arr['password'];
				//$response = file_get_contents($url);
			}elseif($in['flag']=='order'){
				$url = $protocol.'://'.$_SERVER['SERVER_NAME'].'/qrq/autopiter/api/order.php';
				//$url = $protocol.'://'.$_SERVER['SERVER_NAME'].'/qrq/autopiter/api/order.php?detailid='.$in['detailid'].'&userid='.$arr['user_id'].'&password='.$arr['password'].'&count='.$in['count'].'&price='.$in['price'].'';
				//$response = @file_get_contents($url);
			}
			
		}elseif($in['qrq_id']==2){// Armtek
			
			$arr = self::DostupQrq(array('qrq_id'=>2));
			
			if($in['flag']=='offer'){
				$url = $protocol.'://'.$_SERVER['SERVER_NAME'].'/qrq/armtek/api/offers.php';
				//$url = $protocol.'://'.$_SERVER['SERVER_NAME'].'/qrq/armtek/api/offers.php?artname='.$in['artname'].'&userid='.$arr['user_id'].'&password='.$arr['password'];
				//$response = file_get_contents($url);
			}elseif($in['flag']=='result'){
				$url = $protocol.'://'.$_SERVER['SERVER_NAME'].'/qrq/armtek/api/result.php';
				//$url = $protocol.'://'.$_SERVER['SERVER_NAME'].'/qrq/armtek/api/result.php?artid='.$in['artid'].'&userid='.$arr['user_id'].'&password='.$arr['password'].'&brand='.$in['brand'].'';
				//$response = file_get_contents($url);
			}elseif($in['flag']=='order'){
				$url = $protocol.'://'.$_SERVER['SERVER_NAME'].'/qrq/armtek/api/order.php';
				//$url = $protocol.'://'.$_SERVER['SERVER_NAME'].'/qrq/armtek/api/order.php?artid='.$in['artid'].'&userid='.$arr['user_id'].'&password='.$arr['password'].'&price='.$in['price'].'&count='.$in['count'].'&codesklad='.$in['codesklad'].'&brand='.$in['brand'].'';
				//$response = @file_get_contents($url);
			}
			
		}
		
		
			$parameters = [
				'artname' 		=> $in['artname'],
				'artid' 		=> $in['artid'],
				'detailid'		=> $in['detailid'],
				'userid'        => $arr['user_id'],
				'password'      => $arr['password'],
				'price'     	=> $in['price'],
				'count'     	=> $in['count'],
				'codesklad'     => $in['codesklad'],
				'brand'     	=> $in['brand']
			];

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			curl_close($ch);

			
			// лог ссылок
				$dop = '';
				if($in['flag']=='order'){
					$dop = '***'.$response.'***';
				}
				$file = $_SERVER['DOCUMENT_ROOT'] .'/qrq.txt';
				$fp = fopen($file, "a");
				$mytext = date("Y-m-d H:i:s")." -  ".$in['flag']." -  ".$url." \r\n ".json_encode($parameters)." \r\n ".$dop;
				$test = fwrite($fp, $mytext);
				fclose($fp);		
			///
		
		

		return $response;
	}
	
	

	// Добавляем в базу представление для всплывающего окна
	function QrqHtmlQuestion( $p=array() ){
		$code = $tr = $zagolovoc = '';
		
		$response = self::getResponseQrq(array('qrq_id'=>$p['qrq_id'],'artname'=>$p['artname'],'flag'=>'offer'));
		
		if($p['qrq_id']==1){
			$zagolovoc = 'Autopiter';
		}elseif($p['qrq_id']==2){
			$zagolovoc = 'Armtek';
		}
		
		$r = reqBuySell(array('id' => $p['buy_sell_id']));

		$txt_result = json_decode($response);
		 
		

		if(is_array($txt_result)&&!empty($txt_result)){
			foreach ($txt_result as $item){
				$pArticleId 	= $item->ArticleId;
				$pCatalogName = $item->Brand;
				$pName 		= $item->Name;
				
				$tr .= '	<tr>
							<td>'.$pArticleId.'</td>
							<td>
								<input type="checkbox" class="checkbox_qrq_article_id'.$p['qrq_id'].'_'.$p['buy_sell_id'].'" data-article_id="'.$pArticleId.'" data-brand="'.$pCatalogName.'" value=""/>
								'.$pCatalogName.'
							</td>
							<td>'.$pName.'</td>
						</tr>';
			}
			
			if($tr){
				$code = '
						<div style="margin-top:20px;">
							<small>Заявка</small> <strong>'.$r['name'].'</strong>
						</div>
						'.$zagolovoc.'
						<table id="" class="table table-bordered table-hover" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;">
							<tbody>
								'.$tr.'
							</tbody>
						</table>
						'.$this->Input(	array(	'type'			=> 'button',
												'class'			=> 'change-btn form_buy_sell_hidden cron_qrq_offer',
												'value'			=> 'Записать',
												'data'			=> array('buy_sell_id'=>$p['buy_sell_id'],'qrq_id'=>$p['qrq_id'])
											)
									).'
						'.$this->Input(	array(	'type'			=> 'button',
												'class'			=> 'change-btn form_buy_sell_hidden delete_qrq_html_question',
												'value'			=> 'Пропустить',
												'data'			=> array('buy_sell_id'=>$p['buy_sell_id'],'qrq_id'=>$p['qrq_id'])
											)
									).'
						';
						
					// очищаем и сохраняем html представление offers
					$STH = PreExecSQL(" DELETE FROM qrq_html_question WHERE buy_sell_id=? AND qrq_id=?; " ,
														array( $p['buy_sell_id'],$p['qrq_id'] ));
					reqInsertQrqHtmlQuestion(array('buy_sell_id'=>$p['buy_sell_id'],'html_question'=>$code,'qrq_id'=>$p['qrq_id']));
					/// 
						
			}
		}


		return $code;
	}
	
	
	/*
	// Добавляем в buy_sell предложения
	function QrqInsertBuySell( $p=array() ){
		
		$in = fieldIn($p, array('buy_sell_id','qrq_id','article_id','brand'));
		
		$r_p 	= reqBuySell(array('id' => $in['buy_sell_id']));
		

		$response = self::getResponseQrq(array(	'flag'		=> 'result',
												'qrq_id'	=> $in['qrq_id'],
												'artid'		=> $in['article_id'],
												'brand'		=> $in['brand'] ));
		//vecho($response);
		// в массив Бренд
		$arr3 = array();
		$row = reqAttributeValue(array('categories_id'=>$r_p['categories_id'],'attribute_id'=>3,'flag'=>'buy_sell'));
		foreach($row as $i => $m){
			$arr3[ $m['id'] ] = mb_strtolower($m['attribute_value']);
		}
		///
		

		//$response = file_get_contents('https://qrq.ru/qrq/armtek/api/result.php?artid=1786639&userid=snabdaily@gmail.com&password=Ar299792458&brand=SCANIA');
		
		$tr = '';
		$txt_result = json_decode($response);

		if(is_array($txt_result)){

			foreach ($txt_result as $item){
				
					$iteminfo = $item->info;
					foreach ($iteminfo as $iteminfo1)
					{
						$tr = '';
						$pCodeSklad = $pDetailId = '';
						
						$pRegion = $iteminfo1->Region;
						$tr .= "Регион паставщика = ".$pRegion;
						$tr .= "<br>";

						$pCatalogName = $iteminfo1->Brand;
						$tr .= "Производитель = ".$pCatalogName;
						$tr .= "<br>";

						$pNumber = $iteminfo1->Number;
						$tr .= "Номер = ".$pNumber;
						$tr .= "<br>";

						$pName = $iteminfo1->Name;
						$tr .= "Наименование = ".$pName;
						$tr .= "<br>";

						$pNumberOfAvailable = $iteminfo1->NumberOfAvailable;
						$pNumberOfAvailable = preg_replace("/[^0-9]/", '', $pNumberOfAvailable);
						$tr .= "Наличае (шт) = ".$pNumberOfAvailable;
						$tr .= "<br>";

						$pNumberOfDaysSupply = $iteminfo1->NumberOfDaysSupply;
						$tr .= "Срок (дн) = ".$pNumberOfDaysSupply;
						$tr .= "<br>";

						$pSalePrice = $iteminfo1->SalePrice;
						$tr .= "Цена = ".$pSalePrice;
						$tr .= "<br>";

						$pRealTimeInProc = $iteminfo1->RealTimeInProc;
						$tr .= "Процент успешных заказов в % = ".$pRealTimeInProc;
						$tr .= "<br>";
						
						if(isset($iteminfo1->CodeSklad)){// Armtek
							$pCodeSklad = $iteminfo1->CodeSklad;
							$tr .= "Код склада = ".$pCodeSklad;
							$tr .= "<br>";
							$tr .= "<br>";
						}
						
						if(isset($iteminfo1->DetailId)){// Autopiter
							$pDetailId = $iteminfo1->DetailId;
							$tr .= "ID детали = ".$pDetailId;
							$tr .= "<br>";
							$tr .= "<br>";
						}
						
							
							
						$arr_lc = self::DostupQrq(array('qrq_id'=>$in['qrq_id']));
						
						$login_id		= $arr_lc['login_id'];
						$company_id 	= $arr_lc['company_id'];
						
						$cities_id 	= 33653;// НАДО Фактический...думаем
	
						//echo($tr);
						
						if($pNumberOfAvailable>0){
						
							$arr = reqInsertBuySell(array(	'login_id'			=> $login_id,
															'company_id'		=> $company_id,
															'company_id2'		=> 0,
															'parent_id'			=> $in['buy_sell_id'],
															'copy_id'			=> 0,
															'flag_buy_sell'		=> 2,
															'status'			=> 10,
															'name'				=> $pName,
															'url'				=> 'offer',
															'cities_id'			=> $cities_id,
															'categories_id'		=> $r_p['categories_id'],
															'urgency_id'		=> $r_p['urgency_id'],
															'currency_id'		=> 1,
															'cost'				=> $pSalePrice,
															'form_payment_id'	=> 1,
															'amount'			=> $pNumberOfAvailable,
															'comments'			=> "Процент успешных заказов в % = ".$pRealTimeInProc,
															'comments_company'	=> '',
															'responsible'		=> '',
															'availability'		=> '',
															'qrq_id'			=> $in['qrq_id']
															
															));
							if($arr['STH']){// сохраняем параметры
									// есть ли такой Бренд в нашей базе
										// сохраняем бренд какой вернулся (учитывая регистр)
										$STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, value) VALUES (?,?,?); " ,
																			array( $arr['buy_sell_id'],2,$pCatalogName ));
									
										$key = array_search(mb_strtolower($pCatalogName), $arr3, true);
										
										if($key){
												$STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, attribute_value_id) VALUES (?,?,?); " ,
																				array( $arr['buy_sell_id'],3,$key ));	
										}else{
												// Если нет добавляем в slov_attribute_value -> attribute_value и возвращаем attribute_value_id 
												$arr_p = $this->ProverkaAndInsertSlovAttributeValue(array('flag'				=> 'qrq',
																										'categories_id'		=> $r_p['categories_id'],
																										'attribute_id'		=> 3,
																										'attribute_value'	=> $pCatalogName ));
												$attribute_value_id 		= $arr_p['attribute_value_id']; 
												if($attribute_value_id){
													$arr3[ $attribute_value_id ] = mb_strtolower($pCatalogName);// добавляем новое значение, чтобы повторно не добавлять
													$STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, attribute_value_id) VALUES (?,?,?); " ,
																					array( $arr['buy_sell_id'],3,$attribute_value_id ));	
												}

										}
									///
									// сохраняем Артикул
										$STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, value) VALUES (?,?,?); " ,
																			array( $arr['buy_sell_id'],33,$pNumber ));
																			
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
									// сохраняем Срок (дн)
									if($pNumberOfDaysSupply){
										$STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, value) VALUES (?,?,?); " ,
																			array( $arr['buy_sell_id'],7,$pNumberOfDaysSupply ));
									}
							}
							
						}

					}
					
			}
			
		}
		
		//echo($tr);
		

		return '';
	}
	*/
/*
	// Покупаем у стороннего ресурса
	function QrqOrderBuySell( $p=array() ){
		
		$in = fieldIn($p, array('amount'));
		
		$error = '';
		
		$row_bs = $p['row'];
	
		// (пока только Autopiter, Armtek)
		if($row_bs['qrq_id']==1||$row_bs['qrq_id']==2){
			
				$row_5 		= reqBuySellAttribute(array('buy_sell_id'=>$row_bs['id'],'attribute_id'=>5,'one'=>true));
				$codesklad 	= $row_5['value'];
				
				$row_6 		= reqBuySellAttribute(array('buy_sell_id'=>$row_bs['id'],'attribute_id'=>6,'one'=>true));
				$detailid 		= $row_6['value'];
				
				$row_33 		= reqBuySellAttribute(array('buy_sell_id'=>$row_bs['id'],'attribute_id'=>33,'one'=>true));
				$artid 		= $row_33['value'];
				
				$row_2 		= reqBuySellAttribute(array('buy_sell_id'=>$row_bs['id'],'attribute_id'=>2,'one'=>true));
				$brand 		= $row_2['value'];// имено бренд возвращенный из /qrq/.../result.php
				
				// Заглушка на тестирование!
					//$artid		= '105310';
					//$count		= '1';// $in['amount']
					//$brand		= 'LE.MA.';
					//$codesklad	= 'MOV0006077';
				///
				
				$count = $in['amount'];
		
				if( ($row_bs['qrq_id']==1&&$detailid) || ($row_bs['qrq_id']==2&&$codesklad) ){
						// формируем запрос на покупку
						$response = self::getResponseQrq(array(	'qrq_id'	=> $row_bs['qrq_id'],
																'artid'		=> $artid,
																'flag'		=> 'order',
																'count'		=> $count,
																'brand'		=> $brand,
																'codesklad'	=> $codesklad,
																'detailid'	=> $detailid,
																'price'		=> $row_bs['cost'] ));
						$response = str_replace(array("\r\n", '\r\n',"\n\r", '\n\r', "\n", '\n', " "), "", $response);
						if(empty($response)||$response==''){// покупка не прошла
							$error = 'Покупка не прошла на стороннем ресурсе';
						}
						
				}else{
						$error = 'Покупка не прошла на стороннем ресурсе';
				}
		}


		return array('error'=>$error);
	}
*/


	// Добавляем в базу задание для поиска из сторонних ресурсов
	function QrqHtmlQuestionSearch( $p=array() ){
		$code = $tr = '';
		
		$response = self::getResponseQrq(array('artname'=>$p['artname'],'flag'=>'offer','qrq_id'=>$p['qrq_id']));
		
		// удаляем старое
			$STH = PreExecSQL(" DELETE FROM qrq_html_question_search WHERE qrq_id=? AND session_id=?; " ,
									array( $p['qrq_id'] , session_id() ));
		///
		
		
		if($p['qrq_id']==1){
			$zagolovoc = 'Autopiter';
		}elseif($p['qrq_id']==2){
			$zagolovoc = 'Armtek';
		}
		
		
		
		$txt_result = json_decode($response);
		if(is_array($txt_result)&&!empty($txt_result)){
			foreach ($txt_result as $item){
				$pArticleId 	= $item->ArticleId;
				$pCatalogName = $item->Brand;
				$pName 		= $item->Name;
				
				$tr .= ($pArticleId)? 
								'	<tr>
										<td>'.$pArticleId.'</td>
										<td>
											<input type="checkbox" class="checkbox_qrq_article_id" data-id="'.$pArticleId.'" value=""/>
											'.$pCatalogName.'
										</td>
										<td>'.$pName.'</td>
									</tr>' : '';
			}
			
			if($tr){
				$code = '
						<div style="margin-top:20px;">
							<small>'.$zagolovoc.'</small> <strong>'.$p['artname'].'</strong>
						</div>
						<table id="" class="table table-bordered table-hover" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;">
							<tbody>
								'.$tr.'
							</tbody>
						</table>
						'.$this->Input(	array(	'type'			=> 'button',
												'class'			=> 'change-btn form_buy_sell_hidden ',
												'value'			=> 'в Поиск',
												'data'			=> array('qrq_id'=>$p['qrq_id'])
											)
									).'
						';
						
				reqInsertQrqHtmlQuestionSearch(array('html_question'=>$code,'qrq_id'=>$p['qrq_id']));
						
			}
		}


		return $code;
	}

	// Вопросы от стороннех сервисов для ПОИСК
	function QrqSearch( $p=array() ){
		
		$tr = '';
		$row = reqQrqHtmlQuestionSearch();
		foreach($row as $i => $m){
			$tr .= $m['html_question'];
		}
			
		return array('content'=>$tr);
	}

}
?>