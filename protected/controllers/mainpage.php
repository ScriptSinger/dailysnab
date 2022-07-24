<?php //Главная страница
	class Controllers_Mainpage extends core_BaseController
	{
		function __construct()
		{
			parent::__construct();
			

			if(LOGIN_ID) {
                $r = reqSearchFilterParamCompany(array('login_id' => LOGIN_ID, 'company_id' => COMPANY_ID));
                $m = reqCompany(array('login_id' => LOGIN_ID, 'company_id' => COMPANY_ID));
                $flag_count_company = reqCompany(array('login_id'=>LOGIN_ID,'flag_account'=>2));

                $url_i = ($r['flag_interest']) ? '?interests=true' : '';

                if (!$flag_count_company) {
                    if($m[0]['skipReg'] == 1)
                    {
                        if ($r['flag_search'] == 1) {
                            redirect('sell' . $url_i);
                        } else {
                            redirect('buy' . $url_i);
                        }
                    } else {
                        redirect('profile/modal-welcome' . $url_i);
                    }

                } else {
                    if ($r['flag_search'] == 1) {
                        redirect('sell' . $url_i);
                    } else {
                        redirect('buy' . $url_i);
                    }
                }

			}else{
					$this->mainpage = '';

					$this->title = 'Главная';
			}
			
		}
	}
?>