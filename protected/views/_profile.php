<?php
	$company 			= $member['profile']['company'];
	$profile 				= $member['profile']['profile'];
	$flag_invite_workers 	= $member['profile']['flag_invite_workers'];
	$login 				= $member['profile']['login'];
	$flag_count_company 	= $member['profile']['flag_count_company'];
	$row_notification 		= $member['profile']['row_notification'];
	$row_notification_param 	= $member['profile']['row_notification_param'];
	$row_interests 		= $member['profile']['row_interests'];
	$row_worker 			= $member['profile']['row_worker'];
	$row_stock 			= $member['profile']['row_stock'];
	$row_amo 			= $member['profile']['row_amo'];


	$tr = '';
	foreach($row_notification as $i => $m){
			$st_td1 = $td2 = $td3 = '';
			if($m['parent_id']){
				$st_td1 = 'padding-left:50px;';
				$td2 = $e->SelectNotificationParam(array('row'				=> $row_notification_param,
														'notification_id'	=> $m['id'],
														'flag'				=> 1,
														'id'				=> $m['notification_param_id1']));
				$td3 = $e->SelectNotificationParam(array('row'				=> $row_notification_param,
														'notification_id'	=> $m['id'],
														'flag'				=> 2,
														'id'				=> $m['notification_param_id2']));
			}else{
				//
			}
			
			$tr .= '	<tr>
						<td style="'.$st_td1.'">
							'.$m['notification'].'
						</td>
						<td>
							'.$td2.'
						</td>
						<td>
							'.$td3.'
						</td>
					</tr>';
	}

	$code_notification = '
					<table id="" class="table table-borderless" border="0" cellspacing="0" cellpadding="0" style="">
						<thead>
							<tr>
								<td></td>
								<td>Сайт</td>
								<td>E-mail</td>
							</tr>
						</thead>
						<tbody>
							'.$tr.'
						</tbody>
					</table>';
					
					
	$tr = '';
	foreach($row_stock as $i => $m){
			
			$tr .= '	<tr>
						<td>
							<a class="blue-button modal_stock" data-id="'.$m['id'].'">'.$m['stock'].'</a>
						</td>
						<td>
							'.$m['address'].'
						</td>
					</tr>';
	}

	$code_stock = '
					<table id="" class="table table-borderless" border="0" cellspacing="0" cellpadding="0" style="">
						<tbody>
							'.$tr.'
						</tbody>
					</table>';
	
	
	$tr = '';
	foreach($row_amo as $i => $m){
			
			$tr .= '	<tr id="div_form_accountsadd'.$m['vendorid'].'">
						<td>
							'.$m['accounts_id'].'
						</td>
						<td>
							'.$m['accounts_title'].'
						</td>
						<td>
							<span class="blue-button delete_amo_accounts" data-id="'.$m['id'].'" data-id_v="'.$m['vendorid'].'" data-name="'.$m['accounts_title'].'">удалить</span>
						</td>
					</tr>';
	}

	$code_amo = '
					<table id="" class="table table-borderless" border="0" cellspacing="0" cellpadding="0" style="">
						<tbody>
							'.$tr.'
						</tbody>
					</table>';
										
					
	
	if(PRAVA_2){
	
		$code_worker = '';
		foreach($row_worker as $i => $m){
			
				$code_worker .= $t->HtmlInviteWorkers(array(	'id' 		=> $m['id'],
															'flag' 		=> $m['flag'],
															'prava_id' 	=> $m['prava_id'],
															'avatar' 	=> $m['avatar'],
															'name' 		=> $m['company'],
															'position' 	=> $m['position'],
															'phone' 	=> $m['phone'],
															'email' 	=> $m['email'] ));
				
		}

	}
	
	// выйти из компании приглашенному сотруднику
	$exit_invite_workers = '';
	if(!$flag_invite_workers){
			// $active_company_name - views/menu_left.php
			$exit_invite_workers = '<section class="workers" id="workers">
									<div class="container">
										<div class="workers-title">
											<span class="blue-button delete_invite_workers" data-flag="exit" data-question="ВЫЙТИ" data-name="из компании '.$active_company_name.'">ВЫЙТИ</span> из компании <strong>'.$active_company_name.'</strong>
										</div>
									</div>
								</section>';
			
	}


	$code_company = $code_invite_workers = '';
	if( !empty($company) && PRAVA_2 ){
		
		$code_company = '
					<form id="my_company-form" class="" role="form">
						<div class="profile-head">
							<div class="profile-text">
								Настройки компании
							</div>
							<span class="profile-head-btns">
								'.$e->Input(array(	'type'			=> 'hidden',
													'id'			=> 'id',
													'value'			=> $company['id']
												)
											).'
								'.$e->Input(	array(	'type'			=> 'submit',
														'class'			=> 'profile-btn request-btn',
														'value'			=> 'Сохранить'
												)
										).'
								<a id="get_href_company_profile2" class="request-btn change-btn get_href_company_profile" 
															data-href="https://'.$_SERVER['SERVER_NAME'].'/company-profile/'.$company['id'].'"
															data-elem_id="myCopyText"
															data-company="'.$company['company'].'">Поделиться профилем</a>
							</span>
						</div>
						<div class="profile-wrapper company-wrapper">
							<div class="profile-img">
								<div id="div_upload_company" style="display:none;">
									<button id="upload_result_company" class="btn btn-success btn-sm upload-result" data-id="'.$company['id'].'"data-div_id="upload_demo_company" data-img_id="img_avatar_company"><span data-feather="check">Сохранить изображение</span></button>
								</div>
								<img src="'.$company['avatar'].'" id="img_avatar_company" alt="" class="rounded-circle img_avatar" height="200" data-file_id="upload_avatar_company">

								<div id="upload_demo_company" style="visibility:hidden;"></div>
								<input type="file" id="upload_avatar_company" class="upload_avatar" data-div_id="upload_demo_company" data-div_upload_id="div_upload_company" style="visibility:hidden;" accept="image/jpeg,image/png">
							</div>
							<div class="profile-info-wrapper">
								<div class="profile-info">
									<div class="form-group">
										'.$e->Select(	array(	'id'		=> 'legal_entity_id',
																'class'		=> 'form-control select2',
																'value'		=> $company['legal_entity_id'],
																'data'		=> array('placeholder'=>'Правовая форма')
															),
														array(	'func'		=> 'reqSlovLegalEntity',
																'param'		=> array('' => ''),
																'opt'		=> array('id'=>'','name'=>'-'),
																'option'	=> array('id'=>'id','name'=>'legal_entity')
															)
													).'
									</div>
									<div class="form-group">
										'.$e->SelectCategoriesCompany(array( 'company_id' => $company['id'] )).'
									</div>
									<div class="form-group">
										'.$e->Input(	array(	'type'			=> 'text',
																'id'			=> 'position',
																'class'			=> 'form-control',
																'value'			=> $company['position'],
																'placeholder'	=> 'Должность'
															)
													).'
									</div>
									<div class="form-group">
										<!--
										<input type="checkbox" class="form-control" id="checkbox" name="checkbox" placeholder="check" title="" />
										<span class="checkbox-text">Закрытый аккаунт</span>
										-->
									</div>
									<div class="form-group">
										'.$e->SelectCities(array('cities_id'=>$company['cities_id'])).'
									</div>
								</div>
								<div class="profile-info">
									<div class="form-group">
										'.$e->Input(	array(	'type'			=> 'text',
																'id'			=> 'company',
																'class'			=> 'form-control',
																'value'			=> $company['company'],
																'placeholder'	=> 'Название'
															)
													).'
									</div>
									<div class="form-group">
										'.$e->Select(	array(	'id'		=> 'tax_system_id',
																'class'		=> 'form-control select2',
																'value'		=> $company['tax_system_id'],
																'data'		=> array('placeholder'=>'Система налогообложения')
															),
														array(	'func'		=> 'reqSlovTaxSystem',
																'opt'		=> array('id'=>'','name'=>''),
																'option'	=> array('id'=>'id','name'=>'tax_system')
															)
													).'
									</div>
									<div class="form-group">
										'.$e->SelectWhoCompany(array(	'who1'	=> $company['who1'],
																		'who2'	=> $company['who2'] )).'
									</div>
									<div class="form-group">
										'.$e->Input(	array(	'type'			=> 'text',
																'id'			=> 'email',
																'class'			=> 'form-control',
																'value'			=> $company['email'],
																'placeholder'	=> 'E-mail'
															)
													).'
									</div>
								</div>
								'.$e->Input(array(	'type'			=> 'button',
													'class'			=> 'request-btn profile-totals modal_company_form_payment',
													'value'			=> 'Расчеты'
												)
											).'
							</div>
						</div>
					</form>
				';
				
		// Сотрудники
		$code_invite_workers = '<section class="workers" id="workers">
								<div class="container">
									<div class="workers-title">
										Сотрудники
									</div>
									<div class="workers-wrapper">
									
										'.$t->HtmlInviteWorkers(array(	'id' 		=> 0,
																		'flag' 		=> 1,
																		'prava_id' 	=> 2,
																		'avatar' 	=> $profile['avatar'],
																		'name' 		=> 'Вы',
																		'position' 	=> $company['position'],
																		'phone' 	=> $profile['phone'],
																		'email' 	=> $profile['email'] )).'
										
										'.$code_worker.'
										
										<button id="button_miw" class="workers-new blue-button modal_invite_workers">
											+Пригласить сотрудника
										</button>
									</div>
								</div>
							</section>';
							
				
	}elseif(!empty($company) && !PRAVA_2){
		$code_company = '
					<form id="my_company-form" class="" role="form">
						<div class="profile-head">
							<span class="profile-head-btns">
								<a id="get_href_company_profile2" class="request-btn change-btn get_href_company_profile" 
															data-href="https://'.$_SERVER['SERVER_NAME'].'/company-profile/'.$company['id'].'"
															data-elem_id="myCopyText"
															data-company="'.$company['company'].'">Поделиться профилем</a>
							</span>
						</div>
					</form>
				';
	}
	
	$code_add_company = '';
	if(!$flag_count_company){
			$code_add_company = '<span class="blue-button profile-sub modal_my_company">
										+Зарегистрировать компанию
								</span>';
	}


	$code_interests = '';
	if(PRAVA_2){
			$code_interests = '<section class="interests" id="interests">
								<div class="container">
									<div class="interests-title">
										Мои интересы
									</div>
									<p class="interests-text">
										На этой странице Вы настраиваете все заявки, которые Вы хотите видеть.
										Только эти заявки будут отражены и только на них будут приходить оповещения
									</p>
									
									'.$t->TrInterestsCompanyParam(array('row_interests'=>$row_interests,'flag'=>1)).'
									
									
									<button class="interests-more blue-button add_interests" data-flag="1">
										Добавить условия
									</button>
									
								</div>
							</section>';
	}
	
	
	
	$code .= '	
			<section class="profile profile-company" id="profile-company">
				<div class="container">	
				
					'.$code_company.'			
			
					<form id="profile-form" class="" role="form">
						<div class="profile-head">
							<div class="profile-text">
								Настройки профиля
							</div>
							
							<span class="profile-head-btns">
								'.$e->Input(	array(	'type'			=> 'submit',
														'class'			=> 'profile-btn request-btn',
														'value'			=> 'Сохранить'
												)
										).'
								<a id="get_href_company_profile1" class="request-btn change-btn" 
															data-href="https://'.$_SERVER['SERVER_NAME'].'/company-profile/'.$profile['id'].'"
															data-company="'.$profile['company'].'">Поделиться профилем</a>
							</span>
							
						</div>
						
						<div class="profile-wrapper">
							<div class="profile-img">
									<div id="div_upload_profile" style="display:none;">
										<button id="upload_result_profile" class="btn btn-success btn-sm upload-result" data-id="'.$profile['id'].'" 
																														data-div_id="upload_demo_profile" 
																														data-img_id="img_avatar_profile"><span data-feather="check">Сохранить изображение</span></button>
									</div>
									<img src="'.$profile['avatar'].'" id="img_avatar_profile" alt="" class="rounded-circle img_avatar" height="200" data-file_id="upload_avatar_profile">

									<div id="upload_demo_profile" style="visibility:hidden;"></div>
									<input type="file" id="upload_avatar_profile" class="upload_avatar" data-div_id="upload_demo_profile" data-div_upload_id="div_upload_profile"  accept="image/jpeg,image/png" style="visibility:hidden;" >
							</div>
							<div class="profile-info-wrapper">
								<div class="profile-info">
									<div class="form-group">
										'.$e->Input(	array(	'type'			=> 'text',
																'id'			=> 'name',
																'class'			=> 'form-control',
																'value'			=> $profile['company'],
																'placeholder'	=> 'Имя'
															)
													).'
									</div>
									<div class="form-group">
										'.$e->Input(	array(	'type'			=> 'tel',
																'id'			=> 'phone',
																'class'			=> 'form-control phone',
																'value'			=> $profile['phone'],
																'dopol'			=> 'inputmode="tel"'
															)
													).'
									</div>
									<div class="form-group">
										'.$e->Input(	array(	'type'			=> 'text',
																'id'			=> 'email',
																'class'			=> 'form-control',
																'value'			=> $login['email'],
																'placeholder'	=> 'E-mail'
															)
													).'
									</div>
									<div class="form-group">
										'.$e->SelectCities(array('cities_id'=>$profile['cities_id'])).'
									</div>
									
									'.$e->Input(	array(	'type'			=> 'button',
															'id'			=> '',
															'class'			=> 'blue-button modal_change_pass',
															'value'			=> 'Изменить пароль',
															'placeholder'	=> ''
														)
												).'
									<!--
									<div class="form-group">
										<input type="checkbox" class="form-control" id="checkbox" name="checkbox" placeholder="check" title="" />
										<span class="checkbox-text">Закрытый аккаунт</span>
									</div>
									-->
								</div>
								
								'.$code_add_company.'
								
							</div>
						</div>
					</form>
					
				</div>
			</section>
			
			
			'.$code_interests.'
			
			
			<section class="nots" id="nots">
				<div class="container">
					<div class="nots-title">
						Оповещения
				</div>
				<div class="nots-wrapper">
					'.$code_notification.'
				</div>
			</section>
			
			<section class="nots" id="nots">
				<div class="container">
					<div class="nots-title">
						Склад
				</div>
				<div class="nots-wrapper">
					'.$code_stock.'
				</div>
				'.$e->Input(	array(	'type'			=> 'button',
										'class'			=> 'profile-btn request-btn modal_stock',
										'value'			=> '+ Добавить склад'
								)
						).'
			</section>
			
			
			'.$exit_invite_workers.'
			
			'.$code_invite_workers.'
			
	
			<section class="nots" id="nots">
				<div class="container">
					<div class="nots-title">
						Поставщики сторонних ресурсов
				</div>
				<div class="nots-wrapper">
					'.$code_amo.'
					'.$e->Input(	array(	'type'			=> 'button',
											'class'			=> 'profile-btn request-btn modal_amo_vendors',
											'value'			=> '+ Добавить Поставщика'
									)
							).'
				</div>
			</section>
			
			
			
							
<script>

	
	get_intlTelInput("phone","'.$profile['iti_phone'].'");
	
	$( ".select2" ).each(function( index ) {
			$(this).select2({
					placeholder: function(){
						$(this).data("placeholder");
					}
			});
	});
	
	SaveMyCompany();
	
	Select2InterestsCompanyParam();
	
	Select2InterestsCompanyParamCities();
	
</script>
			';

			
			
			
?>