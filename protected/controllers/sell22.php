<?php //  Объявления пользователей
	class Controllers_Sell22 extends core_BaseController
	{
		function __construct()
		{
			parent::__construct();
			
				$router = new AltoRouter();	
					
				$router->map('GET|POST', '/', 'home#index', 'home');
				$router->map('GET', '/sell/*', 'home#sell', 'home_sell');
				$router->map('GET','/sell/[:action]',  'sell#show' , 'sell_show');	
				$router->map('GET','/sell/[:trailing]/[:action]',  'sell#city' , 'buy_city');	
				
				$match = $router->match();
				
				if (!empty($match['params']['action'])){
					$sql = "SELECT id FROM slov_categories WHERE url_categories =?";
					$id_cat = PreExecSQL_one($sql,array($match['params']['action']));
				}
				
				if (!empty($match['params']['trailing'])){				
					$sql_city = "SELECT id FROM a_cities WHERE url_cities =?";
					$id_city = PreExecSQL_one($sql_city,array($match['params']['trailing']));
				}
					
/* 				if( (empty($id_cat["id"]) && empty($_GET['categories_id'])) || empty($_GET['value']) ){
					echo '404';
					redirect('404');	
				} */								
			
				//$flag_buy_sell = getArgs(1);
				
				// Поиск
					$categories_id	= (!empty($match['params']['action'])) ? $id_cat["id"] : '';
					$cat_id	= (!empty($match['params']['action'])) ? $id_cat["id"] : '';
					$cities_id	= (!empty($match['params']['trailing'])) ? $id_city["id"] : '';	
					$value 		= getGets('value'); 
					$flag_search 	= getGets('flag');

				///
				
				$share_url 	= getGets('share');
				
				$etp			= getGets('etp');
				
				$row_share = array('share_url'=>'');
				if($share_url){// проверяем 
					$row_share = reqBuySellShare(array('share_url'=>$share_url));
				}
				
				
				// вложенные parent_id в родительский id
				if($categories_id){
					$r = reqUpDownTree(array('table'=>'slov_categories','id'=>$categories_id,'updown'=>'down','flag'=>false,'vkl'=>false));
					if(!empty($r)){					
							$categories_id = implode(', ', array_map(function ($r) { return $r['ids']; }, $r));
					}
				}
				///


				$this->sell22 = array( 	'row'		=> reqBuySell_PageSell(array(	'categories_id' 	=> $categories_id,
																				'cities_id' 		=> $cities_id,
																				'value' 			=> $value,
																				'flag_search' 		=> $flag_search,
																				'share_url' 		=> $row_share['share_url'],
																				'etp'				=> $etp	)),
									'categories_id'	=> $categories_id,
									'cat_id'		=> $cat_id,
									'etp'			=> $etp
									
								);
				
				$this->title = 'Объявления';

			
		}
	}
?>