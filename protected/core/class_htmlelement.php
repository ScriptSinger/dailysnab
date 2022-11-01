<?php

class HtmlElement {
	
	function ParamArray( $param=array() ){
		$param['value']	 		= (isset($param['value']))? 										$param['value'] 			: '';
		$param['type']			= (isset($param['type'])&&!empty($param['type']))? 				$param['type'] 			: '';
		$param['value']			= (($param['type']=='span')||($param['type']=='button')||($param['type']==''))? 	$param['value'] : htmlspecialchars($param['value'], ENT_QUOTES);		
		$param['div']	 		= (isset($param['div'])&&!empty($param['div']))? 					$param['div'] 			: '';
		$param['id']	 			= (isset($param['id'])&&!empty($param['id']))? 					$param['id'] 			: '';
		$param['name']	 		= (isset($param['name'])&&!empty($param['name']))? 				$param['name'] 			: '';
		$param['class']	 		= (isset($param['class'])&&!empty($param['class']))? 				$param['class'] 			: '';
		$param['label']	 		= (isset($param['label'])&&!empty($param['label']))? 				$param['label'] 			: '';
		$param['data'] 			= (isset($param['data'])&&!empty($param['data']))? 				$param['data'] 			: false;
		$param['placeholder'] 	= (isset($param['placeholder'])&&!empty($param['placeholder']))? 	$param['placeholder'] 	: '';
		$param['disabled'] 		= (isset($param['disabled'])&&!empty($param['disabled']))? 				$param['disabled'] 			: '';
		$param['dopol']	 		= (isset($param['dopol'])&&!empty($param['dopol']))? 				$param['dopol'] 			: '';
		$param['title']	 		= (isset($param['title'])&&!empty($param['title']))? 				$param['title'] 			: '';
		$param['alt']	 		= (isset($param['alt'])&&!empty($param['alt']))? 					$param['alt'] 			: '';
		$param['src']	 		= (isset($param['src'])&&!empty($param['src']))? 					$param['src'] 			: '';
		$param['wh']	 			= (isset($param['wh'])&&!empty($param['wh']))? 					$param['wh'] 			: 0;
		$param['noresize']	 	= (isset($param['noresize'])&&!empty($param['noresize']))? 		$param['noresize'] 		: 0;
		
		$param['param'] 			= (isset($param['param'])&&!empty($param['param']))? 				$param['param'] 			: false;
		$param['opt'] 			= (isset($param['opt'])&&!empty($param['opt']))? 					$param['opt'] 			: false;
		$param['optgroup'] 		= (isset($param['optgroup'])&&!empty($param['optgroup']))? 		$param['optgroup'] 		: false;
		
		return $param;
	}
	
	//data параметры
	function getAttrData($d=array()){
		$data='';
			if(is_array($d)){
				foreach($d as $k=>$v){
					$data .= ' data-'.$k.'="'.$v.'"';
				}
			}
		return $data;
	}
	
	
	//возвращает checed для checkbox
	function checkboxChecked($val=false){
		$rez = ($val)? 'checked':'';
		return $rez;
	}
	
	
	//изображение по высоте ширине
	function ImagesWH($path_images=false,$wh=false){
		$rez = '';
		if($path_images){
			$path_images = $_SERVER['DOCUMENT_ROOT'].$path_images;
		}
		if(file_exists($path_images)){
				$size = getimagesize($path_images);
				$rez='';
				if($size[0]>$size[1]) {
					$rez='width="'.$wh.'"';
				}elseif($size[0]<$size[1]){
					$rez='height="'.$wh.'"';
				}else{
					$rez='width="'.$wh.'" height="'.$wh.'"';
				}
		}
		
		return $rez;
	}	
	
	/**
	 * элемент INPUT
	 *
	 */
	function Input( $param=array() ){
		$html = $label = $data_str = '';
        $number = "this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');";
		$param = $this->ParamArray($param);

			//подписываем lebal'ом если передали
				$label = $this->Label(	array(	'id'	=> $param['id'],
											'label'	=> $param['label']
										)
									);
				
				
			// data параметры
				$data_str = (is_array($param['data']))? $this->getAttrData($param['data']) : $param['data'];
			
				
			//заполняем input
			if($param['type']=='button'||$param['type']=='span'||$param['type']=='a'){
					$html = 	'
							<'.$param['type'].' id="'.$param['id'].'" class="'.$param['class'].'" type="'.$param['type'].'" '.$data_str.' '.$param['dopol'].' '.$param['disabled'].' title="'.$param['title'].'">'.$param['value'].'</'.$param['type'].'>
							';
			/*}elseif($param['type']=='span'||$param['type']=='a'){
					$html = 	'
							<span id="'.$param['id'].'"	class="'.$param['class'].'" '.$data_str.' title="'.$param['title'].'" '.$param['dopol'].'>'.$param['value'].'</span>
							';
			*/}else{
				
					if($param['name']){
						$name = $param['name'];
					}else{
						$name = $param['id'];
					}

                if(!empty($param['onlyNumber'])) {
                    $html = '
								<input type="' . $param['type'] . '" class="' . $param['class'] . '" id="' . $param['id'] . '" name="' . $name . '" placeholder="' . $param['placeholder'] . '" value="' . $param['value'] . '" ' . $data_str . ' ' . $param['dopol'] . ' ' . $param['disabled'] . ' title="' . $param['title'] . '" oninput="' . $number . '""/>
							';
                }elseif(!empty($param['checked'])){
                		$html = '
								<input checked type="' . $param['type'] . '" class="' . $param['class'] . '" id="' . $param['id'] . '" name="' . $name . '" placeholder="' . $param['placeholder'] . '" value="' . $param['value'] . '" ' . $data_str . ' ' . $param['dopol'] . ' ' . $param['disabled'] . ' title="' . $param['title'] . '" />
								<label class="form-check-label" for="companyIn">Продолжить как компания</label>

							';
                }else{
                    $html = '
								<input type="' . $param['type'] . '" class="' . $param['class'] . '" id="' . $param['id'] . '" name="' . $name . '" placeholder="' . $param['placeholder'] . '" value="' . $param['value'] . '" ' . $data_str . ' ' . $param['dopol'] . ' ' . $param['disabled'] . ' title="' . $param['title'] . '" />
							';
                }
			}
			/*
			$div_begin=$div_end='';
			if($param['div']){//для верстки
				$div_begin = '<div '.$param['div'].'>';
				$div_end = '</div>';
			}
			
			$html = 	$label.$div_begin.$html.$div_end;
			*/
			
			$html = 	$label.$html;

		return $html;
	}
	/**
	 * элемент SELECT
	 *
	 *	$param -
	 *			id,class,value,disabled,prava
	 *	$func -
	 *			func 		имя функции 
	 *			param 		параметры функции
	 *			opt			value и наименование нулевого уровеня
	 *			option		option имя для value и имя для option
				optgroup	если указано, то в массиве func - функция для заполнения option
	 */
	function Select( $param=false , $func=array() ){
		
		$req_func=$html=$option=$opt=$disabled=$data_str='';
		
		$param 	= $this->ParamArray($param);
		$func 	= $this->ParamArray($func);
		
		//подписываем lebal'ом если передали
				$label = $this->Label(	array(	'id'	=> $param['id'],
											'label'	=> $param['label']
										)
									);
		// data параметры
				$data_str = (is_array($param['data']))? $this->getAttrData($param['data']) : $param['data'];
				
				
			$req_func 	= $func['func'];//имя функции для заполнения (если есть $func['optgroup'], то это параметры для optgroup !)
			$row 		= $req_func($func['param']);//возвращаем данные для заполнения option или optgroup
			
			//если в select есть optgroup
			if(is_array($func['optgroup'])){
					$s='';
					$req_func_optgroup	= $func['optgroup']['func'];//имя функции для заполнения option
					$row_optgroup		= $req_func_optgroup($func['optgroup']['funcparam']);//возвращаем данные для заполнения option 
					foreach($row as $i => $r){
							$optgroup='';
							foreach($row_optgroup as $ii => $rr){
								if( $rr[ $func['optgroup']['pole'] ] == $r[ $func['option']['id'] ] ){
									$sel		 = ($rr[ $func['optgroup']['id'] ]==$param['value'])? ' selected':'';
									$optgroup	.= '<option'.$sel.' value="'.$rr[ $func['optgroup']['id'] ].'">'.$rr[ $func['optgroup']['name'] ].'</option>';
								}
							}
							$option .= '<optgroup label="'.$r[ $func['option']['name'] ].'">'.$optgroup.'</optgroup>';
					}
					//первый уровень если указан
					if($func['opt']){
						$opt = '<option></option>';
					}
			}else{// select без optgroup
					foreach($row as $i => $r){
						$r['id'] = isset($r['id'])? $r['id'] : '';
						$arr_val = explode(',',$param['value']);//Несколько значений через запятую
						$sel		 = !empty($r['id'])&&in_array($r['id'], $arr_val)? ' selected':'';
						//$sel		 = ($r['id']==$param['value'])? ' selected':'';
						$option 	.= '<option'.$sel.' value="'.$r[ $func['option']['id'] ].'">'.$r[ $func['option']['name'] ].'</option>';
					}
					//первый уровень если указан
					if($func['opt']){
						$func['opt']['dopol'] = isset($func['opt']['dopol'])? $func['opt']['dopol'] : '';
						$opt = '<option value="'.$func['opt']['id'].'" '.$func['opt']['dopol'].'>'.$func['opt']['name'].'</option>';
					}
			}
			
			$div_begin=$div_end='';
			if($param['div']){//для верстки
				$div_begin = '<div '.$param['div'].'>';
				$div_end = '</div>';
			}
			
					if($param['name']){
						$name = $param['name'];
					}else{
						$name = $param['id'];
					}
			
				$html = 	$label.'
						'.$div_begin.'
							<select id="'.$param['id'].'" name="'.$name.'" class="'.$param['class'].'" title="'.$param['title'].'" '.$data_str.' '.$param['disabled'].' '.$param['dopol'].'>
								'.$opt.'
								'.$option.'
							</select>
						'.$div_end.'
						';

		return $html;
	}	
	
	/**
	 * элемент TEXTAREA
	 *
	 */

	function Textarea( $param=false ){
		$label = '';
		
		$param 	= $this->ParamArray($param);
		
			
			//подписываем lebal'ом если передали
				$label = $this->Label(	array(	'id'	=> $param['id'],
											'label'	=> $param['label']
										)
									);
				
				$div_begin=$div_end='';
				if($param['div']){//для верстки
					$div_begin = '<div '.$param['div'].'>';
					$div_end = '</div>';
				}
				
				$html = $label.'
						'.$div_begin.'
							<textarea class="'.$param['class'].'" id="'.$param['id'].'" name="'.$param['id'].'" placeholder="'.$param['placeholder'].'" '.$param['dopol'].' '.$param['disabled'].'>'.$param['value'].'</textarea>
						'.$div_end.'
							';

		return $html;
	}
	
	/**
	 * элемент LABEL
	 *
	 */

	function Label($param=false ){
		$html = '';
		
			if(is_array($param['label'])){
				foreach($param['label'] as $i=>$l){
					$label[$i]=$l;
				}
				$label['class'] 	= (isset($label['class'])&&!empty($label['class']))? $label['class'] : '';
				$label['dopol'] 	= (isset($label['dopol'])&&!empty($label['dopol']))? $label['dopol'] : '';
				
				$html = '<label for="'.$param['id'].'" class="'.$label['class'].'" '.$label['dopol'].'>'.$label['name'].'</label>';
			}

		return $html;
	}
	
	/**
	 * элемент TEXTAREA
	 *
	 */

	function Img( $param=false ){
		$html = '';
		$param 	= $this->ParamArray($param);
		$file 	= $_SERVER['DOCUMENT_ROOT'].$param['src'];
		if(file_exists($file)){		
			$param['title'] = ($param['title'])? 'title="'.$param['title'].'"' : '';
			$param['alt'] = ($param['alt'])? 'alt="'.$param['alt'].'"' : '';
			
			if($param['noresize']){//не нужно пропорцианально сжимать
				$imageswh = 'width="'.$param['wh'].'" height="'.$param['wh'].'"';
			}else{
				$imageswh = $this->ImagesWH($param['src'],$param['wh']);
			}
			// data параметры
			$data_str = (is_array($param['data']))? $this->getAttrData($param['data']) : $param['data'];
				$html ='
						<img src="'.$param['src'].'?'.time().'" class="'.$param['class'].'" id="'.$param['id'].'" name="'.$param['id'].'" '.$imageswh.' '.$data_str.' '.$param['title'].' '.$param['alt'].' '.$param['dopol'].' />
							';
		}

		return $html;
	}


	// Выбор типа атрибута (поля)
	function SelectTypeAttribute( $p=array() ){
		$code = $opt = '';
		foreach($p['row'] as $k=>$m){
			$sel = ($m['id']==$p['id'])? ' selected' : '';
			$opt .= '<option value="'.$m['id'].'" '.$sel.'>'.$m['type_attribute'].'</option>';
		}
		$code = '
				<select id="" name="" class="form-control save_type_attribute" data-id="'.$p['m_id'].'" data-flag="'.$p['flag'].'">
						<option value="0">-</option>
						'.$opt.'
				</select>
				';
		
		return $code;
	}

	// Администрирование - Выбор значения атрибута
	function SelectAttributeValue( $p=array() ){
		$code = $opt = '';
		$arr_av = array();
		$r = reqAttributeValueBySelect(array('categories_id'=>$p['categories_id'],'attribute_id'=>$p['attribute_id']));
		foreach($r as $k=>$m){	
			$arr_av[] = $m['attribute_value_id'];
		}
		
		$row = reqSlovAttributeValue(array('attribute_id'=>$p['attribute_id'],'flag_insert'=>1));
		foreach($row as $k=>$m){
			$sel = (in_array($m['id'], $arr_av))? ' selected' : '';
			$opt .= '<option value="'.$m['id'].'" '.$sel.'>'.$m['id'].' '.$m['attribute_value'].'</option>';
		}
		$code = '
				<select id="" name="" multiple="multiple" class="form-control save_attribute_value" data-categories_id="'.$p['categories_id'].'" data-attribute_id="'.$p['attribute_id'].'">
							'.$opt.'
				</select>
				';
		
		return $code;
	}
	
	// Администрирование - выбор атрибута
	function SelectAttribute( $p=array() ){
		$code = $opt = '';
		$row = reqSlovAttribute(array('flag'=>'not_attribute_id','categories_id'=>$p['categories_id']));
		foreach($row as $k=>$m){
			$opt .= '<option value="'.$m['id'].'">'.$m['attribute'].'</option>';
		}
		$code = '
				<select id="" name="" class="form-control save_attribute" data-categories_id="'.$p['categories_id'].'">
							<option value="0">-</option>
							'.$opt.'
				</select>
				';
		
		return $code;
	}	
	
	// Выбор Покупатель/Продавец в компании
	function SelectWhoCompany( $p=array() ){
		$code = $opt = '';
		$who1 = ($p['who1'])? 1 : 0;
		$who2 = ($p['who2'])? 2 : 0;
		$row = array(	array('id'=>'1','nprava'=>'Продавец'),
						array('id'=>'2','nprava'=>'Покупатель')
					);
		foreach($row as $k=>$m){
			$sel = ( $m['id']==$who1 || $m['id']==$who2 )? ' selected' : '';
			$opt .= '<option value="'.$m['id'].'" '.$sel.'>'.$m['nprava'].'</option>';
		}
		$code = '
				<select id="who_company" name="who_company[]" multiple="multiple" class="form-control select2" data-placeholder="Покупатель/Продавец">
							'.$opt.'
				</select>
				';
		
		return $code;
	}
	
	// Выбор категории в компании
	function SelectCategoriesCompany( $p=array() ){
		$code = $opt = '';
		$r = reqCompanyCategories(array('flag'=>'group_categories_id','company_id'=>$p['company_id']));
		$arr_cc = explode(',',$r['categories_id']);
		$row = reqSlovCategories(array('level'=>3,'active'=>1));
		foreach($row as $k=>$m){
			$sel = (in_array($m['id'], $arr_cc))? ' selected' : '';
			$opt .= '<option value="'.$m['id'].'" '.$sel.'>'.$m['categories'].'</option>';
		}
		$code = '
				<select id="cc_categories" name="cc_categories[]" multiple="multiple" class="form-control select2" data-placeholder="Категория">
							'.$opt.'
				</select>
				';
		
		return $code;
	}
	
	// Выбор Города
	function SelectCities( $p=array() ){
		$code = $opt = '';
		$r = reqCities();
		foreach($r as $k=>$m){
			$sel = ($m['id']==$p['cities_id'])? ' selected' : '';
			$opt .= '<option value="'.$m['id'].'" '.$sel.'>'.$m['name'].'</option>';
		}
		// не использовать ID у select ! (конфликт нескольких элементов на странице (profile.php))
		$code = '
				<select id="" name="cities_id" class="form-control select2" data-placeholder="Город">
						<option value=""></option>
						'.$opt.'
				</select>
				';
		
		return $code;
	}
	
	// Выбор категории Заявка/Объявление
	function SelectCategoriesBuySell( $p=array() ){
		$code = $opt = '';
		$row = reqSlovCategories(array('level'=>3,'active'=>1));
		foreach($row as $k=>$m){
			$sel = ($m['id']==$p['categories_id'])? ' selected' : '';
			$opt .= '<option value="'.$m['id'].'" '.$sel.'>'.$m['categories'].'</option>';
		}
		$code = '
				<select id="categories_id" name="categories_id" class="form-control select2 change_categories_buy_sell" data-flag_buy_sell="'.$p['flag_buy_sell'].'">
							<option></option>
							'.$opt.'
				</select>
				';
		
		return $code;
	}
	
	// Цифровое поле Заявка/Объявление
	function HtmlTypeAttribute1( $p=array() ){
		$in = fieldIn($p, array('value','attribute_id','required','attribute'));
		$dopol = $class = '';
		if($in['required']){
			$dopol 	= 'required data-bv-notempty-message="Введите" required ';
			$class	= 'require-input ';
		}
		$code = '
					'.$this->Input(	array(	'type'			=> 'text',
											'name'			=> 'elem_'.$in['attribute_id'],
											'class'			=> 'form-control vmask1 '.$class.'',
											'value'			=> $in['value'],
											'placeholder'	=> $in['attribute'],
											'dopol'			=> $dopol
										)
								).'
				';
		
		return $code;
	}
	
	// Цифровой период Заявка/Объявление
	function HtmlTypeAttribute2( $p=array() ){
		$in = fieldIn($p, array('value','attribute_id','attribute','required'));
		$dopol = '';
		$arr = explode('до',$in['value']);
		$arr[0] = isset($arr[0])? $arr[0] : '';
		$arr[1] = isset($arr[1])? $arr[1] : '';
		$arr[0] = preg_replace('/[^-\d.]/','',$arr[0]);
		$arr[1] = preg_replace('/[^-\d.]/','',$arr[1]);
		$dopol = $class = '';
		if($in['required']){
			$dopol 	= 'data-bv-notempty-message="Введите" required ';
			$class	= 'require-input';
		}
		$code = 		$this->Input(	array(	'type'			=> 'text',
										'name'			=> 'elem_'.$in['attribute_id'].'[]',
										'class'			=> 'form-control vmask1 pull-left input-from '.$class.'',
										'value'			=> $arr[0],
										'placeholder'	=> $in['attribute'],
										'dopol'			=> 'style="width:90px;" '.$dopol.''
									)
							).'
				<div class="pull-left font26 inputs-separator" style="margin:0px 5px;"> - </div>
				'.$this->Input(	array(	'type'			=> 'text',
										'name'			=> 'elem_'.$in['attribute_id'].'[]',
										'class'			=> 'form-control vmask1 pull-left input-to '.$class.'',
										'value'			=> $arr[1],
										'placeholder'	=> 'до',
										'dopol'			=> 'style="width:90px;" '.$dopol.''
									)
							);
		
		return $code;
	}	
	
	// Текстовое поле Заявка/Объявление
	function HtmlTypeAttribute3( $p=array() ){
		$in = fieldIn($p, array('value','attribute_id','required','attribute'));
		$dopol = $class = '';
		if($in['required']){
			$dopol 	= 'data-bv-notempty-message="Введите" required ';
			$class	= 'require-input';
		}
		$code = '
					'.$this->Input(	array(	'type'			=> 'text',
											'name'			=> 'elem_'.$in['attribute_id'],
											'class'			=> 'form-control '.$class.'',
											'value'			=> $in['value'],
											'placeholder'	=> $in['attribute'],
											'dopol'			=> $dopol
										)
								).'
				';
		/*
		$code = '
					'.$this->Textarea(array(	'id'			=> 'elem_'.$in['attribute_id'],
											'class'			=> 'form-control',
											'value'			=> $in['value'],
											'dopol'			=> 'rows="2" '.$dopol.''
							)).'
				';
		*/
		return $code;
	}
	
	
	// Выпадающий список (все варианты) Заявка/Объявление
	function HtmlTypeAttribute4567( $p=array() ){
		$in = fieldIn($p, array('id','categories_id','attribute_id','multiple','new','required','attribute','flag','id2','status'));
		$code = $opt = $pref_name = $multiple = $class = $dopol = $class_required = '';
		$arr_cc = $arr_cc2 = array();
		if($in['flag']=='offer_edit'){
			$arr_cc = ($in['id2'])? explode(',',$in['id2']) : array();
			$arr_cc2 = ($in['id'])? explode(',',$in['id']) : array();
		}else{
			$arr_cc = ($in['id'])? explode(',',$in['id']) : array();
		}

		$class 		= 'select2';
		$opt_empty 	= '<option value="">-</option>';
		if($in['multiple']){// множественный выбор
			$pref_name	= '[]';
			$multiple		= 'multiple="multiple"';
			$opt_empty	= '';
		}
		if($in['new']){// добавление нового атрибута
			$class	= 'save_users_attribute_value';
		}
		if($in['required']){// обязательно для заполнения
			$dopol 			= 'data-bv-notempty-message="Выберите" required ';
			$class_required	= 'require-input';
			
		}
		$r = reqAttributeValue(array('flag'=>'buy_sell','categories_id'=>$in['categories_id'],'attribute_id'=>$in['attribute_id']));
		
		foreach($r as $k=>$m){
			if($in['flag']=='offer'||$in['flag']=='offer_edit'){// когда предложение (выбираем только из параметров заявки)
				if( !empty($arr_cc) ){
					if(in_array($m['id'], $arr_cc)){
						$selected = ($in['status']==10)? '' : 'selected';
						$opt .= '<option value="'.$m['id'].'" '.$selected.'>'.$m['attribute_value'].'</option>';
					}
				}else{
					$selected = (in_array($m['id'], $arr_cc2))? ' selected' : '';
					$opt .= '<option value="'.$m['id'].'" '.$selected.'>'.$m['attribute_value'].'</option>';
				}
			}else{
				$sel = (in_array($m['id'], $arr_cc))? ' selected' : '';
				$opt .= '<option value="'.$m['id'].'" '.$sel.'>'.$m['attribute_value'].'</option>';				
			}
		}
		$code = '
				<select name="elem_'.$in['attribute_id'].$pref_name.'" '.$multiple.' class="form-control '.$class.' '.$class_required.'" '.$dopol.' data-placeholder="'.$in['attribute'].'"
																							data-categories_id="'.$in['categories_id'].'" data-attribute_id="'.$in['attribute_id'].'">
						'.$opt_empty.'
						'.$opt.'
				</select>
				';		//id="elem'.$in['attribute_id'].'" 
		
		return $code;
	}


	// Кнопки Подписаться/Отписаться
	function ButtonSubscriptions( $p=array() ){
		$in = fieldIn($p, array('flag','company_id_out','flag_etp'));
		
			if(!$in['flag']){
				$class_action = (COMPANY_ID)? 'action_subscriptions' : 'action_subscriptions_no_autorize';
				if(COMPANY_ID&&$in['flag_etp']){
					$class_action = 'modal_amo_accounts_etp';
				}
				$code = self::Input(array(	'type'			=> 'button',
											'class'			=> 'subs-btn btn '.$class_action.'',
											'value'			=> 'Подписаться',
											'data'			=> array('id'=>$in['company_id_out'])
										)
								);
			}else{
				$code = self::Input(array(	'type'			=> 'button',
											'class'			=> 'subs-btn btn change-btn action_subscriptions',
											'value'			=> 'Отписаться',
											'data'			=> array('id'=>$in['company_id_out'])
										)
								);				
			}
			
		return $code;
	}
	

	// Оповещение - параметр выбора пользователя
	function SelectNotificationParam( $p=array() ){
		$code = $opt = '';
		
		foreach($p['row'] as $k=>$m){
			if($p['flag']==1&&$m['id']==2){
				//
			}else{
				$sel = ($m['id']==$p['id'])? ' selected' : '';
				$opt .= '<option value="'.$m['id'].'" '.$sel.'>'.$m['notification_param'].'</option>';
			}
		}
		$code = '
				<select id="" name="" class="form-control save_notification" data-notification_id="'.$p['notification_id'].'" data-flag="'.$p['flag'].'">
							'.$opt.'
				</select>
				';
		
		return $code;
	}	
	
	
	// Выпадающий список - Категории (Интересы)
	function HtmlInterestsSelect2( $p=array() ){
		//$in = fieldIn($p, array('id'));
		$code = $opt = '';
		//$arr_cc = ($p['id'])? explode(',',$p['id']) : '';
		$arr_cc = $p['arr_cc'];
		
		foreach($p['row'] as $k=>$m){
			$sel = (in_array($m['id'], $arr_cc))? ' selected' : '';
			$opt .= '<option value="'.$m['id'].'" '.$sel.'>'.$m[ $p['pole'] ].'</option>';

		}
		//<option value="15598" selected="selected">Уфа</option>
		$code = '
				<select name="" multiple="multiple" class="form-control interests-input select2 '.$p['class'].'" 
																						data-flag="'.$p['flag'].'" 
																						data-interests_id="'.$p['interests_id'].'" 
																						data-interests_param_id="'.$p['interests_param_id'].'" 
																						data-interests_id="'.$p['interests_id'].'" 
																						data-where="'.$p['where'].'"
																						data-login_id="'.$p['login_id'].'">
						'.$opt.'
				</select>
				';
		
		return $code;
	}
	
	
	// Выпадающий список - Единиц Измерений (фасовка) у Категории + ШТУКИ
	function SelectUnitGropByCategories( $p=array() ){
		$in = fieldIn($p, array('unit_group_id','unit_id1'));
		$code = $opt = '';
		$r = reqSlovUnit(array('unit_group_id'=>$in['unit_group_id']));
		
		foreach($r as $k=>$m){
			$sel = ($m['id']==$in['unit_id1'])? 'selected' : '';
			$opt .= '<option value="'.$m['id'].'" '.$sel.'>'.$m['unit'].'</option>';

		}
		
		$sel = ($in['unit_id1']==1)? 'selected' : '';
		
		$code = '
				<select id="unit_id1" name="unit_id1" class="form-control interests-input select2" required data-unit_group_id="'.$in['unit_group_id'].'" data-bv-notempty-message=" Выберите ед.изм.">
						<option value="">ед.изм.</option>
						<option value="1" '.$sel.'>шт.</option>
						'.$opt.'
				</select>
				';
		
		return $code;
	}


	// Выпадающий список - Привязать компанию 1С к "нашей" 
	function Select1cCompanyCompany( $p=array() ){
		
		$in = fieldIn($p, array('1c_company_id','company_id_to'));

		$code =	self::Select(	array(	'id'		=> 'company_company_id_1c',
										'class'		=> 'form-control select2',
										'value'		=> $in['1c_company_id'],
										'data'		=> array('placeholder'=>'1С','company_id'=>$in['company_id_to'])
									),
								array(	'func'		=> 'req1cCompany',
										'param'		=> array('flag' => 'bind' , 'id'=>$in['company_id_to']),
										'opt'		=> array('id'=>'','name'=>'1C', 'dopol'=>'selected disabled'),
										'option'	=> array('id'=>'id','name'=>'name')
									)
							);
		
		return $code;
	}

	// Выпадающий список - Пользователи (Организация чата)
	function HtmlUsersSelectComp( $p=array() ){
		$in = fieldIn($p, array('ids,company_id'));
		$code = $opt = $sel = '';
		

        $arr_cc = '';
		//$arr_cc = ($p['id'])? explode(',',$p['ids']) : '';
		if(!empty($p['ids'])){
			$arr_cc = $p['ids'];
		}


		$p['pole'] 	= 'company';
		$p['where']	= 'company';
		$row_company = reqCompany();

		foreach( $row_company as $k=>$m){
			if(!empty($p['ids'])){
				$sel = (in_array($m['id'], $arr_cc))? ' selected' : '';

			}
			$opt .= '<option value="'.$m['id'].'" '.$sel.'>'.$m[ $p['pole'] ].'</option>';

		}
		$code = '
				<select name="" data-placeholder="Пользователь" multiple="multiple" class="form-control users-input select2 company" 
																						
																						data-company_id="'.$p['company_id'].'" 																																										 
																						data-where="'.$p['where'].'">
						'.$opt.'
				</select>
				';
		
		return $code;
	}

	
	// Выпадающий список - Потребности (Организация чата)
	function HtmlUsersSelectNeed( $p=array() ){

		$in = fieldIn($p, array('ids,company_id'));
		$code = $opt = $sel = '';
		
		$row_menu = reqMenu(array('need'=>1));		//
		//var_dump($row_menu);		

		if(!empty($p['ids'])){
			$arr_cc = $p['ids'];
		}	
		
		foreach($row_menu as $k=>$m){
			if(!empty($p['ids'])){
				$sel = (in_array($m['id'], $arr_cc))? ' selected' : '';
			}
			$opt .= '<option value="'.$m['id'].'" '.$sel.'>'.$m['menu'].'</option>';

		}
		$code = '
				<select name="" data-placeholder="Ссылка на потребность" multiple="multiple" class="form-control _users-input select2 potrb">
						'.$opt.'
				</select>
				';
		
		return $code;
	}
	
	// Выпадающий список - Поиск выбор страницы поиска
	function SelectFlagSearchWherePage( $p=array() ){

		$in = fieldIn($p, array('id'));
		$code = $opt = $sel = '';
				
		$row = array(2=>'Мои заявки',1=>'Мои объявления',4=>'Заявки',3=>'Объявления',5=>'Пользователи');

		$i = 0;
		foreach($row as $k=>$m){
			$sel = ($in['id']==$k)? ' selected' : '';
			$opt .= '<option value="'.$k.'" '.$sel.'>'.$m.'</option>';

		}
		$code = '
				<select id="select_flag_search_where_page" class="form-control _users-input select2">
						'.$opt.'
				</select>
				';
		
		return $code;
	}
		
	
	// Выпадающий список - Поиск выбор страницы поиска
	function SelectGroupSearchBuySell( $p=array() ){

		$in = fieldIn($p, array('id'));
		$code = $opt = $sel = '';
				
		$row = array(0=>'Нет','group_assets'=>'По активу','group_responsible'=>'По ответственному','group_comments_company'=>'По имени заказа');

		foreach($row as $k=>$m){
			$sel = ($in['id']==$k)? ' selected' : '';
			$opt .= '<option value="'.$k.'" '.$sel.'>'.$m.'</option>';

		}
		$code = '
				<select id="select_group_search_buy_sell" class="form-control _users-input select2">
						'.$opt.'
				</select>
				';
		
		return $code;
	}
	
	
	// Выпадающий список - Поиск сортировка
	function SelectSortSearchBuySell( $p=array() ){

		$in = fieldIn($p, array('id'));
		$code = $opt = $sel = '';
				
		$row = array('sort_date'=>'По дате','sort_categories'=>'По категории','sort_name'=>'По наименованию');

		foreach($row as $k=>$m){
			$sel = ($in['id']==$k)? ' selected' : '';
			$opt .= '<option value="'.$k.'" '.$sel.'>'.$m.'</option>';
		}
		$code = '
				<select id="select_sort_search_buy_sell" class="form-control _users-input select2">
						'.$opt.'
				</select>
				';
		
		return $code;
	}
	
	
	// Кнопка включить/отключить функции пакета Vip
	function ButtonEnterCancelVip( $p=array() ){

		$in = fieldIn($p, array('id','active'));
	
		$code = '';
	
		if($in['active']==1){
			$class_action 	= 'cancel';
			$value			= 'Отменить';
			if($in['id']==1){
				$code = '<span class="modal_service_bind1c">настроить</span>';
			}
		}else{
			$class_action 	= 'enter';
			$value			= 'Входит в пакет Vip';
		}
		
		
		$code = self::Input(array(	'type'			=> 'button',
									'class'			=> 'profile-btn request-btn action_enter_cancel_vip '.$class_action.'',
									'value'			=> $value,
									'data'			=> array('id'=>$in['id'],'active'=>$in['active'])
								)
						).$code;

		
		return $code;
	}
		
	
	// Выпадающий список - Vendorid компании из slov_qrq
	function SelectSlovQrqVendorid( $p=array() ){

		$in = fieldIn($p, array('company_id','qrq_id'));
		$code = $opt = $sel = '';
				
		$row = reqSlovQrq(array('company_id'=>$in['company_id']));

		foreach($row as $k=>$m){
			$sel = ($in['qrq_id']==$m['id'])? ' selected' : '';
			$opt .= '<option value="'.$m['id'].'" '.$sel.'>'.$m['qrq'].'</option>';
		}
		$code = '
				<select id="qrq_id" class="form-control _users-input select2" data-placeholder="Выберите ЭТП" data-company_id="'.$in['company_id'].'">
						<option value="0">-</option>
						'.$opt.'
				</select>
				';
		
		return $code;
	}
	
	
	// Выбор Города ЕТП
	function SelectAmoCities( $p=array() ){
		$code = $opt = '';
		$r = reqAmoCities();
		foreach($r as $k=>$m){
			$sel = ($m['id']==$p['amo_cities_id'])? ' selected' : '';
			$opt .= '<option value="'.$m['id'].'" '.$sel.'>'.$m['title'].'</option>';
		}
		
		$code = '
				<select id="" name="amo_cities_id" class="form-control select2" data-placeholder="Город ЕТП">
						'.$opt.'
				</select>
				';
		
		return $code;
	}
	
	
	
	

}

?>