<?php // Навыки
	class Controllers_Skills extends core_BaseController
	{
		function __construct()
		{
			parent::__construct();
			
			if(LOGIN_ID){

					if(getGets('modal')=='1c'){// Модальное окно приветствие после перехода по ссылке активации(регистрация)
							$this->modal_start = array('flag'=>'modal_service_bind1c');// всплывающее окно при загрузке страницы
					}

					$row_company	= reqCompany(array('id'=>COMPANY_ID));
					$row_vip		= reqCompanyVipFunction(array('company_id'=>COMPANY_ID));

					$this->skills = array( 'row_company' => $row_company , 'row_vip' => $row_vip );
					
					
					
					$this->title = 'Навыки';
			}else{
				redirect('/');
			}
			
		}
	}
?>