<?php // Поиск
	class Controllers_Adminsearch extends core_BaseController
	{
		function __construct()
		{
			parent::__construct();
			
			if(PRAVA_1){	
					$ok = false;
					$flag = getArgs(1);
					
					
					$page = getGets('page');
					$page = ($page)? $page : 1;
					$count_page = 10;
					$ipage = ($page*$count_page)-$count_page;
					$kol = 0;

					
					if($flag==1){
						$ok = true;
						$row = reqAdminSearchNameArticul(array('ipage'=>$ipage,'count_page'=>$count_page));
						$row_kol = reqAdminSearchNameArticul(array('kol'=>true));
						$kol = $row_kol['kol'];
					}elseif($flag==2){
						$ok = true;
						$row = reqSearchCategories(array());
						$row_kol = array();//reqSearchRequest(array('kol'=>true));
						$kol = 0;//$row_kol['kol'];
					}
			
					if($ok){
						$this->admin_search = array(	'flag'			=> $flag,
													'row'			=> $row,
													'page'			=> $page,
													'count_page'	=> $count_page,
													'kol'			=> $kol );
					}else{
						redirect('404');
					}
					
					$this->title = 'Администрирование - Поиск';
			}else{
				redirect('404');
			}
			
		}
	}
?>