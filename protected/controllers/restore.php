<?php // Забыли пароль
	class Controllers_Restore extends core_BaseController
	{
		function __construct()
		{
			parent::__construct();

			$active_md5 = getArgs(1);//md5 идентификатор
			
			if($active_md5){//если md5 идентификатор
				$r = reqLogin(array('active_md5'=>$active_md5));
				$flag = 'active_md5';
			}else{
				$flag = 'restore';
			}

			if($flag=='restore'&&!LOGIN_ID){//Восстановление пароля
				$this->restore = '';
				$this->title = 'Восстановление пароля';
			}elseif($flag=='active_md5' && !empty($r['email'])){//Смена пароля
				$this->restore_password = array('active_md5'=>$active_md5 , 'email'=>$r['email']);
				$this->title = 'Смена пароля';
			}else{
				$this->e404 = '';
				$this->title = 'Ошибка 404. Страница не найдена';				
			}

		}
	}
?>