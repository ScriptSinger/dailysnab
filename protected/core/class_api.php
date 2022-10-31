<?php
	/*
	 *  Интеграция с 1С api
	 */
	 
class ClassApi extends HtmlServive 
{
	// ЭКСПОРТ - Передаем в 1с купленные заявки (Купленное на странице "Заявки")
	function Out1cBuy11( $p=array() ){
		
		$in = fieldIn($p, array('company_id'));

		$json = '';
		$arr = array();

		$r = reqOut1cBuy11(array('company_id'=>$in['company_id']));

		foreach($r as $i => $m){
			
			$arr[] = array(	'contractorid'		=> $m['contractorid'],
							'date'				=> $m['date'],
							'nomid'				=> $m['nomid'],
							'whid'				=> $m['stock_id_1c'],
							'cost'				=> $m['cost'],
							'nds'				=> $m['nds'],
							'quantity'			=> $m['quantity'],
							'brend'				=> $m['brend'],
							'buy_sell_id'		=> $m['buy_sell_id']
						);
			
		}
		
		$json = json_encode($arr);

		return $json;
	}
	
	// ЭКСПОРТ - Передаем в 1с купленные объявление (Купленное на странице "Объявление")
	function Out1cSell11( $p=array() ){
		
		$in = fieldIn($p, array('company_id'));

		$json = '';
		$arr = array();

		$r = reqOut1cSell11(array('company_id'=>$in['company_id']));

		foreach($r as $i => $m){
			
			$arr[] = array(	'contractorid'		=> $m['contractorid'],
							'date'				=> $m['date'],
							'nomid'				=> $m['nomid'],
							'whid'				=> $m['stock_id_1c'],
							'cost'				=> $m['cost'],
							'nds'				=> $m['nds'],
							'quantity'			=> $m['quantity'],
							'brend'				=> $m['brend'],
							'buy_sell_id'		=> $m['buy_sell_id']
						);
			
		}
		
		$json = json_encode($arr);

		return $json;
	}
	
	
	// ЭКСПОРТ - Передаем в 1с исполненные заявки (которые заводили для "заказчика")
	function Out1cBuy12( $p=array() ){
		
		$in = fieldIn($p, array('company_id'));

		$json = '';
		$arr = array();

		$r = reqOut1cBuy12(array('company_id'=>$in['company_id']));

		foreach($r as $i => $m){
			
			$arr[] = array(	'contractorid'		=> $m['contractorid'],
							'date'				=> $m['date'],
							'nomid'				=> $m['nomid'],
							'whid'				=> $m['stock_id_1c'],
							'cost'				=> $m['cost'],
							'nds'				=> $m['nds'],
							'quantity'			=> $m['quantity'],
							'brend'				=> $m['brend'],
							'buy_sell_id'		=> $m['buy_sell_id']
						);
			
		}
		
		$json = json_encode($arr);

		return $json;
	}
	
	
	// ИМПОРТ - Привязать единицы измерения
	function BindUnit1c( $p=array() ){
		
		$in = fieldIn($p, array('flag','id_1c','company_id'));

		$json = $tr = $code = '';
		
		$id_1c 		= isset($in['id_1c'])? 		$in['id_1c'] 		: COMPANY_ID_1C;
		
		$company_id 	= isset($in['company_id'])? 	$in['company_id'] 	: COMPANY_ID;
		
		$url = 'https://questrequest.ru/qrq/1C/'.$id_1c.'/measure.json';
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		
		
		$json = json_decode($response);
		 
		if(is_array($json)&&!empty($json)){
			foreach ($json as $item){
				
				$Name 		= $item->Name;
				$MeasureID 	= $item->MeasureID;
				$data1c		= $item->data1c;
				
				
				if($MeasureID>0){
				
					// Проверяем есть ли в базе уже эта един измер.
					$r = req1cSlovUnit(array('company_id'=>$company_id,'measure_id'=>$MeasureID));
					
					if(!$r['id']){
					
						// сохраняем во временную таблицу значения ед.изм. из 1с
						$STH = PreExecSQL(" INSERT INTO 1c_slov_unit (company_id,name,measure_id,data_1c)VALUES(?,?,?,?) " ,
															array( $company_id,$Name,$MeasureID,$data1c ));
															
					}
					
				}
			}
		}
		
		if($in['flag']=='hands'){// ручной режим
		
				$row = reqSlovUnitVBind1c();// Выбираем значения расхождения наших единиц измерения из 1C
				
				$tr = '';
				foreach($row as $i => $m){

						$cl_tr = (!$m['name']||!$m['measure_id']||!$m['unit']||!$m['okei'])? 'table-danger' : '';

						$tr .= '	<tr class="'.$cl_tr.'">
									<td>
										'.$m['name'].'
									</td>
									<td>
										'.$m['measure_id'].'
									</td>
									<td>
										'.$m['unit'].'
									</td>
									<td>
										'.$m['okei'].'
									</td>							
								</tr>';
				}
				
				if($tr){
						$code = '
								<table id="" class="table table-bordered table-hover" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;">
									<thead>
										<tr>
											<td>
												Наименование 1С
											</td>
											<td>
												Код 1С
											</td>
											<td>
												Наименование QRQ
											</td>
											<td>
												Код QRQ
											</td>
										</tr>
									</thead>
									<tbody>
										'.$tr.'
									</tbody>
								</table>
								';
				}
				
		}

		return array('code'=>$code);
	}
	
	// ЭКСПОРТ - Передаем в 1с последнюю сохраненную един.измер.
	function saved1cMeasure( $p=array() ){
		
		$in = fieldIn($p, array('company_id'));

		$json = '';
		$arr = array();

		$r = req1cSlovUnit(array('company_id'=>$in['company_id'],'flag'=>'data_1c'));

		foreach($r as $i => $m){
			
			$arr[] = array(	'measure_id'		=> $m['measure_id']
							);
			
		}
		
		$json = json_encode($arr);

		return $json;
	}
	
	// ИМПОРТ - Привязать вид номенклатуры (из файла в базу)
	function BindTypeNom1c( $p=array() ){
		
		$in = fieldIn($p, array('id_1c','company_id'));

		$id_1c = isset($in['id_1c'])? $in['id_1c'] : COMPANY_ID_1C;
		
		$company_id 	= isset($in['company_id'])? 	$in['company_id'] 	: COMPANY_ID;

		$ok = false;
		$json = $tr = $code = '';

		$url = 'https://questrequest.ru/qrq/1C/'.$id_1c.'/typenom.json';
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		
		$json = json_decode($response);
		 
		if(is_array($json)&&!empty($json)){
			foreach ($json as $item){
				
				$Name 		= $item->Name;
				$TypeNomID 	= $item->TypeNomID;
				$data1c		= $item->data1c;
				
				
				// Проверяем есть ли в базе уже этот вид номенклатуры
				$r = req1cTypenom(array('company_id'=>$company_id,'id_1c'=>$TypeNomID));
				
				if(!$r['id']){
					// сохраняем вид номенклатуры из 1с
					$STH = PreExecSQL(" INSERT INTO 1c_typenom (company_id,id_1c,name,data_1c)VALUES(?,?,?,?) " ,
														array( $company_id,$TypeNomID,$Name,$data1c ));
				}
				
			}
			$ok = true;
		}
		

		return $ok;
	}
	
	// ЭКСПОРТ - Передаем в 1с последние сохраненные номенклатуры
	function saved1cTypeNom( $p=array() ){
		
		$in = fieldIn($p, array('company_id'));

		$json = '';
		$arr = array();

		$r = req1cTypenom(array('company_id'=>$in['company_id'],'flag'=>'data_1c'));

		foreach($r as $i => $m){
			
			$arr[] = array(	'id_1c'	=> $m['id_1c']
							);
			
		}
		
		$json = json_encode($arr);

		return $json;
	}
	
	
	// Вся форма Привязать вид номенклатуры
	function TrBindTypeNom1c( $p=array() ){
		
		//$in = fieldIn($p, array('where'));
		
		$row = req1cTypenomCategoies(array('company_id'=>COMPANY_ID,'flag'=>'bind_form'));

		$tr = '';
		foreach($row as $k=>$m){

				$tr .= self::TrOneBindTypeNom1c(array(	'id'			=> $m['id'],
														'1c_typenom_id'	=> $m['1c_typenom_id'],
														'categories_id'	=> $m['categories_id'] ));

		}

		return $tr;
	}
	
	
	// строка формы Привязать вид номенклатуры
	function TrOneBindTypeNom1c( $p=array() ){
		
		$in = fieldIn($p, array('id','1c_typenom_id','categories_id'));
		
		$in['id'] = ($in['id']=='999999999999999999')? 0 : $in['id'];
		

		$code ='
				<div class="container">
                    <div class="amc-row">
                        <div class="amc-col-22 form-group">
								'.$this->Select(	array(	'id'		=> 'select_1c_typenom_id'.$in['id'].'',
														'class'		=> 'form-control select2 save_1c_typenom_categoies',
														'value'		=> $in['1c_typenom_id'],
														'data'		=> array('placeholder'=>'1C' , 'id'=>$in['id'])
													),
												array(	'func'		=> 'req1cTypenom',
														'param'		=> array('' => ''),
														'opt'		=> array('id'=>'','name'=>'1C', 'dopol'=>'selected disabled'),
														'option'	=> array('id'=>'id','name'=>'name')
													)
											).'
                        </div>
                        <div class="amc-col-22 form-group">
								'.$this->Select(	array(	'id'		=> 'select_1c_typenom_categories_id'.$in['id'].'',
														'class'		=> 'form-control select2 save_1c_typenom_categoies',
														'value'		=> $in['categories_id'],
														'data'		=> array('placeholder'=>'QRQ' , 'id'=>$in['id'])
													),
												array(	'func'		=> 'reqSlovCategories',
														'param'		=> array('active' => '1'),
														'opt'		=> array('id'=>'','name'=>'QRQ', 'dopol'=>'selected disabled'),
														'option'	=> array('id'=>'id','name'=>'lcategories')
													)
											).'
                        </div>
					</div>
				</div>';
		

		return $code;
	}
	
	
	// ИМПОРТ - Привязать склады (из файла в базу)
	function BindStock1c( $p=array() ){
		
		$in = fieldIn($p, array('id_1c','company_id'));
		
		$id_1c = isset($in['id_1c'])? $in['id_1c'] : COMPANY_ID_1C;
		
		$company_id 	= isset($in['company_id'])? 	$in['company_id'] 	: COMPANY_ID;

		$ok = false;
		$json = $tr = $code = '';

		$url = 'https://questrequest.ru/qrq/1C/'.$id_1c.'/wh.json';
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		
		$json = json_decode($response);
		 
		if(is_array($json)&&!empty($json)){
			foreach ($json as $item){
				
				$Name 	= $item->Name;
				$WhID 	= $item->WhID;
				$data1c	= $item->data1c;
				
				
				// Проверяем есть ли в базе уже этот склад
				$r = req1cStock(array('company_id'=>$company_id,'id_1c'=>$WhID));
				
				if(!$r['id']){
					// сохраняем склад из 1с
					$STH = PreExecSQL(" INSERT INTO 1c_stock (company_id,id_1c,name,data_1c)VALUES(?,?,?,?) " ,
														array( $company_id,$WhID,$Name,$data1c ));
				}
				
			}
			$ok = true;
		}
		

		return $ok;
	}
	
	
	// ЭКСПОРТ - Передаем в 1с последние сохраненные номенклатуры
	function saved1cStock( $p=array() ){
		
		$in = fieldIn($p, array('company_id'));

		$json = '';
		$arr = array();

		$r = req1cStock(array('company_id'=>$in['company_id'],'flag'=>'data_1c'));

		foreach($r as $i => $m){
			
			$arr[] = array(	'id_1c'	=> $m['id_1c']
							);
			
		}
		
		$json = json_encode($arr);

		return $json;
	}
	
	
	// Вся форма Привязать Склады
	function TrBindStock1c( $p=array() ){
		
		$in = fieldIn($p, array('id'));
		
		$row = req1cStockStock(array('company_id'=>COMPANY_ID,'flag'=>'bind_form'));

		$tr = '';
		foreach($row as $k=>$m){

				$tr .= self::TrOneBindStock1c(array(	'id'			=> $m['id'],
													'1c_stock_id'	=> $m['1c_stock_id'],
													'stock_id'		=> $m['id'] ));

		}

		return $tr;
	}
	
	
	// строка формы Привязать Склады
	function TrOneBindStock1c( $p=array() ){
		
		$in = fieldIn($p, array('id','1c_stock_id','stock_id'));
		
		$in['id'] = ($in['id']=='999999999999999999')? 0 : $in['id'];
		

		$code ='
				<div class="container">
                    <div class="amc-row">
                        <div class="amc-col-22 form-group">
								'.$this->Select(	array(	'id'		=> 'select_1c_stock_id'.$in['id'].'',
														'class'		=> 'form-control select2 save_1c_stock_stock',
														'value'		=> $in['1c_stock_id'],
														'data'		=> array('placeholder'=>'1C' , 'id'=>$in['id'])
													),
												array(	'func'		=> 'req1cStock',
														'param'		=> array('' => ''),
														'opt'		=> array('id'=>'','name'=>'1C', 'dopol'=>'selected disabled'),
														'option'	=> array('id'=>'id','name'=>'name')
													)
											).'
                        </div>
                        <div class="amc-col-22 form-group">
								'.$this->Select(	array(	'id'		=> 'select_1c_stock_id_stock'.$in['id'].'',
														'class'		=> 'form-control select2 save_1c_stock_stock',
														'value'		=> $in['stock_id'],
														'data'		=> array('placeholder'=>'QRQ' , 'id'=>$in['id'])
													),
												array(	'func'		=> 'reqStock',
														'param'		=> array('company_id' => COMPANY_ID),
														'opt'		=> array('id'=>'','name'=>'QRQ', 'dopol'=>'selected disabled'),
														'option'	=> array('id'=>'id','name'=>'stock')
													)
											).'
                        </div>
					</div>
				</div>';
		

		return $code;
	}
	
	
	// ИМПОРТ - Привязать компании (из файла в базу)
	function BindCompany1c( $p=array() ){
		
		$in = fieldIn($p, array('id_1c','company_id'));
		
		$id_1c = isset($in['id_1c'])? $in['id_1c'] : COMPANY_ID_1C;
		
		$company_id 	= isset($in['company_id'])? 	$in['company_id'] 	: COMPANY_ID;


		$ok = false;
		$json = $tr = $code = '';

		$url = 'https://questrequest.ru/qrq/1C/'.$id_1c.'/contractor.json';
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		
		$json = json_decode($response);
		 
		if(is_array($json)&&!empty($json)){
			foreach ($json as $item){
				
				$ContractorID 	= $item->ContractorID;
				$Name 		= $item->Name;
				$FullName 	= $item->FullName;
				$INN 		= $item->INN;
				$KPP 		= $item->KPP;
				$data1c		= $item->data1c;
				
				
				// Проверяем есть ли в базе уже компания
				$r = req1cCompany(array('company_id'=>$company_id,'id_1c'=>$ContractorID));
				
				if(!$r['id']){
					// сохраняем компания из 1с
					$STH = PreExecSQL(" INSERT INTO 1c_company (company_id,id_1c,name,fullname,inn,kpp,data_1c)VALUES(?,?,?,?,?,?,?) " ,
														array( $company_id,$ContractorID,$Name,$FullName,$INN,$KPP,$data1c ));
				
					if($STH){
						$ok = true;
					}
				}
			}
		}
		

		return $ok;
	}
	
	
	// ЭКСПОРТ - Передаем в 1с последние контрагенты
	function saved1cСontractor( $p=array() ){
		
		$in = fieldIn($p, array('company_id'));

		$json = '';
		$arr = array();

		$r = req1cCompany(array('company_id'=>$in['company_id'],'flag'=>'data_1c'));

		foreach($r as $i => $m){
			
			$arr[] = array(	'id_1c'	=> $m['id_1c']
							);
			
		}
		
		$json = json_encode($arr);

		return $json;
	}
	
	
	// ИМПОРТ - Привязать номенклатуру (из файла в базу)
	function BindNomenclature1c( $p=array() ){
		
		$in = fieldIn($p, array('id_1c','company_id'));
		
		$id_1c = isset($in['id_1c'])? $in['id_1c'] : COMPANY_ID_1C;
		
		$company_id 	= isset($in['company_id'])? 	$in['company_id'] 	: COMPANY_ID;

		$ok = false;
		$json = $tr = $code = '';

		$url = 'https://questrequest.ru/qrq/1C/'.$id_1c.'/nom.json';
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		
		$json = json_decode($response);
		//vecho($json);
		if(is_array($json)&&!empty($json)){
			foreach ($json as $item){
				
				$NomID 		= $item->NomID;
				$Article 		= $item->Article;
				$Name 		= $item->Name;
				$MeasureID 	= $item->MeasureID;
				$TypeNomID 	= $item->TypeNomID;
				$kod_tovar	= $item->Code;
				$data1c		= $item->data1c;
				$nomenclature_id = $item->nomenclature_id;// возвращается после запроса на добавление номенклатуры в 1С
				

				// Проверяем есть ли в базе уже номенклатура
				$r = req1cNomenclature(array('id_1c'=>$NomID,'company_id'=>$company_id));
				
				$_1c_nomenclature_id = 0;
				$STH = false;

				if(!$r['id']){
					// сохраняем из 1с
					$STH = PreExecSQL(" INSERT INTO 1c_nomenclature (company_id,id_1c,article,name,measure_id,typenom_id_1c,kod_tovar,data_1c)VALUES(?,?,?,?, ?,?,?,?) " ,
														array( $company_id,$NomID,$Article,$Name,$MeasureID,$TypeNomID,$kod_tovar,$data1c ));
					if($STH){
						$ok = true;
						$_1c_nomenclature_id = $GLOBALS['db']->lastInsertId();
						if( !empty($nomenclature_id) && $nomenclature_id>0 && $_1c_nomenclature_id>0 ){
							// привязываем номенклатуру
								$STH = PreExecSQL(" UPDATE nomenclature SET 1c_nomenclature_id=? WHERE id=? AND company_id=?; " ,
																array( $_1c_nomenclature_id,$nomenclature_id,$company_id ));
							// удаляем запрос на создание номенклатуры в 1С
								$STH = PreExecSQL(" DELETE FROM 1c_nomenclature_out WHERE nomenclature_id=?; " ,
																array( $nomenclature_id ));
						}
					}
				}elseif($r['id']&&$nomenclature_id){
						// Проверяем привязана ли номенклатура к 1С
						$rn = reqNomenclature(array('id'=>$nomenclature_id,'company_id'=>$company_id));
						if(!$rn['1c_nomenclature_id']){
							// привязываем номенклатуру
								$STH = PreExecSQL(" UPDATE nomenclature SET 1c_nomenclature_id=? WHERE id=? AND company_id=?; " ,
																array( $r['id'],$nomenclature_id,$company_id ));
							// удаляем запрос на создание номенклатуры в 1С
								$STH = PreExecSQL(" DELETE FROM 1c_nomenclature_out WHERE nomenclature_id=?; " ,
																array( $nomenclature_id ));
							vecho( $nomenclature_id.' - привязана<br/>' );
						}
				}
				
			}
		}
		

		return $ok;
	}
	
	
	// ЭКСПОРТ - Передаем в 1с последние номенклатуры
	function saved1cNom( $p=array() ){
		
		$in = fieldIn($p, array('company_id'));

		$json = '';
		$arr = array();

		$r = req1cNomenclature(array('company_id'=>$in['company_id'],'flag'=>'data_1c'));

		foreach($r as $i => $m){
			
			$arr[] = array(	'id_1c'	=> $m['id_1c']
							);
			
		}
		
		$json = json_encode($arr);

		return $json;
	}
	
	
	
	// ИМПОРТ - Посадить в базу Исполненные от Купленных (отправляемых в 1с Out1cBuy11->questrequest.ru/api/buy11/8d4aada5-13d1-11e9-9403-000c29ba794a)
	// вызывается в questrequest.ru/cron/cron_1c_buy12
	function Save1cBuy12( $p=array() ){
		
		$in = fieldIn($p, array('id_1c','company_id'));
		

		$ok = false;
		$json = '';
		$i = $z = 0;

		$url = 'https://questrequest.ru/qrq/1C/'.$in['id_1c'].'/docreceiptgoods.json';
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		
		$json = json_decode($response);
		 
		if(is_array($json)&&!empty($json)){
			
			foreach ($json as $item0){
			
					$DocID0 	= $item0->DocID;
					$data1c0 	= $item0->data1c;
					$Massiv 	= $item0->Massiv;
			
					foreach ($Massiv as $item){
						
						$i++;
						
						$parent_id 	= $item->buy_sell_id;
						$DocID 		= $item->DocID;
						$StrID 		= $item->StrID;
						$Price 		= $item->Price;
						$NDS 		= $item->NDS;
						$Quantity 	= $item->Quantity;
						$brand 		= $item->Brand;
						
						$DocID_uniq	= $DocID.'+'.$StrID;// формируем уникальный номер записи
						
						echo $parent_id.'***'.$DocID.'***'.$Price.'***'.$NDS.'***'.$Quantity.'***'.$brand.'<br/>';
						
						if($parent_id){
								
								$r = reqBuySell1c_SavedBuy12(array('flag'=>1,'id_1c' => $DocID_uniq));
								//vecho($r);
								if(empty($r)){// ранее не добавлен
									
									echo 'Дожно быть в исполненных'.' = '.$parent_id.'***'.$DocID.'***'.$Price.'***'.$NDS.'***'.$Quantity.'***'.$brand.'<br/>';
									
									$r_p 	= reqBuySell_SaveBuySell(array('id' => $parent_id));// купленное от исполненно

									$arr = reqInsertBuySell(array(	'login_id'			=> $r_p['login_id'],
																	'company_id'		=> $r_p['company_id'],
																	'company_id2'		=> $r_p['company_id2'],
																	'parent_id'			=> $parent_id,
																	'copy_id'			=> $r_p['copy_id'],
																	'flag_buy_sell'		=> 2,
																	'status'			=> 12,
																	'name'				=> '-',
																	'url'				=> 'buried',
																	'cities_id'			=> $r_p['cities_id'],
																	'categories_id'		=> $r_p['categories_id'],
																	'urgency_id'		=> $r_p['urgency_id'],
																	'currency_id'		=> $r_p['currency_id'],
																	'cost'				=> $Price,
																	'cost1'				=> 0,
																	'form_payment_id'	=> $r_p['form_payment_id'],
																	'amount'			=> $Quantity,
																	'amount1'			=> 0,
																	'unit_id1'			=> 0,
																	'amount2'			=> 0,
																	'unit_id2'			=> 0,
																	'comments'			=> '',
																	'comments_company'	=> '',
																	'responsible_id'	=> '',
																	'availability'		=> '',
																	'nomenclature_id'	=> $r_p['nomenclature_id'],
																	'multiplicity'		=> '',
																	'min_party'			=> '',
																	'delivery_id'		=> '',
																	'stock_id'			=> '',
																	'assets_id'			=> ''
																	
																	));
									if($arr['STH']){// сохраняем параметры
											
											$z++;
											
											// Добавляем связь с 1с
											$STH1 = PreExecSQL(" INSERT INTO buy_sell_1c (flag, company_id, buy_sell_id, id_1c, data_1c) VALUES (?,?,?,?,?); " ,
																						array(1, $in['company_id'],$arr['buy_sell_id'],$DocID_uniq,$data1c0 ));
											if($STH1){
									
														// есть ли такой Бренд в нашей базе
													if($brand){
															// сохраняем бренд какой вернулся (учитывая регистр)
															$STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, value) VALUES (?,?,?); " ,
																								array( $arr['buy_sell_id'],2,$brand ));
														
															$key = array_search(mb_strtolower($brand), $arr3, true);
															
															if($key){
																	$STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, attribute_value_id) VALUES (?,?,?); " ,
																									array( $arr['buy_sell_id'],3,$key ));	
															}else{
																	// Если нет добавляем в slov_attribute_value -> attribute_value и возвращаем attribute_value_id 
																	$arr_p = $this->ProverkaAndInsertSlovAttributeValue(array('flag'				=> 'qrq',
																															'categories_id'		=> $r_p['categories_id'],
																															'attribute_id'		=> 3,
																															'attribute_value'	=> $brand ));
																	$attribute_value_id 		= $arr_p['attribute_value_id']; 
																	if($attribute_value_id){
																		$arr3[ $attribute_value_id ] = mb_strtolower($brand);// добавляем новое значение, чтобы повторно не добавлять
																		$STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, attribute_value_id) VALUES (?,?,?); " ,
																										array( $arr['buy_sell_id'],3,$attribute_value_id ));	
																	}

															}
														///
													}
													
													$bs		= new HtmlBuySell();
													
													$bs->ChangeStatusBuy(array(	'row'			=> $r_p,
																				'status'		=> 12,
																				'login_id'		=> $r_p['login_id'],
																				'company_id'	=> $r_p['company_id']
																					));
													/*
													// добавляем товар на склад
													$bs->AddStock(array(	'buy_sell_id'	=> $r_p['id'],
																		'categories_id'	=> $r_p['categories_id'],
																		'flag'			=> 'status_buy_sell_id12' ));
													*/					
																	
											}else{// неудалось занести связь с 1с, удаляем из buy_sell
												$STH = PreExecSQL(" DELETE FROM buy_sell WHERE buy_sell_id=?; " ,
																						array( $arr['buy_sell_id'] ));
											}
											
									}
								}else{
									
									$z++;
									
									echo 'По данному идентификатору есть исполненный заказ '.$DocID.'<br/>';
								}
								
						}

					}
					
				// все заказы посажен к нам и можно занести DocID для дальнейшего снятия с реестра в 1с из выгрузки 
					if($i==$z){
						
						echo 'все элементы посажены = '.$DocID0.'<br/><br/><br/>';
						
						$r = reqBuySell1c_SavedBuy12(array('flag'=>1,'id_1c' => $DocID0));
						if(empty($r)){// ранее не добавлен
							// Добавляем Docid для дальнейшей выгрузки для 1С, чтобы в 1с снять с выгрузки документ (в этом случае buy_sell_id=0)
							$STH1 = PreExecSQL(" INSERT INTO buy_sell_1c (flag, company_id, buy_sell_id, id_1c, data_1c) VALUES (?,?,?,?,?); " ,
																		array(1, $in['company_id'],0,$DocID0,$data1c0 ));
						}
						
					}
				///
		
			}
		}
		

		return $ok;
	}
	
	// ЭКСПОРТ - Передаем в 1с последние исполненные
	function saved1cBuy12( $p=array() ){
		
		$in = fieldIn($p, array('company_id','flag'));

		$json = '';
		$arr = array();

		$r = reqBuySell1c_exportBuy12(array('company_id'=>$in['company_id'],'flag'=>$in['flag']));

		foreach($r as $i => $m){
			
			$arr[] = array(	'id_1c'	=> $m['id_1c']
							);
			
		}
		
		$json = json_encode($arr);

		return $json;
	}
	


	
	// ЭКСПОРТ - Передаем в 1с признак обновить все файлы
	function refresh1cAll( $p=array() ){
		
		$in = fieldIn($p, array('company_id'));

		$json = '';
		$arr = array();

		$r = req1cRefreshAll(array('company_id'=>$in['company_id']));

		if(!empty($r)){
			
			$arr[] = array(	'refresh'	=> true
							);
			
		}
		
		$json = (!empty($arr))? json_encode($arr) : '';

		return $json;
	}	
	

	// ИМПОРТ - Остатки по номенклатуре на складе из 1С (из файла в базу)
	function BindNomenclatureOstatok1c( $p=array() ){
		
		$in = fieldIn($p, array('id_1c','company_id'));
		
		$id_1c 		= isset($in['id_1c'])? 		$in['id_1c'] 		: COMPANY_ID_1C;
		$company_id 	= isset($in['company_id'])? 	$in['company_id'] 	: COMPANY_ID;

		$ok = false;
		$json = $tr = $code = '';

		$url = 'https://questrequest.ru/qrq/1C/'.$id_1c.'/nomost.json';
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		
		$json = json_decode($response);
		 
		if(is_array($json)&&!empty($json)){
			foreach ($json as $item){
				
				$NomID 		= $item->NomID;
				$WhID 		= $item->WhID;
				$Quantity 	= $item->Quantity;// остаток
				$data1c		= $item->data1c;
				
				
				// Проверяем есть ли в базе (только для привязанной номенклатура)
				$r = reqProverka1cNomenclatureStock(array('nomenclature_id_1c'=>$NomID,'stock_id_1c'=>$WhID));
				$nomenclature_id 	= $r['nomenclature_id'];	
				$stock_id			= $r['stock_id'];

				
				if($nomenclature_id>0&&$stock_id>0){// есть привязка номенклатуры и склада из 1C -> к системе QRQ
					
					$r = req1cNomost(array('company_id'=>$company_id,'nomenclature_id_1c'=>$nomenclature_id,'stock_id'=>$stock_id,'one'=>true));
					
					if(!empty($r)){// ранее сохранен остаток Обновляем
						$STH = PreExecSQL(" UPDATE 1c_nomost SET ostatok=? , data_1c=? , data_update=NOW() WHERE nomenclature_id=? AND stock_id=? " ,
															array( $Quantity,$data1c,$nomenclature_id,$stock_id ));
						$str = 'обновлен';
					}else{// сохраняем остаток за номенклатурой
						$STH = PreExecSQL(" INSERT INTO 1c_nomost (company_id,nomenclature_id,stock_id,ostatok,data_1c,id_1c_nomid)VALUES(?,?,?,?,?,?) " ,
															array( $company_id,$nomenclature_id,$stock_id,$Quantity,$data1c,$NomID ));
						$str = 'добавлен';
					}
					
					
					if($STH){
						$ok = true;
						echo '<br/>'.$NomID.' | '.$WhID.' - обработан ('.$str.') - '.$data1c;
					}

				}
				
			}
		}
		

		return $ok;
	}
	
	// ЭКСПОРТ - Передаем в 1с последние остатки
	function saved1cNomost( $p=array() ){
		
		$in = fieldIn($p, array('company_id'));

		$json = '';
		$arr = array();

		$r = req1cNomost(array('company_id'=>$in['company_id'],'flag'=>'data_1c'));

		foreach($r as $i => $m){
			
			$arr[] = array(	'id_1c'	=> $m['id_1c_nomid']
							);
			
		}
		
		$json = json_encode($arr);

		return $json;
	}
	
	
	// ИМПОРТ - сохраняем buy_sell_id переданные купленные в 1с (Out1cBuy11->questrequest.ru/api/buy11/8d4aada5-13d1-11e9-9403-000c29ba794a)
	// вызывается в questrequest.ru/cron/cron_1c_buy12
	function Save1cBuySellId_Out1cBuy11( $p=array() ){
		
		$in = fieldIn($p, array('id_1c'));
		
		$ok = false;
		$json = '';

		$url = 'https://questrequest.ru/qrq/1C/'.$in['id_1c'].'/buy11.json';
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		
		$json = json_decode($response);
		 
		if(is_array($json)&&!empty($json)){
			foreach ($json as $item){
				
				$buy_sell_id = $item->buy_sell_id;
				
				// Проверяем есть ли в базе 
				$r = req1cOutbuy11(array('buy_sell_id'=>$buy_sell_id));
				
				if(!$r['buy_sell_id']){
					// сохраняем 
					$STH = PreExecSQL(" INSERT INTO 1c_outbuy11 (buy_sell_id)VALUES(?) " ,
														array( $buy_sell_id ));
					echo '<br/>обработан -> '.$buy_sell_id;
				}else{
					echo '<br/>ранее обработан -> '.$buy_sell_id;
				}
				
			}
			$ok = true;
		}
		

		return $ok;
	}
	
	
	// ИМПОРТ - сохраняем buy_sell_id переданные исполненные для заказчика в 1с (Out1cBuy12->questrequest.ru/api/buy12/8d4aada5-13d1-11e9-9403-000c29ba794a)
	// вызывается в questrequest.ru/cron/cron_1c_buy12
	function Save1cBuySellId_Out1cBuy12( $p=array() ){
		
		$in = fieldIn($p, array('id_1c'));
		
		$ok = false;
		$json = '';

		$url = 'https://questrequest.ru/qrq/1C/'.$in['id_1c'].'/buy12.json';
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		
		$json = json_decode($response);
		 
		if(is_array($json)&&!empty($json)){
			foreach ($json as $item){
				
				$buy_sell_id = $item->buy_sell_id;
				
				// Проверяем есть ли в базе 
				$r = req1cOutbuy12(array('buy_sell_id'=>$buy_sell_id));
				
				if(!$r['buy_sell_id']){
					// сохраняем 
					$STH = PreExecSQL(" INSERT INTO 1c_outbuy12 (buy_sell_id)VALUES(?) " ,
														array( $buy_sell_id ));
					echo '<br/>обработан -> '.$buy_sell_id;
				}else{
					echo '<br/>ранее обработан -> '.$buy_sell_id;
				}
				
			}
			$ok = true;
		}
		

		return $ok;
	}
	
	
	// ИМПОРТ - сохраняем понимание , что Купленное стало Исполненное из 1C
	// вызывается в questrequest.ru/cron/...
	function Save1cBuySellId_Out1cBuy11_12( $p=array() ){
		
		$bs		= new HtmlBuySell();
		
		$in = fieldIn($p, array('id_1c','company_id'));
		

		$ok = false;
		$json = '';
		$i = $z = 0;

		$url = 'https://questrequest.ru/qrq/1C/'.$in['id_1c'].'/docimplementation.json';
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		//echo 'Ошибка curl: ' . curl_error($ch);
		curl_close($ch);
		
		$json = json_decode($response);

		//vecho($response); 
		if(is_array($json)&&!empty($json)){
			
			foreach ($json as $item0){
			
					$DocID0 	= $item0->DocID;
					$data1c0 	= $item0->data1c;
					$Massiv 	= $item0->Massiv;
			
					foreach ($Massiv as $item){
						
						$i++;
						
						$parent_id 	= $item->buy_sell_id;
						$DocID 		= $item->DocID;
						$StrID 		= $item->StrID;
						$ContractorID	= $item->ContractorID;
						$NomID		= $item->NomID;
						$NDS 		= $item->NDS;
						$Price		= $item->Price;
						$Quantity 	= $item->Quantity;
						$brand 		= $item->Brand;
						
						
						$form_payment_id = ($NDS)? 1 : 2;
						
						
						$DocID_uniq	= $DocID.'+'.$StrID;// формируем уникальный номер записи
						

						$r = reqBuySell1c_SavedBuy12(array('flag'=>3,'id_1c' => $DocID_uniq));
						//vecho($r);
						if(empty($r)){// ранее не обработан
						
							if($parent_id>0){
								
									echo 'Дожна быть отметка в купленных, что исполненно в 1С'.' = '.$parent_id.'<br/>';
									
									$STH = PreExecSQL(" UPDATE buy_sell SET comments=CONCAT('Исполненно в 1С ',comments) WHERE id=? ; " ,
																		array($parent_id ));
									if($STH){									
											// Добавляем связь с 1с
											$STH1 = PreExecSQL(" INSERT INTO buy_sell_1c (flag, company_id, buy_sell_id, id_1c, data_1c) VALUES (?,?,?,?,?); " ,
																						array(3, $in['company_id'],$parent_id,$DocID_uniq,$data1c0 ));
											
											$bs->SaveCacheBuySell(array('buy_sell_id'=>$parent_id,'flag_buy_sell'=>1));
									}
							
							}else{// добавляем в купленное
									
									
									
									// получаем контрагента у кого купили по ContractorID
									$rc = req1cCompanyCompanyById1c(array('id_1c'=>$ContractorID,'company_id'=>$in['company_id']));
									$company_id2 = $rc['company_id_to'];
									
									$rn = reqNomenclatureById1c(array('id_1c'=>$NomID,'company_id'=>$in['company_id']));
									$categories_id = $rn['categories_id'];
									$nomenclature_id = $rn['nomenclature_id'];
									
									
									// получаем login_id
									$r = reqCompany(array('id'=>$company_id2));
									$login_id = $r['login_id'];
									
									
									if( $login_id && $company_id2 && $categories_id && $nomenclature_id ){// есть привязка
											
											echo 'добавляем в купленное '.$DocID.'<br/>';
											
											
											$arr = reqInsertBuySell(array(	'login_id'			=> $login_id,
																			'company_id'		=> $company_id2,
																			'company_id2'		=> $in['company_id'],
																			'parent_id'			=> 0,
																			'copy_id'			=> 0,
																			'flag_buy_sell'		=> 2,
																			'status'			=> 11,
																			'name'				=> '-',
																			'url'				=> 'buy1c',
																			'cities_id'			=> 1,
																			'categories_id'		=> $categories_id,
																			'urgency_id'		=> 5,
																			'currency_id'		=> 1,
																			'cost'				=> $Price,
																			'cost1'				=> 0,
																			'form_payment_id'	=> $form_payment_id,
																			'amount'			=> $Quantity,
																			'amount1'			=> 0,
																			'unit_id1'			=> 0,
																			'amount2'			=> 0,
																			'unit_id2'			=> 0,
																			'comments'			=> '',
																			'comments_company'	=> '',
																			'responsible_id'	=> '',
																			'availability'		=> '',
																			'nomenclature_id'	=> $nomenclature_id,
																			'multiplicity'		=> '',
																			'min_party'			=> '',
																			'delivery_id'		=> '',
																			'stock_id'			=> '',
																			'assets_id'			=> ''
																			
																			));
											if($arr['STH']){// сохраняем параметры
													
													$z++;
													
													// Добавляем связь с 1с
													$STH1 = PreExecSQL(" INSERT INTO buy_sell_1c (flag, company_id, buy_sell_id, id_1c, data_1c) VALUES (?,?,?,?,?); " ,
																								array(3, $in['company_id'],$arr['buy_sell_id'],$DocID_uniq,$data1c0 ));
													if($STH1){
											
																// есть ли такой Бренд в нашей базе
															if($brand){
																	// сохраняем бренд какой вернулся (учитывая регистр)
																	$STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, value) VALUES (?,?,?); " ,
																										array( $arr['buy_sell_id'],2,$brand ));
																
																	$key = array_search(mb_strtolower($brand), $arr3, true);
																	
																	if($key){
																			$STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, attribute_value_id) VALUES (?,?,?); " ,
																											array( $arr['buy_sell_id'],3,$key ));	
																	}else{
																			// Если нет добавляем в slov_attribute_value -> attribute_value и возвращаем attribute_value_id 
																			$arr_p = $this->ProverkaAndInsertSlovAttributeValue(array('flag'				=> 'qrq',
																																	'categories_id'		=> $r_p['categories_id'],
																																	'attribute_id'		=> 3,
																																	'attribute_value'	=> $brand ));
																			$attribute_value_id 		= $arr_p['attribute_value_id']; 
																			if($attribute_value_id){
																				$arr3[ $attribute_value_id ] = mb_strtolower($brand);// добавляем новое значение, чтобы повторно не добавлять
																				$STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, attribute_value_id) VALUES (?,?,?); " ,
																												array( $arr['buy_sell_id'],3,$attribute_value_id ));	
																			}

																	}
																///
															}
																			
																			
													}else{// неудалось занести связь с 1с, удаляем из buy_sell
														$STH = PreExecSQL(" DELETE FROM buy_sell WHERE buy_sell_id=?; " ,
																								array( $arr['buy_sell_id'] ));
													}
													
											}
											
									}
									
							}
							
							
						}else{
							
							$z++;
							
							$dop = ($parent_id>0)? 'ОТМЕТКА' : 'ДОБАВЛЕН';
							
							echo 'По данному идентификатору есть '.$dop.' в купленных '.$DocID.'<br/>';
						}

					}
					
				// все заказы посажен к нам и можно занести DocID для дальнейшего снятия с реестра в 1с из выгрузки 
					if($i==$z){
						
						echo 'все элементы посажены = '.$DocID0.'<br/><br/><br/>';
						
						$r = reqBuySell1c_SavedBuy12(array('flag'=>3,'id_1c' => $DocID0));
						if(empty($r)){// ранее не добавлен
							// Добавляем Docid для дальнейшей выгрузки для 1С, чтобы в 1с снять с выгрузки документ (в этом случае buy_sell_id=0)
							$STH1 = PreExecSQL(" INSERT INTO buy_sell_1c (flag, company_id, buy_sell_id, id_1c, data_1c) VALUES (?,?,?,?,?); " ,
																		array(3,$in['company_id'],0,$DocID0,$data1c0 ));
						}
						
					}
				///
		
			}
		}
		

		return $ok;
	}
	
	
	// Сохраняем из 1С переданные данные
	function cron1cBindAllSpravochniki( $m=array() ){
	
		// ИМПОРТ - Привязать единицы измерения
		self::BindUnit1c(array( 'id_1c' => $m['id_1c'] , 'company_id' => $m['company_id'] ));
		echo '<br/>единицы измерения';
		
		sleep(2);
		
		// ИМПОРТ - Привязать вид номенклатуры
		self::BindTypeNom1c(array( 'id_1c' => $m['id_1c'] , 'company_id' => $m['company_id'] ));
		echo '<br/>вид номенклатуры';
		
		sleep(2);
		
		// ИМПОРТ - Привязать склады
		self::BindStock1c(array( 'id_1c' => $m['id_1c'] , 'company_id' => $m['company_id'] ));
		echo '<br/>склады';
		
		sleep(2);
		
		// ИМПОРТ - Привязать компании
		self::BindCompany1c(array( 'id_1c' => $m['id_1c'] , 'company_id' => $m['company_id'] ));
		echo '<br/>компании';
		
		sleep(2);
		
		// ИМПОРТ - Привязать номенклатуру
		self::BindNomenclature1c(array( 'id_1c' => $m['id_1c'] , 'company_id' => $m['company_id'] ));
		echo '<br/>номенклатуру';
		
		sleep(2);

	
		return '';
	}
	
	
	// ОБНОВИТЬ ВСЕ из 1С И СПРАВОЧНИКИ И ДАННЫЕ
	function Cron1cSave( $m=array() ){

			
			// получаем включены ли навыки у пользователя
			$rcv = reqCompanyVipFunctionByCompanyId(array('company_id' => $m['id']));


			// сажаем справочники
			self::cron1cBindAllSpravochniki(array( 'id_1c' => $m['id_1c'] , 'company_id' => $m['id'] ));
			
			
			if($rcv['flag_ispolnen']){// включено "исполение" на странице навыки
			
				//  Посадить в базу Исполненные от Купленных
				echo '<br/>Исполненные от Купленных<br/>';
				$arr = self::Save1cBuy12(array( 'id_1c' => $m['id_1c'] , 'company_id' => $m['id'] ));
				sleep(2);
				
				
				// сохраняем buy_sell_id переданные купленные (чтобы повторно их не отдавать)
				$arr = self::Save1cBuySellId_Out1cBuy11(array( 'id_1c' => $m['id_1c'] ));
				sleep(2);
				
			}
			
			if($rcv['flag_ostatki']){// включено "остатки" на странице навыки
			
				//  Посадить в базу Остатки для склада
				echo '<br/>Остатки для склада';
				self::BindNomenclatureOstatok1c(array( 'id_1c' => $m['id_1c'] , 'company_id' => $m['id'] ));
				sleep(2);
				
			}
			
			if($rcv['flag_unii_prodavec']){// включено "Юный продавец" на странице навыки
			
				// сохраняем buy_sell_id переданные исполненные, для заказчика (чтобы повторно их не отдавать)
				echo '<br/>Посадить переданные исполенные для заказчика';
				$arr = self::Save1cBuySellId_Out1cBuy12(array( 'id_1c' => $m['id_1c'] ));
				sleep(2);
				
				// 
				echo '<br/>Посадить понимание, что купленные исполненны в 1С:<br/>';
				$arr = self::Save1cBuySellId_Out1cBuy11_12(array( 'id_1c' => $m['id_1c'] , 'company_id' => $m['id'] ));
				sleep(2);
				
			}
			
			if($rcv['flag_vidacha_tovara']){// включено "Выдача товаров" на странице навыки
			
				// сохраняем активы с 1с (для дальнейшей привязки с нашими активами)
				echo '<br/>Посадить Активы (траспорт)';
				$arr = self::Save1cTransport(array( 'id_1c' => $m['id_1c'] , 'company_id' => $m['id'] ));
				sleep(2);
				
			}
			
		return '';
	}
	
	
	// ЭКСПОРТ - передаем номенклатуры от нас в 1С
	function NomenclatureOut1c( $p=array() ){
		
		$in = fieldIn($p, array('company_id'));

		$json = '';
		$arr = array();

		$r = req1cNomenclatureOut(array('company_id'=>$in['company_id']));

		foreach($r as $i => $m){
			
			$arr[] = array(	'OrgID'			=> $m['id_1c'],
							'Article'		=> $m['articul'],
							'Name'			=> $m['name'],
							'MeasureID'		=> $m['measureid'],
							'TypeNomID'		=> $m['typenomid'],
							'nomenclature_id'=> $m['nomenclature_id']
							);
			
		}
		
		$json = json_encode($arr);

		return $json;
	}
	
	
	// ИМПОРТ - сохраняем активы с 1с (для дальнейшей привязки с нашими активами)
	function Save1cTransport( $p=array() ){
		
		$bs		= new HtmlBuySell();
		
		$in = fieldIn($p, array('id_1c','company_id'));
		

		$ok = false;
		$json = '';

		$url = 'https://questrequest.ru/qrq/1C/'.$in['id_1c'].'/transport.json';
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		
		$json = json_decode($response);

		//vecho($response);
		if(is_array($json)&&!empty($json)){
			
			foreach ($json as $item0){
			
					$data1c 		= $item0->data1c;
					$AutoID 		= $item0->AutoID;
					$ModelName 	= $item0->ModelName;
					$RegNumber 	= $item0->RegNumber;
					$LastDriver 	= $item0->LastDriver;
			
					// проверяем сохранен ли ранее
					$r = req1cTransport(array('id_1c'=>$AutoID));
			
					if(empty($r)){
				
						$STH = PreExecSQL(" INSERT INTO 1c_transport (company_id, id_1c, modelname, regnumber, lastdriver, data1c) VALUES (?,?,?,?,?,?); " ,
																		array($in['company_id'],$AutoID,$ModelName,$RegNumber,$LastDriver,$data1c ));
						if($STH){
								// 
								echo 'посажена = '.$ModelName.'<br/>';
								$ok = true;
						}
						
					}
		
			}
		}
		

		return $ok;
	}
	
	
	// ИМПОРТ - сохраняем выдачу на складе из 1C
	function Save1cDocmoving( $p=array() ){
		
		$bs		= new HtmlBuySell();
		
		$in = fieldIn($p, array('id_1c','company_id'));
		

		$ok = false;
		$json = '';
		$i = $z = 0;

		$url = 'https://questrequest.ru/qrq/1C/'.$in['id_1c'].'/docmoving.json';
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		//echo 'Ошибка curl: ' . curl_error($ch);
		curl_close($ch);
		
		$json = json_decode($response);

		//vecho($response); 
		if(is_array($json)&&!empty($json)){
			
			foreach ($json as $item0){
			
					$DocID0 	= $item0->DocID;
					$data1c0 	= $item0->data1c;
					$Massiv 	= $item0->Massiv;
			
					foreach ($Massiv as $item){
						
						$i++;
						
						
						$DocID 		= $item->DocID;
						$StrID 		= $item->StrID;
						$AutoID		= $item->AutoID;
						$WhIDIn		= $item->WhIDIn;
						$NomID		= $item->NomID;
						$Quantity 	= $item->Quantity;
						$brand 		= $item->Brand;
						
						
						$DocID_uniq	= $DocID.'+'.$StrID;// формируем уникальный номер записи
						

						$r = reqBuySell1c_SavedBuy12(array('flag'=>4,'id_1c' => $DocID_uniq));
						//vecho($r);
						if(empty($r)){// ранее не обработан
									
									$rn = reqNomenclatureById1c(array('id_1c'=>$NomID,'company_id'=>$in['company_id']));
									$categories_id = $rn['categories_id'];
									$nomenclature_id = $rn['nomenclature_id'];
									
									
									// получаем login_id
									$r = reqCompany(array('id'=>$in['company_id']));
									$login_id = $r['login_id'];
									
									echo 'добавляем выдачу '.$DocID.' - '.$login_id.' - '.$categories_id.' - '.$nomenclature_id.'<br/>';
									
									if( $login_id && $categories_id && $nomenclature_id ){// есть привязка
											
											echo 'добавляем выдачу '.$DocID.' - '.$login_id.' - '.$categories_id.' - '.$nomenclature_id.'<br/>';
											
											/*
											$arr = reqInsertBuySell(array(	'login_id'			=> $login_id,
																			'company_id'		=> $company_id2,
																			'company_id2'		=> $in['company_id'],
																			'parent_id'			=> 0,
																			'copy_id'			=> 0,
																			'flag_buy_sell'		=> 2,
																			'status'			=> 11,
																			'name'				=> '-',
																			'url'				=> 'buy1c',
																			'cities_id'			=> 1,
																			'categories_id'		=> $categories_id,
																			'urgency_id'		=> 5,
																			'currency_id'		=> 1,
																			'cost'				=> $Price,
																			'cost1'				=> 0,
																			'form_payment_id'	=> $form_payment_id,
																			'amount'			=> $Quantity,
																			'amount1'			=> 0,
																			'unit_id1'			=> 0,
																			'amount2'			=> 0,
																			'unit_id2'			=> 0,
																			'comments'			=> '',
																			'comments_company'	=> '',
																			'responsible_id'	=> '',
																			'availability'		=> '',
																			'nomenclature_id'	=> $nomenclature_id,
																			'multiplicity'		=> '',
																			'min_party'			=> '',
																			'delivery_id'		=> '',
																			'stock_id'			=> '',
																			'assets_id'			=> ''
																			
																			));
											
											if($arr['STH']){// сохраняем параметры
													
													$z++;
													
													// Добавляем связь с 1с
													$STH1 = PreExecSQL(" INSERT INTO buy_sell_1c (flag, company_id, buy_sell_id, id_1c, data_1c) VALUES (?,?,?,?,?); " ,
																								array(4, $in['company_id'],$arr['buy_sell_id'],$DocID_uniq,$data1c0 ));
													if($STH1){
											
																// есть ли такой Бренд в нашей базе
															if($brand){
																	// сохраняем бренд какой вернулся (учитывая регистр)
																	$STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, value) VALUES (?,?,?); " ,
																										array( $arr['buy_sell_id'],2,$brand ));
																
																	$key = array_search(mb_strtolower($brand), $arr3, true);
																	
																	if($key){
																			$STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, attribute_value_id) VALUES (?,?,?); " ,
																											array( $arr['buy_sell_id'],3,$key ));	
																	}else{
																			// Если нет добавляем в slov_attribute_value -> attribute_value и возвращаем attribute_value_id 
																			$arr_p = $this->ProverkaAndInsertSlovAttributeValue(array('flag'				=> 'qrq',
																																	'categories_id'		=> $r_p['categories_id'],
																																	'attribute_id'		=> 3,
																																	'attribute_value'	=> $brand ));
																			$attribute_value_id 		= $arr_p['attribute_value_id']; 
																			if($attribute_value_id){
																				$arr3[ $attribute_value_id ] = mb_strtolower($brand);// добавляем новое значение, чтобы повторно не добавлять
																				$STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, attribute_value_id) VALUES (?,?,?); " ,
																												array( $arr['buy_sell_id'],3,$attribute_value_id ));	
																			}

																	}
																///
															}
																			
																			
													}else{// неудалось занести связь с 1с, удаляем из buy_sell
														$STH = PreExecSQL(" DELETE FROM buy_sell WHERE buy_sell_id=?; " ,
																								array( $arr['buy_sell_id'] ));
													}
													
											}
											*/
									}
								
						}else{
							
							$z++;
							
							$dop = ($parent_id>0)? 'ОТМЕТКА' : 'ДОБАВЛЕН';
							
							echo 'По данному идентификатору есть '.$dop.' в купленных '.$DocID.'<br/>';
						}

					}
					
				// все заказы посажен к нам и можно занести DocID для дальнейшего снятия с реестра в 1с из выгрузки 
					/*if($i==$z){
						
						echo 'все элементы посажены = '.$DocID0.'<br/><br/><br/>';
						
						$r = reqBuySell1c_SavedBuy12(array('flag'=>4,'id_1c' => $DocID0));
						if(empty($r)){// ранее не добавлен
							// Добавляем Docid для дальнейшей выгрузки для 1С, чтобы в 1с снять с выгрузки документ (в этом случае buy_sell_id=0)
							$STH1 = PreExecSQL(" INSERT INTO buy_sell_1c (flag, company_id, buy_sell_id, id_1c, data_1c) VALUES (?,?,?,?,?); " ,
																		array(4,$in['company_id'],0,$DocID0,$data1c0 ));
						}
						
					}*/
				///
		
			}
		}
		

		return $ok;
	}
	
	
	

}
?>