<?php
	//выбираем класс
	function reqRoute($route=false) {
		$sql = "	SELECT class FROM route WHERE route=? ";
		$row = PreExecSQL_one($sql,array($route));

		return $row['class'];
	}


	//Дочерние / Родительские узлы от выбранного
	function reqUpDownTree($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$p['flag'] 		= ($p['flag']=='true')? 	'true' : 'false';//вызываем списком или GROUP_CONCAT
		$p['vkl'] 		= ($p['vkl']=='true')? 	'true' : 'false';//включать в список переданную рубрику

		if($p['flag']=='true'){
			$one = true;
		}
		if($p['updown']=='up'){
			$stored_proc = 'UpIdTree';
		}elseif($p['updown']=='down'){
			$stored_proc = 'DownIdTree';
		}

		$sql = "	CALL ".$stored_proc."('".$p['table']."','id','parent_id',".$p['id'].",".$p['flag'].",".$p['vkl']."); ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}



	//Меню пользователя
	function reqMenu($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','flag','href','need'));
		$parent_id 	= (isset($p['parent_id']))? 	$p['parent_id'] 		: '';
		if(($parent_id)||($parent_id===0)){
			$sql	= 'and parent_id=?';
			$arr	= array($parent_id);
		}
		if($in['id']){
			$sql	= ' and m.id=?';
			$arr = array($in['id']);
			$one = true;
		}
		if($in['href']){
			$sql	= ' and href=?';
			$arr = array($in['href']);
			$one = true;
		}
		if($in['flag']){
			$sql .= ' and flag=?';
			array_push($arr , $in['flag']);
		}
		if($in['need']){
			$sql .= ' and m.need=?';
			array_push($arr , $in['need']);
		}
		$sql = "	
					SELECT DISTINCT m.sort, m.id, m.parent_id, m.flag, m.href, m.menu, m.title, m.icon, m.need,
							(SELECT COUNT(t.id) FROM menu t WHERE t.parent_id=m.id) submenu
					FROM menu m, menu_prava mp, login_company_prava lp
					WHERE mp.menu_id=m.id AND lp.prava_id=mp.prava_id AND m.active=1
							AND lp.company_id=".COMPANY_ID."
							AND lp.login_id=".LOGIN_ID." ".$sql."
					ORDER BY 1 ";
	//vecho($sql);
		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Права Меню пользователя
	function reqMenuPrava($p=array()) {
		$sql = ' AND 1=2 ';
		$arr = array();
		$one = true;
		$in = fieldIn($p, array('href'));
		if($in['href']){
			$sql	= ' and m.href=?';
			$arr = array($in['href']);
		}

		$sql = "	SELECT pm.id 
					FROM menu m, prava_menu pm
					WHERE m.id=pm.menu_id AND login_id=".LOGIN_ID." ".$sql." ";

		$row = PreExecSQL_one($sql,$arr);

		return $row;
	}


	//Логин, пароль (Учетная запись)
	function reqLogin($p=array()) {
		$sql = '';
		$arr = array();
		$in = fieldIn($p, array('id','email','pass','active_md5','not_id','login_id_md5'));
		if($in['id']){
			$sql	= ' and id=?';
			$arr = array($in['id']);
		}
		if($in['email']){
			$sql .= ' and email=?';
			$arr = array($in['email']);
		}
		if($in['pass']){
			$sql .= ' and pass=?';
			array_push($arr , $in['pass']);
		}
		if($in['active_md5']){
			$sql .= " and MD5(CONCAT('".MD5."',email,data_insert))=? ";
			array_push($arr , $in['active_md5']);
		}
		if($in['login_id_md5']){
			$sql .= " and MD5(CONCAT('".MD5."',id))=? ";
			array_push($arr , $in['login_id_md5']);
		}

		if($in['not_id']){
			$sql	.= ' and id<>?';
			array_push($arr , $in['not_id']);
		}


		if(!$sql){
			$sql = 'and 1=2';
		}

		$sql = "	SELECT id, email, pass, active, MD5(CONCAT('".MD5."',email,data_insert)) active_md5 
					FROM login
					WHERE 1=1 ".$sql."
					LIMIT 1 ";

		$row = PreExecSQL_one($sql,$arr);

		return $row;
	}

	// Insert - Права и Роль пользователя на компанию
	function reqInsertLoginCompanyPrava($p=array()) {

		$p['position'] = (isset($p['position']))? $p['position'] : '';

		$STH = PreExecSQL(" INSERT INTO login_company_prava (login_id,company_id,prava_id,position) VALUES (?,?,?,?); " ,
			array( $p['login_id'],$p['company_id'],$p['prava_id'],$p['position'] ));
		if($STH){
			$ok = true;
		}

		return array('STH'=>$STH);
	}

	// Права / Роли
	function reqLoginCompanyPrava($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','login_id','company_id','one'));

		if($in['id']){
			$sql = 'AND lp.id=?';
			$arr = array($in['id']);
			$one = true;
		}
		if($in['login_id']){
			$sql .= ' AND lp.login_id=? ';
			array_push($arr , $in['login_id']);
		}
		if($in['company_id']){
			$sql .= ' AND lp.company_id=? ';
			array_push($arr , $in['company_id']);
		}

		if($in['one']){
			$one = true;
		}

		$sql = "	SELECT lp.id, lp.login_id, lp.company_id, lp.prava_id, lp.position,
							c.flag_account, c.pro_mode
					FROM company c, login_company_prava lp
					WHERE lp.company_id=c.id ".$sql."
					";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Права / Роли
	function reqLoginCompanyPravaByNotification($p=array()) {
		$sql = '';
		$in = fieldIn($p, array('flag_sam'));
		$arr = array();

		if($in['flag_sam']){
			$sql .= " AND lp.login_id<>".LOGIN_ID." ";
		}


		$sql = "	SELECT lp.login_id, lp.company_id, l.email, c.company,
							(SELECT t.company FROM company t WHERE t.flag_account=1 AND t.login_id=c.login_id) name_account
					FROM company c, login l, login_company_prava lp
					WHERE lp.login_id=l.id AND lp.company_id=c.id AND lp.company_id=".$p['company_id']." ".$sql."
					";

		$row = PreExecSQL_all($sql,array());

		return $row;
	}


	// Словарь Пользователи системы
	function reqSlovPrava($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('flag'));
		/*if($in['id_in']){
				$sql = "AND sp.id IN (".$in['id_in'].")";
			}*/
		if($in['flag']){
			$sql .= ' AND sp.flag=? ';
			array_push($arr , $in['flag']);
		}

		$sql = "	SELECT sp.id, sp.flag, sp.nprava
					FROM slov_prava sp
					WHERE 1=1 ".$sql." ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Словарь Категории
	function reqSlovCategories($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','active','level','ids'));
		$parent_id 	= (isset($p['parent_id']))? 	$p['parent_id'] : '';
		if(($parent_id)||($parent_id===0)){
			//$sql	= 'and parent_id=?';
			//$arr	= array($parent_id);
			$sql .= ' AND sc.parent_id IN ('.$parent_id.') ';
		}
		if($in['id']){
			$sql = 'AND sc.id=?';
			$arr = array($in['id']);
			$one = true;
		}
		if($in['level']){
			$sql .= ' AND sc.level=? ';
			array_push($arr , $in['level']);
		}
		if($in['active']){
			$sql .= ' AND sc.active=? ';
			array_push($arr , $in['active']);
		}
		if($in['ids']){
			$sql .= ' AND sc.id IN ('.$in['ids'].') ';
		}


		$sql = "	SELECT sc.id, sc.parent_id, sc.categories, sc.url_categories, sc.unit_id, sc.unit_group_id, 
							sc.level, sc.active, sc.sort,
							sc.limit_sell, sc.limit_buy, 
							sc.desc_sell, sc.desc_buy, sc.keywords_buy, sc.keywords_sell, sc.description_buy, sc.description_sell,
							sc.no_empty_name, sc.no_empty_file, sc.assets,
							su.unit,
							CASE WHEN sc.level=0 THEN sc.categories
								WHEN sc.level=1 THEN CONCAT('-',sc.categories)
								WHEN sc.level=2 THEN CONCAT('--',sc.categories) 
								WHEN sc.level=3 THEN CONCAT('---',sc.categories) END lcategories
					FROM slov_categories sc, slov_unit su
					WHERE sc.unit_id=su.id ".$sql."
					ORDER BY sc.sort , sc.categories ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Словарь Атрибуты (признаки у номенклатуры)
	function reqSlovAttribute($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','flag','categories_id'));
		if($in['id']){
			$sql = 'AND sa.id=?';
			$arr = array($in['id']);
			$one = true;
		}
		if($in['flag']=='not_attribute_id'){
			$sql = ' AND NOT sa.id IN ( SELECT t.attribute_id FROM categories_attribute t WHERE t.categories_id=? ) ';
			$arr = array($in['categories_id']);
		}

		$sql = "	SELECT sa.id, sa.attribute, sa.active, sa.sort
					FROM slov_attribute sa
					WHERE 1=1 ".$sql."
					ORDER BY sa.sort ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Словарь Тип Атрибута
	function reqSlovTypeAttribute($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id'));
		if($in['id']){
			$sql = 'AND ta.id=?';
			$arr = array($in['id']);
			$one = true;
		}

		$sql = "	SELECT ta.id, ta.type_attribute, ta.flag_value
					FROM slov_type_attribute ta
					WHERE 1=1 ".$sql." ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Словарь Тип Атрибута
	function reqSlovAttributeValue($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','attribute_id','flag_insert'));
		if($in['id']){
			$sql = 'AND sav.id=?';
			$arr = array($in['id']);
			$one = true;
		}
		if($in['attribute_id']){
			$sql .= ' AND sav.attribute_id=? ';
			array_push($arr , $in['attribute_id']);
		}
		if($in['flag_insert']){
			$sql .= ' AND sav.flag_insert=? ';
			array_push($arr , $in['flag_insert']);
		}

		$sql = "	SELECT sav.id, sav.attribute_id, sav.attribute_value, sav.sort, sav.flag_insert
					FROM slov_attribute_value sav  
					WHERE 1=1 ".$sql." ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Словарь Тип Атрибута
	function reqSlovAttributeValueByAdmin($p=array()) {
		$sql = '';

		$sql = "	SELECT sav.id, sav.attribute_id, sav.attribute_value, sav.flag_insert,
							sa.attribute
					FROM slov_attribute_value sav, slov_attribute sa
					WHERE sav.attribute_id=sa.id AND sav.flag_insert<>1
					ORDER BY sa.attribute, sav.attribute_value ";

		$row = PreExecSQL_all($sql,array());

		return $row;
	}

	// Словарь Юридическое лицо (Правовая форма)
	function reqSlovLegalEntity($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id'));
		if($in['id']){
			$sql = 'AND sle.id=?';
			$arr = array($in['id']);
			$one = true;
		}

		$sql = "	SELECT sle.id, sle.legal_entity
					FROM slov_legal_entity sle
					WHERE 1=1 ".$sql." ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Словарь Система налогообложения
	function reqSlovTaxSystem($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id'));
		if($in['id']){
			$sql = 'AND sts.id=?';
			$arr = array($in['id']);
			$one = true;
		}

		$sql = "	SELECT sts.id, sts.tax_system
					FROM slov_tax_system sts
					WHERE 1=1 ".$sql." ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Словарь Форма оплаты
	function reqSlovFormPayment($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id'));
		if($in['id']){
			$sql = 'AND sfp.id=?';
			$arr = array($in['id']);
			$one = true;
		}

		$sql = "	SELECT sfp.id, sfp.form_payment, sfp.coefficient2, sfp.coefficient3, sfp.coefficient4,
							cfp.coefficient
					FROM slov_form_payment sfp
					LEFT JOIN company_form_payment cfp ON cfp.company_id=".COMPANY_ID." AND cfp.form_payment_id=sfp.id
					WHERE 1=1 ".$sql."
						";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}


	// Словарь Срочность
	function reqSlovUrgency($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id'));
		if($in['id']){
			$sql = 'AND su.id=?';
			$arr = array($in['id']);
			$one = true;
		}

		$sql = "	SELECT su.id, su.urgency
					FROM slov_urgency su
					WHERE 1=1 ".$sql." ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Словарь Доставка
	function reqSlovDelivery($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id'));
		if($in['id']){
			$sql = 'AND sd.id=?';
			$arr = array($in['id']);
			$one = true;
		}

		$sql = "	SELECT sd.id, sd.delivery
					FROM slov_delivery sd
					WHERE 1=1 ".$sql." ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Словарь Единица Измерения
	function reqSlovUnit($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','unit_group_id'));
		if($in['id']){
			$sql = 'AND su.id=?';
			$arr = array($in['id']);
			$one = true;
		}
		if($in['unit_group_id']){
			$sql .= ' AND su.unit_group_id=? ';
			array_push($arr , $in['unit_group_id']);
		}
		if($in['unit_group_id']){
			$sql .= ' AND su.unit_group_id=? ';
			array_push($arr , $in['unit_group_id']);
		}


		$sql = "	SELECT su.id, su.unit, su.unit_group_id, su.okei
					FROM slov_unit su
					WHERE 1=1 ".$sql."
					ORDER BY su.sort  ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Словарь Группы Единиц Измерения
	function reqSlovUnitGroup($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id'));
		if($in['id']){
			$sql = 'AND sug.id=?';
			$arr = array($in['id']);
			$one = true;
		}

		$sql = "	SELECT sug.id, sug.unit_group
					FROM slov_unit_group sug
					WHERE 1=1 ".$sql." ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Словарь Группы Единиц Измерения Формула приведения
	function reqSlovUnitFormula($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','unit_id','unit_id1'));
		if($in['id']){
			$sql = 'AND suf.id=?';
			$arr = array($in['id']);
			$one = true;
		}
		if($in['unit_id']&&$in['unit_id1']){
			$sql = " AND suf.unit_id=".$in['unit_id']." AND suf.unit_id1=".$in['unit_id1']." ";
			$one = true;
		}

		$sql = "	SELECT suf.id, suf.unit_id, suf.unit_id1, suf.formula
					FROM slov_unit_formula suf
					WHERE 1=1 ".$sql." ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}


	// Словарь Валюта
	function reqSlovCurrency($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id'));
		if($in['id']){
			$sql = 'AND su.id=?';
			$arr = array($in['id']);
			$one = true;
		}

		$sql = "	SELECT sc.id, sc.currency
					FROM slov_currency sc
					WHERE 1=1 ".$sql." ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}



	// Словарь Срочность
	function reqSlovStatusBuySell($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id'));
		if($in['id']){
			$sql = 'AND sbs.id=?';
			$arr = array($in['id']);
			$one = true;
		}

		$sql = "	SELECT sbs.id, sbs.status_buy, sbs.status_sell
					FROM slov_status_buy_sell sbs
					WHERE 1=1 ".$sql." ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// значения за определенным Атрибутом из словаря
	function reqAttributeValue($p=array()) {
		$sql = '';
		$sql_select = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','flag','categories_id','attribute_id'));
		if($in['id']){
			$sql = 'AND av.id=?';
			$arr = array($in['id']);
			$one = true;
		}

		if($in['flag']=='buy_sell'){
			$sql = 'AND av.categories_id=? AND av.attribute_id=?';
			$arr = array($in['categories_id'],$in['attribute_id']);
		}

		$sql = "	SELECT av.id, av.categories_id, av.attribute_id, av.attribute_value_id, 
							sav.attribute_value
					FROM attribute_value av, slov_attribute_value sav
					WHERE av.attribute_value_id=sav.id ".$sql."
							AND (sav.company_id=0 OR sav.company_id=".COMPANY_ID.") ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// значения за определенным Атрибутом из словаря (выбранные ранее)
	function reqAttributeValueBySelect($p=array()) {

		$in = fieldIn($p, array('id','flag','categories_id','attribute_id'));


		if($in['flag']=='buy_sell'){
			$sql = 'AND av.categories_id=? AND av.attribute_id=?';
			$arr = array($in['categories_id'],$in['attribute_id']);
		}

		$sql = "	SELECT av.attribute_value_id
					FROM attribute_value av, slov_attribute_value sav
					WHERE av.attribute_value_id=sav.id 
							AND av.categories_id=? AND av.attribute_id=? ";

		$row = PreExecSQL_all($sql,array($in['categories_id'],$in['attribute_id']));

		return $row;
	}


	// Связь Категорий и Атрибутов (полей)
	function reqCategoriesAttribute($p=array()) {
		$sql = '';
		$sql_select = " ca.id, ca.categories_id, ca.attribute_id, 
								ca.buy_type_attribute_id, ca.sell_type_attribute_id, 
								ca.no_empty_buy, ca.no_empty_sell, ca.sort, ca.grouping_sell,ca.assets,
								sa.attribute,
								sta_buy.flag_value buy_flag_value, sta_sell.flag_value sell_flag_value,
								'' attribute_value_id_parent, '' attribute_value_id ";
		$arr = array();
		$one = false;

		$in = fieldIn($p, array('id','one','flag','categories_id','attribute_id','buy_sell_id','flag_not_empty','parent_id',
			'nomenclature_id','search_categories_id','flag_buy_sell'));

		$sql_assets = " AND ca.assets=0 ";// по умолчанию
		if($in['flag_buy_sell']==4){
			$sql_assets = '';
		}



		if($in['id']){
			$sql = 'AND ca.id=?';
			$arr = array($in['id']);
			$one = true;
		}

		if($in['flag']=='group_attribute_id'){
			$sql_select = " GROUP_CONCAT(CONCAT(ca.attribute_id,'*',ca.id,'*',ca.sort)) attribute_id ";
			$sql = 'AND ca.categories_id=?';
			$arr = array($in['categories_id']);
			$one = true;
		}
		if($in['categories_id']){
			$sql .= ' AND ca.categories_id=? ';
			array_push($arr , $in['categories_id']);
		}
		if($in['attribute_id']){
			$sql .= ' AND ca.attribute_id=? ';
			array_push($arr , $in['attribute_id']);
		}
		if($in['buy_sell_id']){// в заявке
			if($in['parent_id']){
				$sql_select .= " ,
								(
								SELECT CASE WHEN bsa.attribute_value_id<>0 THEN GROUP_CONCAT(bsa.attribute_value_id) ELSE GROUP_CONCAT(bsa.value) END attribute_value_id
								FROM buy_sell_attribute bsa
								WHERE bsa.buy_sell_id=".$in['parent_id']." AND bsa.attribute_id=ca.attribute_id
								GROUP BY bsa.buy_sell_id, bsa.attribute_id
								) attribute_value_id_parent ";
			}
			$sql_select .= " 
							,
								(
								SELECT CASE WHEN bsa.attribute_value_id<>0 THEN GROUP_CONCAT(bsa.attribute_value_id) ELSE GROUP_CONCAT(bsa.value) END attribute_value_id
								FROM buy_sell_attribute bsa
								WHERE bsa.buy_sell_id=".$in['buy_sell_id']." AND bsa.attribute_id=ca.attribute_id
								GROUP BY bsa.buy_sell_id, bsa.attribute_id
								) attribute_value_id ";
		}
		if($in['nomenclature_id']){// в номенклатуре
			$sql_select .= " 
							,
								(
								SELECT CASE WHEN na.attribute_value_id<>0 THEN GROUP_CONCAT(na.attribute_value_id) ELSE GROUP_CONCAT(na.value) END attribute_value_id
								FROM nomenclature_attribute na
								WHERE na.nomenclature_id=".$in['nomenclature_id']." AND na.attribute_id=ca.attribute_id
								GROUP BY na.nomenclature_id, na.attribute_id
								) attribute_value_id ";
		}
		if($in['search_categories_id']){// в админка Поисковый запрос
			$sql_select .= " 
							,
								(
								SELECT CASE WHEN sa.attribute_value_id<>0 THEN GROUP_CONCAT(sa.attribute_value_id) ELSE GROUP_CONCAT(sa.value) END attribute_value_id
								FROM search_categories_attribute sa
								WHERE sa.search_categories_id=".$in['search_categories_id']." AND sa.attribute_id=ca.attribute_id
								GROUP BY sa.search_categories_id, sa.attribute_id
								) attribute_value_id ";
		}

		if($in['flag_not_empty']=='buy_type_attribute_id'){
			$sql .= ' AND ca.buy_type_attribute_id<>0 ';
		}

		if($in['one']){
			$one = true;
		}

		if($in['flag']=='save'){
			$sql_assets = "" ;
		}

		$sql = "	SELECT ".$sql_select."
					FROM slov_attribute sa, categories_attribute ca
					LEFT JOIN slov_type_attribute sta_buy ON sta_buy.id=ca.buy_type_attribute_id
					LEFT JOIN slov_type_attribute sta_sell ON sta_sell.id=ca.sell_type_attribute_id
					WHERE ca.attribute_id=sa.id 
							".$sql."
							".$sql_assets."
					ORDER BY ca.sort ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}


	// следующий номер по порядку
	function reqProverkaEmptyCategoriesAttributeBuySell($p=array()){

