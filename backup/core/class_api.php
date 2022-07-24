<?php
	/*
	 *  Интеграция с 1С api
	 */
	 
class ClassApi extends HtmlServive 
{
	// Номенклатура отдаем
	function OutNomenclature( $p=array() ){
		
		$in = fieldIn($p, array('company_id'));

		$json = '';
		$arr = array();

		$r = reqNomenclature(array('company_id'=>$in['company_id']));

		foreach($r as $i => $m){
			
			$arr[] = array(	'vid'		=> 'vid',
							'id'		=> $m['id'],
							'name'		=> $m['name'],
							'articul'	=> 'articul',
							'unit'		=> 'unit'
						);
			
		}
		/*
		$array = array(
			1 => 'Номер один',
			'two' => 2,
			'three' => 'Это номер три',
			4 => 4
		);
		*/
		
		$json = json_encode($arr);

		return $json;
	}
	
	
	// Привязать единицы измерения
	function BindUnit1c( $p=array() ){
		
		//$in = fieldIn($p, array('company_id'));

		$json = $tr = $code = '';
		
		$url = 'https://questrequest.ru/qrq/1C/'.COMPANY_ID_1C.'/measure.json';
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		
		// очищаем временную таблицу значения ед.изм. из 1с
		$STH = PreExecSQL(" DELETE FROM 1c_slov_unit WHERE company_id=?; " ,
											array( COMPANY_ID ));
		
		$json = json_decode($response);
		 
		if(is_array($json)&&!empty($json)){
			foreach ($json as $item){
				
				$Name 		= $item->Name;
				$MeasureID 	= $item->MeasureID;
				
				// сохраняем во временную таблицу значения ед.изм. из 1с
				$STH = PreExecSQL(" INSERT INTO 1c_slov_unit (company_id,name,measure_id)VALUES(?,?,?) " ,
													array( COMPANY_ID,$Name,$MeasureID ));
				
			}
		}
		
		
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
		

		return array('code'=>$code);
	}
	
	
	// Привязать вид номенклатуры (из файла в базу)
	function BindTypeNom1c( $p=array() ){
		
		//$in = fieldIn($p, array('company_id'));

		$ok = false;
		$json = $tr = $code = '';

		$url = 'https://questrequest.ru/qrq/1C/'.COMPANY_ID_1C.'/typenom.json';
		
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
				
				
				// Проверяем есть ли в базе уже этот вид номенклатуры
				$r = req1cTypenom(array('id_1c'=>$TypeNomID));
				
				if(!$r['id']){
					// сохраняем вид номенклатуры из 1с
					$STH = PreExecSQL(" INSERT INTO 1c_typenom (company_id,id_1c,name)VALUES(?,?,?) " ,
														array( COMPANY_ID,$TypeNomID,$Name ));
				}
				
			}
			$ok = true;
		}
		

		return $ok;
	}
	
	
	// Вся форма Привязать вид номенклатуры
	function TrBindTypeNom1c( $p=array() ){
		
		$in = fieldIn($p, array('id'));
		
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
	
	
	// Привязать склады (из файла в базу)
	function BindStock1c( $p=array() ){
		
		//$in = fieldIn($p, array('company_id'));

		$ok = false;
		$json = $tr = $code = '';

		$url = 'https://questrequest.ru/qrq/1C/'.COMPANY_ID_1C.'/wh.json';
		
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
				
				
				// Проверяем есть ли в базе уже этот склад
				$r = req1cStock(array('id_1c'=>$WhID));
				
				if(!$r['id']){
					// сохраняем склад из 1с
					$STH = PreExecSQL(" INSERT INTO 1c_stock (company_id,id_1c,name)VALUES(?,?,?) " ,
														array( COMPANY_ID,$WhID,$Name ));
				}
				
			}
			$ok = true;
		}
		

		return $ok;
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
	
	
	// Привязать компании (из файла в базу)
	function BindCompany1c( $p=array() ){
		
		//$in = fieldIn($p, array('company_id'));

		$ok = false;
		$json = $tr = $code = '';

		$url = 'https://questrequest.ru/qrq/1C/'.COMPANY_ID_1C.'/contractor.json';
		
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
				$KPP 		= $item->КПП;
				
				
				// Проверяем есть ли в базе уже компания
				$r = req1cCompany(array('id_1c'=>$ContractorID));
				
				if(!$r['id']){
					// сохраняем компания из 1с
					$STH = PreExecSQL(" INSERT INTO 1c_company (company_id,id_1c,name,fullname,inn,kpp)VALUES(?,?,?,?,?,?) " ,
														array( COMPANY_ID,$ContractorID,$Name,$FullName,$INN,$KPP ));
				}
				if($STH){
					$ok = true;
				}
			}
		}
		

		return $ok;
	}
	
	
	// Привязать номенклатуру (из файла в базу)
	function BindNomenclature1c( $p=array() ){
		
		//$in = fieldIn($p, array('company_id'));

		$ok = false;
		$json = $tr = $code = '';

		$url = 'https://questrequest.ru/qrq/1C/'.COMPANY_ID_1C.'/nom.json';
		
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
				$Article 		= $item->Article;
				$Name 		= $item->Name;
				$MeasureID 	= $item->MeasureID;
				$TypeNomID 	= $item->TypeNomID;
				
				
				// Проверяем есть ли в базе уже номенклатура
				$r = req1cNomenclature(array('id_1c'=>$NomID));
				
				if(!$r['id']){
					// сохраняем компания из 1с
					$STH = PreExecSQL(" INSERT INTO 1c_nomenclature (company_id,id_1c,article,name,measure_id,typenom_id_1c)VALUES(?,?,?,?,?,?) " ,
														array( COMPANY_ID,$NomID,$Article,$Name,$MeasureID,$TypeNomID ));
					if($STH){
						$ok = true;
					}
				}
				
			}
		}
		

		return $ok;
	}
	
	
	
	

}
?>