<?php // Номенклатура
	class Controllers_Nomenclature extends core_BaseController
	{
		function __construct()
		{
			parent::__construct();
			
			if(PRO_MODE){	
				
					// Поиск
						$value = getGets('value');
					///	
				
					$row = reqNomenclature(array('company_id'	=> COMPANY_ID,
												'value' 		=> $value));
					$this->nomenclature = array(	'row' 		=> $row,
												'value' 	=> $value
											);
			
					$this->title = 'Номенклатура';
							
			}else{
					$this->e404 = '';
					$this->title = 'Ошибка 404. Страница не найдена';
			}
			
		}
	}
?>