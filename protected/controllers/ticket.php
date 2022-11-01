<?php // Тикеты
	class Controllers_Ticket extends core_BaseController
	{
		function __construct()
		{
			parent::__construct();
			
			
				
					$views 	= getArgs(1);			 				
					$tid 	= getGets('tid');
						
					$admins = reqTicketAdmins();
					$adminsArr = explode(",", $admins['admins']);

					$this->ticket = array(	'rowt' 	=> reqTicketMessages(array( 'id' => $tid)), 
											'tid'	=> $tid,
													
											);										
					$this->title = 'Страница тикета '.$tid;	
							

							
					if (in_array(LOGIN_ID, $adminsArr)) {
					
					// страница - Ошибки
							if($views=='errors' ){
							 	
									$rowt = reqTicketMessages(array( 'ticket_flag' => 1));																	
									$rtcro = reqTicketChangeRulesOptions(array('status_1'=>1)); 
									$this->ticket = array(	'views'	=> $views,
															'rowt' 	=> $rowt,
															'rtcro' => $rtcro
																				);
									$this->title = 'Ошибки';
							}					
							// страница - Предложения
							elseif($views=='pred'){
									$rowt = reqTicketMessages(array( 'ticket_flag' => 2));
									$rtcro = reqTicketChangeRulesOptions(array('status_1'=>2));
									$this->ticket = array(	'views'	=> $views,
															'rowt' 	=> $rowt,
															'rtcro' => $rtcro
																				);
									$this->title = 'Предложения';
							}
							// страница - В работе
							elseif($views=='in_works'){
									$rowt = reqTicketMessages(array( 'ticket_flag' => 4));
									$rtcro = reqTicketChangeRulesOptions(array('status_1'=>4));
									$this->ticket = array(	'views'	=> $views,
															'rowt' 	=> $rowt,
															'rtcro' => $rtcro
																				);
									$this->title = 'В работе';
							}	
							// страница - Исполненные
							elseif($views=='done'){
									$rowt = reqTicketMessages(array( 'ticket_flag' => 7 ));
									//$rowt = reqTicketMessages(array( 'ticket_flag' => 7,'status' => 2 ));
									$rtcro = reqTicketChangeRulesOptions(array('status_1'=>7));
									$this->ticket = array(	'views'	=> $views,
															'rowt' 	=> $rowt,
															'rtcro' => $rtcro
																				);
									$this->title = 'Исполненные';
							}	
							// страница - Архив
							elseif($views=='arhiv'){
									$rowt = reqTicketMessages(array( 'ticket_flag' => 8 ));
									$rtcro = reqTicketChangeRulesOptions(array('status_1'=>8));
									$this->ticket = array(	'views'	=> $views,
															'rowt' 	=> $rowt,
															'rtcro' => $rtcro
																				);
									$this->title = 'Архив';
							}							
							// страница - Активные
							elseif($views=='active'){
									//$rowt = reqTicketMessages(array( 'status' => 1));
									$rowt = reqTicketMessages(array( 'ticket_flag' => 3));
									$rtcro = reqTicketChangeRulesOptions(array('status_1'=>3)); 
									$this->ticket = array(	'views'	=> $views,
															'rowt' 	=> $rowt,
															'rtcro' => $rtcro
																				);
									$this->title = 'Активные';
							} 
							// страница - На проверке
							elseif($views=='na_proverku'){
									$rowt = reqTicketMessages(array( 'ticket_flag' => 5));
									$rtcro = reqTicketChangeRulesOptions(array('status_1'=>5)); 
									$this->ticket = array(	'views'	=> $views,
															'rowt' 	=> $rowt,
															'rtcro' => $rtcro
																				);
									$this->title = 'На проверке';
							} 	
							// страница - Возвращено
							elseif($views=='vozvrat'){
									$rowt = reqTicketMessages(array( 'ticket_flag' => 6 ));
									$rtcro = reqTicketChangeRulesOptions(array('status_1'=>6)); 
									$this->ticket = array(	'views'	=> $views,
															'rowt' 	=> $rowt,
															'rtcro' => $rtcro
																				);
									$this->title = 'На возврат';
							} 							
							// страница - Отзывы
							elseif($views=='reviews'){
									$rowt = reqTicketMessages(array( 'ticket_flag' => 9));
									$this->ticket = array(	'views'	=> $views,
															'rowt' 	=> $rowt
																				);
									$this->title = 'Отзывы';
							}							
							// страница - FAQ
							elseif($views=='faq'){									
									$rowt = reqTicketMessages();									
									$this->ticket = array(	'views'	=> $views,
															'rowt' 	=> $rowt
															);
								$this->title = 'Частые вопросы';
							} else {}					
							
							
					} else {		

							// страница - Ошибки
							if($views=='errors' ){
							 	
									$rowt = reqTicketMessages(array( 'ticket_flag' => 1, 'owner_id' => COMPANY_ID));																	
									$rtcro = reqTicketChangeRulesOptions(array('status_1'=>1)); 
									$this->ticket = array(	'views'	=> $views,
															'rowt' 	=> $rowt,
															'rtcro' => $rtcro
																				);
									$this->title = 'Ошибки';
							}					
							// страница - Предложения
							elseif($views=='pred'){
									$rowt = reqTicketMessages(array( 'ticket_flag' => 2, 'owner_id' => COMPANY_ID));
									$rtcro = reqTicketChangeRulesOptions(array('status_1'=>2));
									$this->ticket = array(	'views'	=> $views,
															'rowt' 	=> $rowt,
															'rtcro' => $rtcro
																				);
									$this->title = 'Предложения';
							}
							// страница - В работе
							elseif($views=='in_works'){
									$rowt = reqTicketMessages(array( 'ticket_flag' => '4,3,5,6', 'owner_id' => COMPANY_ID));
									$rtcro = reqTicketChangeRulesOptions(array('status_1'=>4));
									$this->ticket = array(	'views'	=> $views,
															'rowt' 	=> $rowt,
															'rtcro' => $rtcro
																				);
									$this->title = 'В работе';
							}	
							// страница - Исполненные
							elseif($views=='done'){
									$rowt = reqTicketMessages(array( 'ticket_flag' => 7, 'owner_id' => COMPANY_ID ));
									//$rowt = reqTicketMessages(array( 'ticket_flag' => 7,'status' => 2 ));
									$rtcro = reqTicketChangeRulesOptions(array('status_1'=>7));
									$this->ticket = array(	'views'	=> $views,
															'rowt' 	=> $rowt,
															'rtcro' => $rtcro
																				);
									$this->title = 'Исполненные';
							}	
							// страница - Архив
							elseif($views=='arhiv'){
									$rowt = reqTicketMessages(array( 'ticket_flag' => 8, 'owner_id' => COMPANY_ID ));
									$rtcro = reqTicketChangeRulesOptions(array('status_1'=>8));
									$this->ticket = array(	'views'	=> $views,
															'rowt' 	=> $rowt,
															'rtcro' => $rtcro
																				);
									$this->title = 'Архив';
							}							
							// страница - Активные
							elseif($views=='active'){
									//$rowt = reqTicketMessages(array( 'status' => 1));
									$rowt = reqTicketMessages(array( 'ticket_flag' => 3, 'owner_id' => COMPANY_ID));
									$rtcro = reqTicketChangeRulesOptions(array('status_1'=>3)); 
									$this->ticket = array(	'views'	=> $views,
															'rowt' 	=> $rowt,
															'rtcro' => $rtcro
																				);
									$this->title = 'Активные';
							} 
							// страница - На проверке
							elseif($views=='na_proverku'){
									$rowt = reqTicketMessages(array( 'ticket_flag' => 5));
									$rtcro = reqTicketChangeRulesOptions(array('status_1'=>5)); 
									$this->ticket = array(	'views'	=> $views,
															'rowt' 	=> $rowt,
															'rtcro' => $rtcro
																				);
									$this->title = 'На проверке';
							} 	
							// страница - Возвращено
							elseif($views=='vozvrat'){
									$rowt = reqTicketMessages(array( 'ticket_flag' => 6 ));
									$rtcro = reqTicketChangeRulesOptions(array('status_1'=>6)); 
									$this->ticket = array(	'views'	=> $views,
															'rowt' 	=> $rowt,
															'rtcro' => $rtcro
																				);
									$this->title = 'На возврат';
							} 							
							// страница - Отзывы
							elseif($views=='reviews'){
									$rowt = reqTicketMessages(array( 'ticket_flag' => 9));
									$this->ticket = array(	'views'	=> $views,
															'rowt' 	=> $rowt
																				);
									$this->title = 'Отзывы';
							}							
							// страница - FAQ
							elseif($views=='faq'){									
									$rowt = reqTicketMessages();									
									$this->ticket = array(	'views'	=> $views,
															'rowt' 	=> $rowt
															);
								$this->title = 'Частые вопросы';
							} else {}
						
					}
							
/* 			if(LOGIN_ID){			
							
				}else{
					redirect('/');
			} */
	}	
}
?>