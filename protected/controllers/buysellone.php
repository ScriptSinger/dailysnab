<?php // Заявки/Объявления Просмотр
	class Controllers_BuySellOne extends core_BaseController
	{
		function __construct()
		{
			parent::__construct();
			
			$row = $GLOBALS['row_buysellone'];
			// проверка можно показывать или нет (показываем пользователям все объявления и заяки, которые ТОЛЬКО активны и опубликованы)
			// владельцу объявления/заяки показываем во всех статусах
			// после "подписки" добавить правило на опубликованные
			// также показываем "предложения" для кого предложение и владельца предложения
			if($row){
					$flag_offer	= false;
					$ok 			= false;
					$row_buy		= array();
					
					$title = $row['name'];
					
					if( $row['parent_id']==0 &&( $row['flag_subscriptions_company_in']||$row['status_buy_sell_id']==3||$row['company_id']==COMPANY_ID) ){
						$ok 			= true;
					}elseif($row['parent_id']){// Предложение - проверяем доступность, могут смотреть от кого заявка или кто дал предложение
						$r = reqBuySell_buysellone(array('id'=>$row['parent_id']));
						$r2 = reqBuySell_buysellone(array('parent_id'=>$r['id'],'company_id'=>COMPANY_ID,'one'=>true));
						if($r['company_id']==COMPANY_ID||$r2['company_id']==COMPANY_ID||$row['company_id']==COMPANY_ID||$row['company_id2']==COMPANY_ID){
							$ok 			= true;
							$flag_offer 	= true;
							$row_buy		= $r;// данные заяки (в случае предложения)
							$title = 'Предложение на '.$r['name'];
						}else{
							$ok = false;
						}
					}
		
					if($ok){
						$amount_recom	= getGets('amount');
						
						$this->buy_sell_one = array( 	'row' 			=> $row,
													'flag_offer'	=> $flag_offer,
													'row_buy'		=> $row_buy,
													'row_attribute'	=> reqBuySellAttributeSixParam(array(	'buy_sell_id'	=> $row['id'],
																											'categories_id'	=> $row['categories_id'])),
													'row_buy_offer'	=> (COMPANY_ID)? reqBuySellBuyOffer(array( 'buy_sell_id' => $row['id'] )) : array(),
													'amount_recom'	=> $amount_recom
												);
						
						// счетчик просмотров (для опубликованных и активных)
						if( $row['status_buy_sell_id']==2||$row['status_buy_sell_id']==3 ){
							reqInsertCounterBuysellone(array('buy_sell_id'=>$row['id']));
						}
						
						
						$this->title = $title;
					}else{
						$this->e404 = '';
						$this->title = 'Ошибка 404. Страница не найдена';	
					}
				
			}else{
				$this->e404 = '';
				$this->title = 'Ошибка 404. Страница не найдена';				
			}
			
		}
	}
?>