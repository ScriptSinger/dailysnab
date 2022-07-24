<?php // Склад
	class Controllers_Stock extends core_BaseController
	{
		function __construct()
		{
			parent::__construct();
			
			if(LOGIN_ID){
					$status_buy_sell_id = getArgs(1);
					$stock_id 		= getArgs(2);
					// Поиск
						$value = getGets('value');
					///	
					/*
					$row = reqMyStockBuySell(array(	'status_buy_sell_id' 	=> $status_buy_sell_id,
													'stock_id' 				=> $stock_id,
													'start_limit'			=> 0,
													'value' 				=> $value ));
					*/
					$this->stock = array(	
										'stock_id' 				=> $stock_id,
										'status_buy_sell_id' 	=> $status_buy_sell_id,
										'value' 				=> $value
											);
			
					$this->title = 'Склад';						
					

			}else{
				redirect('/');
			}
			
		}
	}
?>