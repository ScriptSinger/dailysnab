<?php // Мои Заявки/Объявления
	class Controllers_BuySell extends core_BaseController
	{
		function __construct()
		{
			parent::__construct();
			
			if(LOGIN_ID){	
			
//vecho($_SESSION['prava']);
	
				$router = new AltoRouter();
				
			
				
				$url_priznak = getArgs(1);
				$status_buy_sell_id = getArgs(2);
					
				
					$ok = false;
					$flag_bso	= $company_id2 = $notification_id = $page_id = $search = $categories_id = $cities_id = $value = $flag_interests_invite = '';
				
			if($url_priznak=='sell'){
						$ok 				= true;
						$flag_buy_sell 	= 1;
						//$company_id2		= COMPANY_ID;
						$title 			= 'Объявления';
						
						
						$group = '';
						
				$router->map('GET|POST', '/', 'buysell#buysell', 'buysell');
				$router->map('GET', '/buy-sell/sell/*', 'buysell#sell', 'buysell_sell');
				$router->map('GET','/buy-sell/sell/[:action]',  'buysell_sell#show' , 'buysell_sell_show');	
				$router->map('GET','/buy-sell/sell/[:trailing]/[:action]',  'buysell_sell#city' , 'buysell_sell_city');	
				
				$match = $router->match();							
						
				
				if (!empty($match['params']['action'])){
					$sql = "SELECT id FROM slov_categories WHERE url_categories =?";
					$id_cat = PreExecSQL_one($sql,array($match['params']['action']));
				}
				
				if (!empty($match['params']['trailing'])){				
					$sql_city = "SELECT id FROM a_cities WHERE url_cities =?";
					$id_city = PreExecSQL_one($sql_city,array($match['params']['trailing']));
				}
				
				// Поиск
					$categories_id	= (!empty($match['params']['action'])) ? $id_cat["id"] : '';
					//$cat_id	= (!empty($match['params']['action'])) ? $id_cat["id"] : '';
					$cities_id	= (!empty($match['params']['trailing'])) ? $id_city["id"] : '';	
						
						
						// Поиск по наименованию
							$value 		= getGets('value');
						///
										
						
						
								//reqMyBuySell
						$row = reqMyBuySellCache(array(	'flag'					=> 'flag_my_sell',
														'status_buy_sell_id' 	=> $status_buy_sell_id,
														'active'				=> 1,
														'sbs_flag'				=> 1,
														'start_limit'			=> 0,
														'value' 				=> $value ));
						
						if($status_buy_sell_id==1){
							$notification_id	= 8;
							$page_id		= 4;// id - slov_page
						}elseif($status_buy_sell_id==11){
							$notification_id	= 5;
							$page_id		= 5;// id - slov_page
						}elseif($status_buy_sell_id==12){
							$notification_id	= 7;
							$page_id		= 6;// id - slov_page
						}elseif($status_buy_sell_id==14){
							$notification_id	= 6;
							$page_id		= 7;// id - slov_page
						}
			
			}elseif($url_priznak=='buy'){
				
						$ok 				= true;
						$flag_buy_sell 	= 2;
						$title 			= 'Заявки';
						
						
				$router->map('GET|POST', '/', 'buysell#buysell', 'buysell');
				$router->map('GET', '/buy-sell/buy/*', 'buysell#buy', 'buysell_buy');
				$router->map('GET','/buy-sell/buy/[:action]',  'buysell_buy#show' , 'buysell_buy_show');	
				$router->map('GET','/buy-sell/buy/[:trailing]/[:action]',  'buysell_buy#city' , 'buysell_buy_city');	
				
				$match = $router->match();							
						

				if (!empty($match['params']['action'])){
					$sql = "SELECT id FROM slov_categories WHERE url_categories =?";
					$id_cat = PreExecSQL_one($sql,array($match['params']['action']));
				}
				
				if (!empty($match['params']['trailing'])){				
					$sql_city = "SELECT id FROM a_cities WHERE url_cities =?";
					$id_city = PreExecSQL_one($sql_city,array($match['params']['trailing']));
				}
				
				// Поиск
					$id_cat["id"] = isset($id_cat["id"])? $id_cat["id"] : '';
				
					$categories_id	= (!empty($match['params']['action'])) ? $id_cat["id"] : '';
					//$cat_id	= (!empty($match['params']['action'])) ? $id_cat["id"] : '';
					$cities_id	= (!empty($match['params']['trailing'])) ? $id_city["id"] : '';							

						// Поиск по наименованию
							$value 		= getGets('value');
						/// 
						
						// Группировка выборки в "Мои заявки"
							$group 		= getGets('group');
						///	
						
						// проверяем это сотрудник или владелец компании
						$rp = reqMyBuySell_ProverkaInvite();
						$flag_interests_invite = (!empty($rp))? true : false;
						
					//vecho($match['params']);	
							
								//reqMyBuySell
						$row = reqMyBuySellCache(array(	'company_id'			=> COMPANY_ID,
														//'company_id2' 			=> $company_id2,
														'flag_buy_sell' 		=> $flag_buy_sell,
														'status_buy_sell_id' 	=> (int)$status_buy_sell_id,
														'active'				=> 1,
														'sbs_flag'				=> 1,
														'start_limit'			=> 0,
														'categories_id' 		=> $categories_id,
														'cities_id' 			=> $cities_id,
														'value' 				=> $value,
														'flag_interests_invite' => $flag_interests_invite,
														'group' 				=> $group
													));

						if($status_buy_sell_id==1){
							$notification_id = 3;
							$page_id		= 3;// id - slov_page
						}
					}
					
					
				
					if($ok){						
						$this->buy_sell = array( 	'flag_buy_sell' 		=> $flag_buy_sell,
												'status_buy_sell_id' 	=> $status_buy_sell_id,
												'row_buy_sell'			=> $row,
												// поиск
												'categories_id' 		=> $categories_id,
												'cities_id' 			=> $cities_id,
												'value' 				=> $value,
												'flag_interests_invite' => $flag_interests_invite,
												'group' 				=> $group
												//
											);
						
						// удаляем оповещение(маркеры)
						reqDeleteNotification(array('notification_id'=>$notification_id));
						
						// удаляем флаг, чтобы обновилось предложения не перегружая страницу
						reqDeleteBuysellRefreshAmoSearch();						
						
						// фиксируем последнее посещение страницы
						if($page_id){
							$cn	= new ClassNotification();
							$cn->FixCompanyPageVisitedSend(array('page_id'=>$page_id,'data_visited'=>'NOW()'));
						}
						
						$this->title = 'Мои '.$title;
					}else{
						$this->e404 = '';
						$this->title = 'Ошибка 404. Страница не найдена';
					}
			}else{
				redirect('/');
			}
			
		}
	}
?>