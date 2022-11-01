<?php
//	$row 				= $member['menu_left']['row'];
	
	$data_modal_search 	= (getArgs(0)=='buy')? 		'data-flag_buy_sell="2"' 	: '';
	$value_search 		= (getGets('value'))? 		htmlspecialchars(getGets('value')) 			: '';
	
	$kol_notification_sum = 0;
	if(PRO_MODE){
		$r_vip = reqCompanyVipFunction(array('company_id'=>COMPANY_ID,'vip_function_id'=>1,'one'=>true)); // включена ли функция работы с 1С
		if(!empty($r_vip)){
			$r	= reqNo_SumLogoNotification();// не привязанная номенклатура и контрагент в купленных заявках
			$kol_notification_sum = $r['kol'];
			
		}
	}
	
	
	$r = reqEtpKolLogoNotification();//бренды с Этп
	$kol_notification_etp = $r['kol'];
	
	
	$kol_notification 	= reqNotificationMenu(array('id'=>1011));// уведомление о новых заявках
	
	
	$kol_notification 	= $kol_notification + $kol_notification_sum + $kol_notification_etp;
	$kol_notification 	= ($kol_notification)? ' <span class="badge badge-warning modal_logo_notification">'.$kol_notification.'</span>' : '';

	$form_autorize = (!COMPANY_ID)? '<div class="header-enter-btn">
										'.$f->FormAutorize2().'
									</div>' : '';
	if(PRAVA_1){// Админка
		
					$code .= '
							<header class="header header-nav" id="">
								<div class="container">
								  <div class="header-nav-wrapper">
									<a href="/"><img src="/image/logotype.svg" alt="logotype" class="logo header-nav-logo"></a>
									'.$kol_notification.'
									<div class="for-search">
									  <div class="btn search-main">
										<input type="text" placeholder="Что ищете?" class="header-nav-search-input autocomplete_search_top" autocomplete="off" value="'.$value_search.'" required maxlength="100">
										<span class="after search-after-rot modal_search" data-mclass="search-top" '.$data_modal_search.'></span>
									  </div>
									</div>
									<div class="header-nav-post btn search-post">
										<button class="post-request modal_admin_etp">
											Создать ЭТП
										</button>
									</div>
								  </div>
								</div>
							</header>
							<script>
								AutocompleteSearch("top");
							</script>';
		
	}else{
		
				if($GLOBALS['args']['0']=='chat'){

					$code .= '
							<header class="header header-nav" id="">
								<div class="container">
								  <div class="header-nav-wrapper">
									<a href="/"><img src="/image/logotype.svg" alt="logotype" class="logo header-nav-logo"></a>
									
									<div class="for-search">
									  <div class="btn search-main">
										<input type="text" placeholder="Поиск по сообщениям" class="header-nav-search-input searchInMessages" autocomplete="off" value="'.$value_search.'" required maxlength="100">
										
									  </div>
									  </div>
									<div class="header-nav-post btn write_message _search-post">
									  <div class="post-btn">
										<p>Написать сообщение</p>
									  </div>
									</div>
									
								  </div>
								</div>
							</header>
							<script>
								
							</script>';


				} elseif($GLOBALS['args']['0']=='ticket' || $GLOBALS['args']['0']=='faq' || $GLOBALS['args']['0']=='about' || $GLOBALS['args']['0']=='rules' || $GLOBALS['args']['0']=='confidentiality' ){

					$code .= '<header class="header header-nav" id="">
								<div class="container">
								  <div class="header-nav-wrapper">
									<a href="/"><img src="/image/logotype.svg" alt="logotype" class="logo header-nav-logo"></a>
									'.$kol_notification.'
									<div class="for-search">
									  <div class="btn search-main">
										<input type="text" placeholder="Что ищете?" class="header-nav-search-input autocomplete_search_top" autocomplete="off" value="'.$value_search.'" required maxlength="100">
										<span class="after search-after-rot modal_search" data-mclass="search-top" '.$data_modal_search.'></span>
									  </div>
									</div>
									<div class="header-nav-post btn write_ticket search-post">
									  <div class="post-btn">
										<p>Создать тикет</p>
									  </div>
									</div>
								  </div>
								</div>
							</header>
							<script>
								AutocompleteSearch("top");
							</script>';
				} else {

					$code .= '
							<header class="header header-nav" id="">
								<div class="container">
								  <div class="header-nav-wrapper">
									<a href="/"><img src="/image/logotype.svg" alt="logotype" class="logo header-nav-logo"></a>
									'.$kol_notification.'
									<div class="for-search">
									  <div class="btn search-main">
										<input type="text" placeholder="Что ищете?" class="header-nav-search-input autocomplete_search_top" autocomplete="off" value="'.$value_search.'" required maxlength="100">
										<span class="after search-after-rot modal_search" data-mclass="search-top" '.$data_modal_search.'></span>
									  </div>
									</div>
									<div class="header-nav-post btn search-post">
									  <div class="post-btn">
										<p>Разместить потребность</p>
									  </div>
									  <div class="post-wrap blue-buttons d-none">
										<button class="post-request modal_buy_sell" data-flag_buy_sell="2">
										  Заявка
										</button>
										<button class="post-post modal_buy_sell" data-flag_buy_sell="1">
										  Объявление
										</button>
									  </div>
									</div>
									'.$form_autorize.'
								  </div>
								</div>
							</header>
							<script>
								AutocompleteSearch("top");
							</script>';
				}
				
	}
?>