<?php // Категории
	class Controllers_Admincategories extends core_BaseController
	{
		function __construct()
		{
			parent::__construct();
			
			if(PRAVA_1){					
					$this->admin_categories = array();
					
					$this->title = 'Администрирование - Категории';
			}else{
				redirect('404');
			}
			
		}
	}
?>