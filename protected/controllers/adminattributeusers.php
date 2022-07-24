<?php // Значения пользователей
	class Controllers_Adminattributeusers extends core_BaseController
	{
		function __construct()
		{
			parent::__construct();
			
			if(PRAVA_1){					
					$this->admin_attribute_users = array('row'=>reqSlovAttributeValueByAdmin());
					
					$this->title = 'Администрирование - Значения пользователей';
			}else{
				redirect('404');
			}
			
		}
	}
?>