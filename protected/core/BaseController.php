<?php
class core_BaseController extends HtmlServive
{
	protected $model;
	private $member;

	function __set($name, $val)
	{
		$this->member["$name"] = $val;
	}

	function __get($name)
	{
		return $this->member;
	}

	function __construct()
	{
	
	require_once './protected/source/altorouter/AltoRouter.php'; //класс для роутинга
	$router = new AltoRouter();
	
		//$this->model = new core_BaseModel;//создание объекта модели по умолчанию

				/*  ЧПУ городов
					$r = reqCities();
					foreach($r as $i => $m){
						$url 	= $this->rus2translit($m['name']);
						$STH = PreExecSQL(" UPDATE a_cities SET url_cities=? WHERE id=?; " ,
												array( $url , $m['id'] ));
					}
				*/
			
			if($GLOBALS['args']['0']<>'mainpage'){
				$this->menu_top = '';
			}
	
			if(LOGIN_ID){//левое меню
				//$row_company	= (FLAG_ACCOUNT==2)? reqCompany(array('id'=>COMPANY_ID)) : array();
				$this->menu_left = array(	'row'					=> reqMenu(),
										//'row_company_active'	=> reqCompany(array('id' => COMPANY_ID)),
										'row_company'			=> reqCompanyMenuLeft(array('login_id' => LOGIN_ID)),
										'company_info'			=> reqCompany(array('id'=>COMPANY_ID)) //для вывода в меню аватарки
									);
				
			}
			
		
		$this->title = '';
	}
}
?>
