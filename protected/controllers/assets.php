<?php // Активы
	class Controllers_Assets extends core_BaseController
	{
		function __construct()
		{
			parent::__construct();
			
			if(LOGIN_ID){
				
					$status_buy_sell_id = getArgs(1);
					// Поиск
						$value = getGets('value');
					///	
				
					$row = reqMyBuySell(array(	'company_id'			=> COMPANY_ID,
												'flag_buy_sell' 		=> 4,
												'status_buy_sell_id' 	=> $status_buy_sell_id,
												'start_limit'			=> 0,
												'value' 				=> $value ));

					$this->assets = array(	'row' 					=> $row,
											'status_buy_sell_id' 	=> $status_buy_sell_id
										);
			
					$this->title = 'Активы';
			
			}else{
				redirect('/');
			}
			
		}
	}
?>