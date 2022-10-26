<?php // Пользователи
	class Controllers_Adminusers extends core_BaseController
	{
		function __construct()
		{
			parent::__construct();
			
			if(PRAVA_1){
					$args1 = getArgs(1);
					$args2 = getArgs(2);
				
					$flag = ($args1=='company')? true : false;
					$login_id = ($args1<>'company'&&v_int($args1))? $args1 : '';
				
					$flag = '';
					$row = array();
					$row_account = array('company'=>'');
					if($login_id){
						$row = reqCompanyAdmin(array('login_id'=>$login_id,'flag_account'=>2));
						$row_account = reqCompany(array('id'=>$args2));
						$flag = 'login_id';
					}else{
						if($flag=='company'){
							$row = reqCompanyAdmin(array('flag_account'=>2));// 	компании
							$flag = 'company';
						}if($flag=='nosend_email'){
							$row = reqCompanyAdmin(array('flag_account'=>2));// 	блокировка email от отправки
							$flag = 'nosend_email';
						}else{
							$row = reqCompanyAdmin(array('flag_account'=>1));//	пользователи
							$flag = 'account';
						}
					}
				
					$this->admin_users = array( 	'row'			=> $row,
												'flag'			=> $flag,
												'row_account'	=> $row_account );
					
					$this->title = 'Администрирование - Пользователи';
			}else{
				redirect('404');
			}
			
		}
	}
?>