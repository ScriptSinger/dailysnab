<?php //Активация пользователя (переход по ссылке с почты)
	class Controllers_Registrationactivate extends core_BaseController
	{
		function __construct()
		{
			parent::__construct();
				
				$active_md5 = getArgs(1);// контрольная сумма
				
				$row = reqLogin(array('active_md5'=>$active_md5));
				
				if($row['id']&&$row['active']==2){
						$STH = PreExecSQL(" UPDATE login SET active=1 WHERE id=?; " ,
																		array( $row['id'] ));
						$r = reqCompany(array('login_id'=>$row['id'],'flag_account'=>1,'one'=>true));
						$company_id = $r['id'];
						
						if($STH&&$company_id){
							
							$this->AutorizeUser(array( 'login_id'=>$row['id'] , 'company_id'=>$company_id ));//авторизация пользователя
					
							
							// закрепление заявок/объявл за пользователем после регистрации
							$this->FixBuySellCompanyByCookieSession(array('company_id'=>$company_id,'login_id'=>$row['id']));

					
							redirect('profile/modal-welcome');
						}else{
							$this->registration_activate = array('flag'=>1);
						}
					
				}else{
						$this->registration_activate = array('flag'=>2);
					
						$this->title = 'Авторизация пользователя';					
				}
		}
	}
?>