<?php // Подписки
	class Controllers_Subscriptions extends core_BaseController
	{
		function __construct()
		{
			parent::__construct();
			
			if(LOGIN_ID&&PRAVA_2){				
				
					$views = getArgs(1);
					
					$views = ($views)? $views : 'profile';

					$value = '';
				
					// страница - Все пользователи
					if($views=='profile'){
							// Поиск
								$categories_id	= getGets('categories_id');
								$cities_id 	= getGets('cities_id');
								$value 		= getGets('value');
							///
						
							$row = $this->rowCompanySubscriptions(array( 	'views' 			=> $views,
																		'categories_id' 	=> $categories_id,
																		'cities_id' 		=> $cities_id,
																		'value' 			=> $value));
							/*$row = reqCompanySubscriptions(array('categories_id' 	=> $categories_id,
																'cities_id' 		=> $cities_id,
																'value' 			=> $value ));*/
							$this->subscriptions_profile_buy_sell = array(	'views'				=> $views,
																			'row' 				=> $row,
																			'value' 			=> $value
																		);
							$this->title = 'Все пользователи';
					}
					// страница - Покупатели
					elseif($views=='profile-buy'){
							$row = $this->rowCompanySubscriptions(array( 'views' => $views));
							/*$row = reqCompanySubscriptions(array('who2'=>1));*/
							$this->subscriptions_profile_buy_sell = array(	'views'			=> $views,
																			'row' 			=> $row,
																			'value' 		=> $value
																		);
							$this->title = 'Покупатели';
					}
					// страница - Продавцы
					elseif($views=='profile-sell'){
							$row = $this->rowCompanySubscriptions(array( 'views' => $views));
							/*$row = reqCompanySubscriptions(array('who1'=>1));*/
							$this->subscriptions_profile_buy_sell = array(	'views'			=> $views,
																			'row' 			=> $row,
																			'value' 		=> $value
																		);
							$this->title = 'Продавцы';
					}// страница - Подписки
					elseif($views=='my'){
							$row = $this->rowCompanySubscriptions(array( 'views' => $views));
							/*$row = reqCompanySubscriptions(array('flag'=>'subscriptions-my'));*/
							$this->subscriptions_profile_buy_sell = array(	'views'			=> $views,
																			'row' 			=> $row,
																			'value' 		=> $value
																		);
							$this->title = 'Подписки';
					}// страница - Подписчики
					elseif($views=='me'){
							$row = $this->rowCompanySubscriptions(array( 'views' => $views));
							/*$row = reqCompanySubscriptions(array('flag'=>'subscriptions-me'));*/
							$this->subscriptions_profile_buy_sell = array(	'views'			=> $views,
																			'row' 			=> $row,
																			'value' 		=> $value
																		);
							$cn	= new ClassNotification();
							$cn->FixCompanyPageVisitedSend(array('page_id'=>8,'data_visited'=>'NOW()'));
																		
							$this->title = 'Подписчики';
							
							// удаляем оповещение(маркеры)
							reqDeleteNotification(array('notification_id'=>13));
							
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