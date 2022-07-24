<?php // Открытый Профиль компании (аккаунта)
	class Controllers_Companyprofile extends core_BaseController
	{
		function __construct()
		{
			parent::__construct();
			

				$company_id 		= getArgs(1);
				$flag_buy_sell 	= getArgs(2);
				$flag_buy_sell		= ($flag_buy_sell)? $flag_buy_sell : 2;
				
				if($flag_buy_sell==1){
						$row = reqBuySell_PageSell(array( 'company_id' => $company_id ));
				}else{
						$row = reqBuySell_pageBuy(array(	'parent_id'			=> 0,
														'flag_buy_sell' 	=> 2,
														'company_id' 		=> $company_id,
														'flag_companyprofile'	=> true	));
				}

				$this->company_profile = array( 	'row'				=> $row,
												'row_company'		=> reqCompany(array('id'=>$company_id)),
												'row_1c_company'	=> req1cCompanyCompany(array(	'company_id'	=> COMPANY_ID,
																									'company_id_to'	=> $company_id )),
												'company_id' 		=> $company_id,
												'flag_buy_sell' 	=> $flag_buy_sell );
				
				$this->title = 'Открытый Профиль';

		
		}
	}
?>