<?php
	$row 				= $member['menu_left']['row'];
	//$row_company_active	= $member['menu_left']['row_company_active'];
	$row_company 		= $member['menu_left']['row_company'];
	$company 			= $member['menu_left']['company_info'];
	
	
	//vecho($company);
	$GLOBALS['args'][1] = isset($GLOBALS['args'][1])? $GLOBALS['args'][1] : '';
	$li = '';	
	foreach($row as $k=>$m){
		$ok = true;// по умолчанию
		// Проверяем выводить или нет, для (Заявки/Объявления)
		if($m['id']==25){// Заявки
			$r = reqBuySellLeftMenu(array('flag_buy_sell'=>2));
			if(!$r['id']){
				$ok = false;
			}
		}elseif($m['id']==26){// Объявления
			$r = reqBuySellLeftMenu(array('flag_buy_sell'=>1));
			if(!$r['id']){
				$ok = false;
			}
		}
		
		if($ok){
				$cl = '';
				if( $m['href']==$GLOBALS['args'][0] ||
					$m['href']==$GLOBALS['args'][0].'/'.$GLOBALS['args'][1] || 
					($GLOBALS['args'][0].'/'.$GLOBALS['args'][1]=='buy-sell/offer_buy'&&$m['href']=='buy-sell/buy') ||
					($GLOBALS['args'][0].'/'.$GLOBALS['args'][1]=='buy-sell/offer_sell'&&$m['href']=='buy-sell/sell')  ){
					$cl = 'active';
				}
				// количество "Оповещение"
				$kol_notification = '';
				
				
				if($m['id']==25){// Заявки
					$kol_notification = reqNotificationMenu(array('id'=>8));
					$kol_notification = ($kol_notification)? ' <span class="badge badge-warning">'.$kol_notification.'</span>' : '';
				}elseif($m['id']==26){// Объявления
					$kol_notification = reqNotificationMenu(array('id'=>9));
					$kol_notification = ($kol_notification)? ' <span class="badge badge-warning">'.$kol_notification.'</span>' : '';
				}elseif($m['id']==22){// Подписки
					$kol_notification = reqNotificationMenu(array('id'=>5));
					$kol_notification = ($kol_notification)? ' <span class="badge badge-warning">'.$kol_notification.'</span>' : '';
				}
				
				$li .= '	<li class="item-request">
							<a href="/'.$m['href'].'" class="nav-item">
								<img src="'.$m['icon'].'" alt="li">
								<p>'.$m['menu'].'</p>
								'.$kol_notification.'
							</a>
						</li>';	
							
		}
	}


	// Не показываем "Смена аккаунта", если нет компании
	$a_change_account = $div_li_c = $active_company_name = '';
	if(count($row_company)>1){
			$cl_active = 'active';
			$active_name = $li_c = '';	
			foreach($row_company as $k=>$m){
				$cl = '';
				if($m['id']==COMPANY_ID){
					$cl = 'account-choosen';
					$cl_active = '';
					$active_company_name = $m['legal_entity'].' '.$m['company'];
					$active_name = '	<p class="company-name">'.$m['legal_entity'].' '.$m['company'].'</p>';
				}
				
				$li_c .= '	<div class="nav-account-item '.$cl.'">
								<span class="change_account_company" data-id="'.$m['id'].'">'.$m['legal_entity'].' '.$m['company'].'</span>
							</div>
						';		

			}
			
			$a_change_account = '	<a href="#" class="changeacc">
									<img src="/image/icon/changeacc.svg" alt="changeacc">
									<div class="change-acc">Смена аккаунта</div>
								</a>';
			$div_li_c = '	<div class="nav-account-wrapper">
							<div class="nav-account">
								'.$li_c.'
							</div>
						</div>';
	}else{
		$active_company_name = $row_company[0]['legal_entity'].' '.$row_company[0]['company'];
		$active_name = '	<p class="company-name">'.$row_company[0]['legal_entity'].' '.$row_company[0]['company'].'</p>';
	}
	
	
	if(PRO_MODE){
		$li .= '	<li class="item-request">
					<a href="/nomenclature" class="nav-item">
						<img src="/image/icon/nomenclature.svg" alt="nav-li-icon">
						<p>Номенклатура</p>
					</a>
				</li>';
	}
	$avatar = (!empty($company['avatar'])) ? $company['avatar'] :'';

	$code .= '
	
	<div class="menu-wrapper menu-hidden">
		<div class="menu-show">
			<div class="nav-burg-icon"><img src="/image/icon/menu.png" alt="menuicon"></div>
			<ul class="nav-menu">
				'.$li.'
			</ul>
		</div>
	
	
		<div class="nav-hidden-wrapper">
			<div class="nav-info-wrapper">
				<div class="submenu-wrapper">
					'.$a_change_account.'
					<a href="/profile" class="profile">
						<img src="/image/status-edit.svg" alt="profile">
						<div>Профиль</div>
					</a>
					<a href="#" class="exit">
						<img src="/image/icon/exit.svg" alt="exit">
						<div>Выйти</div>
					</a>
				</div>
				<div class="name">
					'.$active_name.'
				</div>
				<img src="'.$avatar.'" alt="Лого" class="user-company-logotype">  <!--/image/icon/userDefault.svg-->
				<div class="nav-arrow"><img src="/image/icon/profilemark.png" alt="list"></div>
			</div>
		  
			'.$div_li_c.'
		</div>
	</div>

';

?>
