<?php // Amo добавление поставщиков
	class Controllers_Adminqrq extends core_BaseController
	{
		function __construct()
		{
			parent::__construct();
			
			if(PRAVA_1){
			
					$page = getArgs(1);
				
					$page = ($page)? $page : 'qrq';
				
				
					if($page=='qrq'){
						$this->admin_qrq = array( 'row'	=> reqSlovQrq(),
												'row_n' => reqNotSlovQrq()
												);
					}elseif($page=='accounts'){
						$this->admin_qrq_accounts = array( 'row'	=> reqAmoAccounts() );
					}
				
					$this->title = 'Администрирование - Amo';
					
			}else{
				redirect('404');
			}
			
		}
	}
?>