<?php // ЭТП
	class Controllers_Adminetp extends core_BaseController
	{
		function __construct()
		{
			parent::__construct();
			
			if(PRAVA_1){
				
					$where = getArgs(1);
				
					$where = (isset($where)&&!empty($where))? $where : 'etp';

					if($where=='etp'){
				
							$this->admin_etp = array( 'row'	=> reqAdminEtp() );
														
					}elseif($where=='accounts'){
				
							$this->admin_etp_accounts = array( 'row'			=> '' );
														
					}elseif($where=='errors'){
				
							$this->admin_etp_errors = array( 'row'	=> reqAmoNameErrorEtp() );
														
					}elseif($where=='errors_log'){
				
							$this->admin_etp_errors_log = array( 'row'	=> reqAdminEtpErrorsLog() );
														
					}elseif($where=='cities'){
				
							$this->admin_etp_cities = array( 'row'	=> reqAmoCitiesCitiesId() );
														
					}
					
					$this->title = 'Администрирование - ЭТП';
			}else{
				redirect('404');
			}
			
		}
	}
?>