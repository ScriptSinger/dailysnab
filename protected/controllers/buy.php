<?php //  Заявки пользователей
	class Controllers_Buy extends core_BaseController
	{
		function __construct()
		{
			parent::__construct();

				$router = new AltoRouter();	
				
				$router->map('GET|POST', '/', 'home#index', 'home');
				$router->map('GET', '/buy/*', 'home#buy', 'home_buy');
				$router->map('GET','/buy/[:action]',  'buy#show' , 'buy_show');	
				$router->map('GET','/buy/[:trailing]/[:action]',  'buy#city' , 'buy_city');	
				//$router->map('GET','/buy/v/[*:trailing]',  'buy#search' , 'buy_search');
				//$router->map('GET','/buy/[:action]/v/[*:trailing]',  'buy#search' , 'buy_search');					
				// $router->map('GET', '/buy/', ['c' => 'Controllers_Buy']);
				
				$match = $router->match();
				
				if (!empty($match['params']['action'])){
					$sql = "SELECT id FROM slov_categories WHERE url_categories =?";
					$id_cat = PreExecSQL_one($sql,array($match['params']['action']));
				}
				
				if (!empty($match['params']['trailing'])){				
					$sql_city = "SELECT id FROM a_cities WHERE url_cities =?";
					$id_city = PreExecSQL_one($sql_city,array($match['params']['trailing']));
				}
					
				if( (empty($id_cat["id"]) && empty($_GET['categories_id'])) || empty($_GET['value']) ){
					//echo '404';
					//redirect('/');	
				}					
				//echo $id_city["id"].'<br />';
				//var_dump($match['params']);

				$flag_interests	= getGets('interests');
				$interests_id	= getGets('interests_id');
				$share_url 	= getGets('share');
				
				$row_share 		= array('share_url'=>'');
				$row_subscriptions 	= array();
				if($share_url){// проверяем 
					$row_share 		= reqBuySellShare(array('share_url'=>$share_url));
					$row_subscriptions 	= (COMPANY_ID)? reqSubscriptions(array('one'=>true,'company_id_in'=>COMPANY_ID,'company_id_out'=>$row_share['company_id_from'])) : array();
				}
				
				// Модальное окно вопросов от сторонних сервисов
				if(getGets('modal')){
						$this->modal_start = array('flag'=>'modal_qrq_search');// всплывающее окно при загрузке страницы
				}
				
				// отмечен хоть один интерес
					$r = reqInterestsCompanyParamByOneInterest();
					$flag_interests2 = ($r['kol']>0)? true : false;
				///

				
				// Поиск
					//$categories_id	=  $id_cat["id"];  
					//$categories_id	= (!empty($_GET['categories_id'])) ? getGets('categories_id') : $id_cat["id"];		
					//$cities_id 	= getGets('cities_id');
					//$cities_id	= (!empty($_GET['cities_id'])) ? getGets('cities_id') : $id_city["id"];	
					$categories_id	= (!empty($match['params']['action'])) ? $id_cat["id"] : '';
					$cat_id	= (!empty($match['params']['action'])) ? $id_cat["id"] : ''; 
					$cities_id	= (!empty($match['params']['trailing'])) ? $id_city["id"] : '';	
					$value 		= trim(getGets('value')); 
					$flag_search 	= getGets('flag');
				///

				// вложенные parent_id в родительский id
				if($categories_id){
					$r = reqUpDownTree(array('table'=>'slov_categories','id'=>$categories_id,'updown'=>'down','flag'=>false,'vkl'=>false));
					if(!empty($r)){					
							$categories_id = implode(', ', array_map(function ($r) { return $r['ids']; }, $r));
					}
				}
				///
				
				$this->buy = array( 	'row'				=> reqBuySell_pageBuy(array(//'parent_id'			=> 0,
																					'flag_buy_sell' 	=> 2,
																					'flag_interests' 	=> $flag_interests,
																					'interests_id'		=> $interests_id,
																					'share_url' 		=> $row_share['share_url'],
																					'categories_id' 	=> $categories_id,
																					'cities_id' 		=> $cities_id,
																					'value' 			=> $value,
																					'flag_search' 		=> $flag_search )),
									'row_np'			=> reqNotificationParamId_1011(),
									'row_share'			=> $row_share,
									'row_subscriptions'	=> $row_subscriptions,
									'flag_interests'	=> $flag_interests,
									'flag_interests2'	=> $flag_interests2,
									'categories_id'		=> $categories_id,
									'cat_id'			=> $cat_id,		//для вывода описания
									'cities_id'			=> $cities_id,
									'value'				=> $value,
									'share_url'			=> $share_url,
									'flag_search' 		=> $flag_search 	);
				
				$this->title = 'Заявки';


				// фиксируем последнее посещение
				$cn	= new ClassNotification();
				$cn->FixCompanyPageVisitedSend(array('page_id'=>1,'data_visited'=>'NOW()'));
		
		}
	}
?>