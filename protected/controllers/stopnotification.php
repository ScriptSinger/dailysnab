<?php //Отключить оповещение на email
	class Controllers_Stopnotification extends core_BaseController
	{
		function __construct()
		{
			parent::__construct();
			
					$login_id_md5 	= getArgs(1);
					$company_id_md5 	= getArgs(2);
					$notification_id		= getArgs(3);
					
					
					$row_login = reqLogin(array('login_id_md5'=>$login_id_md5));
					
					$row_company = reqCompany(array('company_id_md5'=>$company_id_md5));
			
					//vecho($row_login);
					
					//vecho($row_company);
					
					if( (!empty($row_login))&&(!empty($row_company))&&v_int($notification_id) ){
						
						// удаляем конкретное уведомление на email
						$STH = PreExecSQL(" DELETE FROM notification_company_param WHERE login_id=? AND company_id=? AND flag=? AND notification_id=? ; " ,
									array( $row_login['id'],$row_company['id'],2,$notification_id ));
						///
						
						// отключаем конкретное уведомления 
						$STH = PreExecSQL(" INSERT INTO notification_company_param(login_id,company_id,flag,notification_id,notification_param_id) VALUES (?,?,?,?,?); " ,
														array( $row_login['id'],$row_company['id'],2,$notification_id,3 ));
						
					}
								
					redirect('');

					//$this->stopemailnotification = '';
						
					//$this->title = 'Отключить оповещение на email';
			
		}
	}
?>