<?php // Пользователи
	class Controllers_Profile extends core_BaseController
	{
		function __construct()
		{
			parent::__construct();
			
			if(LOGIN_ID){
					if(getArgs(1)=='modal-welcome'){// Модальное окно приветствие после перехода по ссылке активации(регистрация)
							$this->modal_start = array('flag'=>'modal_start_welcome');// всплывающее окно при загрузке страницы
					}
					
					$row_interests = $row_worker = $row_company = array();
					$row_company	= (FLAG_ACCOUNT==2)? reqCompany(array('id'=>COMPANY_ID)) : array();
					if(PRAVA_2){
						$row_interests	= reqInterestsCompanyParamGroupInterestsId(array('flag'=>1));
						$row_worker	= reqWorkerByProfile();
					}
					
					

					$this->profile = array( 	'company'				=> $row_company,
											'flag_count_company' 	=> reqCompany(array('login_id'=>LOGIN_ID,'flag_account'=>2)),
											'profile'				=> reqCompany(array('login_id' => LOGIN_ID,'flag_account'=>1,'one'=>true)),
																		// flag_invite_wirkers - Проверяем, если сотрудник пришлашенный , то он может покинуть компанию
											'flag_invite_workers'	=> reqCompany(array('login_id'=>LOGIN_ID,'id'=>COMPANY_ID)),
											'login'					=> reqLogin(array('id'=>LOGIN_ID)),
											'row_notification'		=> reqSlovNotification(),
											'row_notification_param'=> reqSlovNotificationParam(),
											'row_interests'			=> $row_interests,
											'row_worker'			=> $row_worker,
											'row_stock'				=> reqStock(array('company_id'=>COMPANY_ID))	);
					
					$this->title = 'Профиль';
			}else{
				redirect('/');
			}
			
		}
	}
?>