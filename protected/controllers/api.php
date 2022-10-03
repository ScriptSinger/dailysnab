<?php // Api
	class Controllers_Api extends core_BaseController
	{
		function __construct()
		{
			parent::__construct();

				$api		= new ClassApi();

				$args1 			= getArgs(1);// флаг запроса
				$company_id_1c 	= getArgs(2);// второй параметр


				$r = reqCompany(array('id_1c'=>$company_id_1c));
				
				if(!empty($r)){
			
						if($args1=='buy11'){
							
								$json = $api->Out1cBuy11(array('company_id'=>$r['id']));		
								
						}elseif($args1=='sell11'){
							
								$json = $api->Out1cSell11(array('company_id'=>$r['id']));		
								
						}elseif($args1=='buy12'){
							
								$json = $api->Out1cBuy12(array('company_id'=>$r['id']));		
								
						}elseif($args1=='saved_measure'){// един.измер
							
								$json = $api->saved1cMeasure(array('company_id'=>$r['id']));
								
						}elseif($args1=='saved_typenom'){// номенклатура
							
								$json = $api->saved1cTypeNom(array('company_id'=>$r['id']));
								
						}elseif($args1=='saved_wh'){// склад
							
								$json = $api->saved1cStock(array('company_id'=>$r['id']));
								
						}elseif($args1=='saved_contractor'){// контрагенты
							
								$json = $api->saved1cСontractor(array('company_id'=>$r['id']));
								
						}elseif($args1=='saved_nom'){// контрагенты
						
								$json = $api->saved1cNom(array('company_id'=>$r['id']));
								
						}elseif($args1=='saved_docreceiptgoods'){// исполненные
							
								$json = $api->saved1cBuy12(array('company_id'=>$r['id'],'flag'=>1));
								
						}elseif($args1=='saved_buy11_12'){// понимание в купденных, что исполненные в 1с
							
								$json = $api->saved1cBuy12(array('company_id'=>$r['id'],'flag'=>2));
								
						}elseif($args1=='saved_nomost'){// остатки
							
								$json = $api->saved1cNomost(array('company_id'=>$r['id']));
								
						}elseif($args1=='refresh_all'){// флаг обновить все
							
								$json = $api->refresh1cAll(array('company_id'=>$r['id']));
								
						}elseif($args1=='nom_out'){// передаем номенклатуры от нас в 1С
							
								$json = $api->NomenclatureOut1c(array('company_id'=>$r['id']));
								
						}else{
							
								redirect('/');
							
						}

				}else{
					$arr['error'] 	= 'Идентификатор 1С компании не привязан';
					$json 			= json_encode($arr);
				}
				
		
				//$this->title = 'Api '.$args1;
				
				header('Content-Type: application/json; charset=utf-8');
				
				echo $json;
				
				disConnect();
				
				exit;
			
		}
	}
?>