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



		$sql = "	SELECT * FROM (
						SELECT (
									SELECT CASE WHEN bsa.attribute_value_id<>0 THEN GROUP_CONCAT(bsa.attribute_value_id) ELSE GROUP_CONCAT(bsa.value) END attribute_value_id
									FROM buy_sell_attribute bsa
									WHERE bsa.buy_sell_id=? AND bsa.attribute_id=ca.attribute_id
									GROUP BY bsa.buy_sell_id, bsa.attribute_id
									) attribute_value_id,
								sa.attribute
						FROM slov_attribute sa, categories_attribute ca
						LEFT JOIN slov_type_attribute sta_buy ON sta_buy.id=ca.buy_type_attribute_id
						LEFT JOIN slov_type_attribute sta_sell ON sta_sell.id=ca.sell_type_attribute_id
						WHERE ca.attribute_id=sa.id 
								AND ca.categories_id=?
								AND CASE WHEN (SELECT t.flag_buy_sell FROM buy_sell t WHERE id=?)=2 THEN ca.no_empty_buy=1 ELSE ca.no_empty_sell=1 END
						ORDER BY ca.sort
					) qw
					WHERE qw.attribute_value_id IS null ";

		$row = PreExecSQL_all($sql,array($p['buy_sell_id'],$p['categories_id'],$p['buy_sell_id']));

		return $row;
	}


	// следующий номер по порядку
	function reqCategoriesAttributeNextSort($p=array()){

		$sql = "	SELECT MAX(ca.sort) sort FROM categories_attribute ca
					WHERE ca.categories_id=? ";

		$row = PreExecSQL_one($sql,array($p['categories_id']));

		return $row;
	}

	// Последний добавленный атрибут при -> Связь Категорий и Атрибутов (полей)
	function reqCategoriesLastInsertAttribute($p=array()) {

		$sql = "	SELECT qw1.buy_type_attribute_id, qw2.sell_type_attribute_id
					FROM 	(
							SELECT ca.buy_type_attribute_id
							FROM categories_attribute ca
							WHERE ca.buy_type_attribute_id<>0 AND ca.attribute_id='".$p['attribute_id']."'
							ORDER BY data_insert DESC LIMIT 1
						) qw1,
						(
							SELECT ca.sell_type_attribute_id
							FROM categories_attribute ca
							WHERE ca.sell_type_attribute_id<>0 AND ca.attribute_id='".$p['attribute_id']."'
							ORDER BY data_insert DESC LIMIT 1
						) qw2
				";

		$row = PreExecSQL_one($sql,array());

		return $row;
	}

	// Г О Р О Д А (НАСЕЛЕННЫЙ ПУНКТ)
	function reqCities($p=array()){
		$sql = $sql_limit = '';
		$in = fieldIn($p, array('id','name','value','flag'));
		$arr = array();
		$one = false;
		if($in['id']){
			$sql = 'and c.id=?';
			$arr = array($in['id']);
			$one = true;
		}elseif($in['name']){
			$sql = 'and c.name=?';
			$arr = array($in['name']);
			$one = true;
		}

		if($in['value']){//часть наименования
			$sql .= " and LOWER(c.name) LIKE ?";
			array_push($arr , $in['value'].'%');
			$sql_limit = 'LIMIT 10';
		}

		if($in['flag']=='interests'&&$p['company_id']&&$p['interests_id']&&$p['interests_param_id']){//интересы в профиле
			$sql .= " and c.id IN (	SELECT t.tid
										FROM interests_company_param t
										WHERE t.company_id=".$p['company_id']." AND t.interests_id=".$p['interests_id']." AND t.interests_param_id=".$p['interests_param_id']." ) ";
		}


		$sql = "	SELECT c.id, c.name, c.ru_path, c.url_cities
					FROM a_cities c
					WHERE c.ru_type='г' ".$sql."
					GROUP BY c.name
					ORDER BY c.name ".$sql_limit." ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// мои Компании
	function reqCompany($p=array()) {
		$sql = $sql_fa = $sql_inner_join = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','login_id','phone','one','not_login_id','who1','who2','not_id',
			'kol','flag','ipage','count_page','flag_account','value','company_id_md5','id_1c', 'skip'));

		//$flag_account 	= (isset($p['flag_account']))? 	$p['flag_account'] 		: '';
		//if(($flag_account)||($flag_account===0)){
		if($in['flag_account']){
			$sql_fa	= ' and c.flag_account IN ('.$in['flag_account'].') ';
		}else{
			$sql_fa = ' and c.flag_account IN (1,2) ';
		}
		if($in['id']){
			$sql_fa = '';
			$sql .= ' AND c.id=? ';
			array_push($arr , $in['id']);
			$one = true;
		}
		if($in['login_id']){
			$sql .= ' AND c.login_id=? ';
			array_push($arr , $in['login_id']);
		}
		if($in['phone']){
			$sql .= ' AND c.phone=? ';
			array_push($arr , $in['phone']);
		}
		if($in['not_login_id']){
			$sql .= ' AND c.login_id<>? ';
			array_push($arr , $in['not_login_id']);
		}
		if($in['who1']){// Продавцы
			$sql .= ' AND c.who1=1 ';
		}
		if($in['who2']){// Покупатели
			$sql .= ' AND c.who2=1 ';
		}
		if($in['flag']=='subscriptions-my'){// Подписки
			$sql_inner_join = " INNER JOIN subscriptions sub ON sub.company_id_out=c.id AND sub.company_id_in='".COMPANY_ID."' ";
		}
		if($in['flag']=='subscriptions-me'){// Подписчики
			$sql_inner_join = " INNER JOIN subscriptions sub ON sub.company_id_in=c.id AND sub.company_id_out='".COMPANY_ID."' ";
		}
		if($in['value']){//часть наименования
			$sql .= " and LOWER(CONCAT(sle.legal_entity,' ',c.company)) LIKE ?";
			array_push($arr , '%'.$in['value'].'%');
		}
		if($in['company_id_md5']){// company_id md5
			$sql .= " and MD5(CONCAT('".MD5."',c.id))=? ";
			array_push($arr , $in['company_id_md5']);
			$one = true;
		}
		if($in['id_1c']){//
			$sql .= " AND c.id_1c=? ";
			array_push($arr , $in['id_1c']);
			$one = true;
		}
		if($in['not_id']){//
			$sql .= " AND c.id<>? ";
			array_push($arr , $in['not_id']);
			$one = true;
		}

		if($in['one']){
			$one = true;
		}




		$sql_select = " 	c.id, c.login_id, c.flag_account, c.legal_entity_id, c.company, c.email, c.iti_phone, c.phone, c.cities_id,
							c.position, c.tax_system_id, c.who1, c.who2, c.pro_mode, c.id_1c, c.comments, c.active, c.skip skipReg,
							CASE WHEN c.avatar IS NULL OR c.avatar='' THEN 
														CASE WHEN c.flag_account=1 THEN '/image/profile-icon.png' ELSE '/image/profile-logo.png' END 
																	ELSE c.avatar END avatar,
							sle.legal_entity, sts.tax_system,
							ac.name cities_name,
							(SELECT email FROM login l WHERE l.id=c.login_id) email_login,
							(SELECT t.id FROM subscriptions t WHERE t.company_id_in='".COMPANY_ID."' AND t.company_id_out=c.id) flag_subscriptions,
							( SELECT t.tid FROM notification t WHERE t.tid=c.id AND t.login_id=".LOGIN_ID." AND t.company_id=".COMPANY_ID." ) kol_notification /* оповещение конкретное по ID (маркировка) */
							";

		$sql_ = "	SELECT {SQL_SELECT}
						FROM slov_legal_entity sle, slov_tax_system sts, a_cities ac, company c
						".$sql_inner_join."
						WHERE c.legal_entity_id=sle.id AND c.tax_system_id=sts.id AND c.cities_id=ac.id
								".$sql_fa." ".$sql."
					";

		$sql_order = (($in['ipage']||$in['ipage']==0)&&$in['count_page'])? " ORDER BY c.data_insert DESC LIMIT ".$in['ipage'].",".$in['count_page']." "
			: " ";

		if($in['kol']==true){
			$sql_select = " COUNT(c.id) kol ";
			$sql = str_replace('{SQL_SELECT}',$sql_select,$sql_);
			$one = true;

		}else{
			$sql = str_replace('{SQL_SELECT}',$sql_select,$sql_);
			$sql = $sql.$sql_order;
		}



		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// мои Компании автокомплит
	function reqCompanyLastSession($p=array()) {

		$in = fieldIn($p, array('login_id'));

		$sql = " SELECT cls.company_id
					FROM company_last_session cls
					WHERE cls.login_id=? ";

		$row = PreExecSQL_one($sql,array($in['login_id']));

		return $row;
	}

	// мои Компании автокомплит
	function reqCompanyAutocomplete($p=array()) {
		$arr = array();
		$in = fieldIn($p, array('value'));

		$sql = " and LOWER(CONCAT(sle.legal_entity,' ',c.company)) LIKE ?";
		array_push($arr , '%'.$in['value'].'%');


		$sql = " SELECT c.id, c.flag_account, c.company, c.email, sle.legal_entity
					FROM slov_legal_entity sle, company c
					WHERE c.active=1 AND c.legal_entity_id=sle.id ".$sql." 
							AND (c.id IN ( 	SELECT t.company_id_out 
											FROM subscriptions t 
											WHERE t.company_id_in=".COMPANY_ID." ) 
								OR c.id IN ( 	SELECT t.company_id_in 
									FROM subscriptions t 
									WHERE t.company_id_out=".COMPANY_ID." ) 
								OR c.id IN ( 	SELECT t.id 
												FROM company t 
												WHERE t.login_id=".LOGIN_ID." AND t.flag_account=3 ) 
								)
					ORDER BY c.company ";



		$row = PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Категории за Компанией
	function reqCompanyCategories($p=array()) {
		$sql = '';
		$sql_select = 'cc.id, cc.company_id, cc.categories_id';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('flag','company_id'));
		if($in['flag']=='group_categories_id'){
			$sql_select = " GROUP_CONCAT(CONCAT(cc.categories_id)) categories_id ";
			$sql = 'AND cc.company_id=?';
			$arr = array($in['company_id']);
			$one = true;
		}
		if($in['flag']=='group_categories'){
			$sql_select = " GROUP_CONCAT(sc.categories ORDER BY sc.sort SEPARATOR ', ') categories ";
			$sql = 'AND cc.company_id=?';
			$arr = array($in['company_id']);
			$one = true;
		}

		$sql = "	SELECT ".$sql_select."
					FROM company_categories cc, slov_categories sc
					WHERE cc.categories_id=sc.id  ".$sql." ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}


	// Админка - мои Компании
	function reqCompanyAdmin($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('login_id','flag_account'));
		//$flag_account 	= (isset($p['flag_account']))? 	$p['flag_account'] 		: '';
		//if(($flag_account)||($flag_account===0)){
		if($in['flag_account']){
			$sql	= 'and c.flag_account=?';
			$arr	= array($in['flag_account']);
		}

		if($in['login_id']){
			$sql .= ' AND c.login_id=? ';
			array_push($arr , $in['login_id']);
		}


		$sql = "	SELECT c.id, c.login_id, c.flag_account, c.company, c.who1, c.who2, c.pro_mode, c.active, c.email, c.phone, c.avatar,
							c.data_insert, DATE_FORMAT(c.data_insert,'%d-%m-%Y') dmy_data_insert,
							(SELECT COUNT(t.id) FROM company t WHERE t.login_id=c.login_id AND t.flag_account=2) count_company
					FROM company c
					WHERE 1=1 ".$sql." ";

		$row = PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Левое меню компании
	function reqCompanyMenuLeft($p=array()) {

		$sql = "	SELECT c.id, c.company, sle.legal_entity
					FROM slov_legal_entity sle, company c, login_company_prava lcp
					WHERE lcp.company_id=c.id AND lcp.login_id=".LOGIN_ID."
						AND c.legal_entity_id=sle.id
					ORDER BY c.flag_account, c.company ";

		$row = PreExecSQL_all($sql,array());

		return $row;
	}


	// вывод данных о подписчиках
	function reqCompanySubscriptions($p=array()) {
		$sql = $sql_fa = $sql_inner_join = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('who1','who2','flag','categories_id','cities_id','value'));

		$start_limit 	= (isset($p['start_limit'])&&v_int($p['start_limit']))? 	$p['start_limit'] : 0;

		if($in['who1']){// Продавцы
			$sql .= ' AND c.who1=1 ';
		}
		if($in['who2']){// Покупатели
			$sql .= ' AND c.who2=1 ';
		}
		if($in['flag']=='subscriptions-my'){// Подписки
			$sql_inner_join = " INNER JOIN subscriptions sub ON sub.company_id_out=c.id AND sub.company_id_in='".COMPANY_ID."' ";
		}
		if($in['flag']=='subscriptions-me'){// Подписчики
			$sql_inner_join = " INNER JOIN subscriptions sub ON sub.company_id_in=c.id AND sub.company_id_out='".COMPANY_ID."' ";
		}


		// поиск
		if($in['categories_id']){
			$sql .= ' AND c.id IN (	SELECT cc.company_id
												FROM company_categories cc
												WHERE cc.categories_id=? ) ';
			array_push($arr , $in['categories_id']);
		}
		if($in['cities_id']){
			$sql .= ' AND c.cities_id=? ';
			array_push($arr , $in['cities_id']);
		}
		if($in['value']){
			$sql .= " AND LOWER(c.company) LIKE ?";
			array_push($arr , '%'.$in['value'].'%');
		}
		///



		$sql = "	SELECT c.id, c.company, c.flag_account,
							CASE WHEN c.avatar IS NULL OR c.avatar='' THEN 
													CASE WHEN c.flag_account=1 THEN '/image/profile-icon.png' ELSE '/image/profile-logo.png' END 
																	ELSE c.avatar END avatar,
							sle.legal_entity,
							ac.name cities_name,
							(SELECT t.id FROM subscriptions t WHERE t.company_id_in='".COMPANY_ID."' AND t.company_id_out=c.id) flag_subscriptions,
							(SELECT t2.id FROM subscriptions t2 WHERE t2.company_id_out='".COMPANY_ID."' AND t2.company_id_in=c.id) flag_subscriptions2,
							( SELECT t.tid FROM notification t WHERE t.tid=c.id AND t.login_id=".LOGIN_ID." AND t.company_id=".COMPANY_ID." ) kol_notification, /* оповещение конкретное по ID (маркировка) */
							(SELECT cq.id FROM company_qrq cq WHERE cq.company_id=c.id) flag_etp
							
						FROM slov_legal_entity sle, a_cities ac, company c
						".$sql_inner_join."
						WHERE c.legal_entity_id=sle.id AND c.cities_id=ac.id
								AND c.active=1
								AND c.flag_account IN (1,2)
								".$sql_fa." ".$sql."
						ORDER BY flag_subscriptions DESC, flag_subscriptions2 DESC, c.flag_account DESC,  c.data_insert DESC LIMIT ".$start_limit." , 25
					";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Insert - Заявка/Объявление
	function reqInsertBuySell($in=array()) {
		$in['name'] 				= (isset($in['name']))? 				$in['name'] 				: '-';
		$in['parent_id'] 		= (isset($in['parent_id']))? 		$in['parent_id'] 		: 0;
		$in['copy_id'] 			= (isset($in['copy_id']))? 			$in['copy_id'] 			: 0;
		$in['login_id'] 			= (isset($in['login_id']))? 			$in['login_id'] 			: LOGIN_ID;
		$in['company_id'] 		= (isset($in['company_id']))? 		$in['company_id'] 		: COMPANY_ID;
		$in['company_id2'] 		= (isset($in['company_id2']))? 		$in['company_id2'] 		: 0;
		$in['form_payment_id'] 	= (isset($in['form_payment_id']))? 	$in['form_payment_id'] 	: 0;
		$in['qrq_id'] 			= (isset($in['qrq_id']))? 			$in['qrq_id'] 			: 0;
		$in['item_id'] 			= (isset($in['item_id']))? 			$in['item_id'] 			: 0;
		$in['nomenclature_id'] 	= (isset($in['nomenclature_id']))? 	$in['nomenclature_id'] 	: 0;
		$in['responsible_id'] 	= (isset($in['responsible_id']))? 	$in['responsible_id'] 	: 0;
		$in['multiplicity'] 		= (isset($in['multiplicity']))? 		$in['multiplicity'] 		: '';
		$in['min_party'] 		= (isset($in['min_party']))? 		$in['min_party'] 		: '';
		$in['delivery_id'] 		= (isset($in['delivery_id']))? 		$in['delivery_id'] 		: 0;
		$in['amount1'] 			= (isset($in['amount1']))? 			$in['amount1'] 			: 0;
		$in['unit_id1'] 			= (isset($in['unit_id1']))? 			$in['unit_id1'] 			: 0;
		$in['amount2'] 			= (isset($in['amount2']))? 			$in['amount2'] 			: 0;
		$in['unit_id2'] 			= (isset($in['unit_id2']))? 			$in['unit_id2'] 			: 0;
		$in['cost1'] 			= (isset($in['cost1']))? 			$in['cost1'] 			: 0;
		$in['amount_buy'] 		= (isset($in['amount_buy']))? 		$in['amount_buy'] 		: 0;
		$in['stock_id'] 			= (isset($in['stock_id']))? 			$in['stock_id'] 			: 0;
		$in['assets_id'] 		= (isset($in['assets_id']))? 		$in['assets_id'] 		: 0;
		$in['company_id3'] 		= (isset($in['company_id3']))? 		$in['company_id3'] 		: 0;

		$in['availability'] = preg_replace("/[^0-9]/", '', $in['availability']);


		$sql = " SELECT IFNULL(MAX(id)+1,1) next_id FROM buy_sell ";
		$row = PreExecSQL_one($sql,array());
		$tmp_buy_sell_id 			= $row['next_id'];

		$url = $in['url'].'_'.$tmp_buy_sell_id;

		$flag_cron_new_buysell = false;
		$sql_data = $sql_q = '';
		if( ($in['status']==2||$in['status']==3) ){// Опубликовываем||Активная, фиксируем дату при первой опубл или активации
			$sql_data 	= ' , data_status_buy_sell_23 ';
			$sql_q 		= ' , NOW() ';
			$flag_cron_new_buysell = ($in['qrq_id']>0)? false : true;// не отправлять предложениям от Этп
		}elseif($in['status']==10){// Предложение
			$sql_data 	= ' , data_status_buy_sell_10 ';
			$sql_q 		= ' , NOW() ';
		}


		$STH = PreExecSQL(" INSERT INTO buy_sell (id, parent_id, copy_id, login_id, company_id, company_id2, flag_buy_sell, status_buy_sell_id, name, url, cities_id, categories_id, urgency_id, cost, cost1, currency_id, amount, amount1,unit_id1,amount2,unit_id2, amount_buy, form_payment_id, comments, comments_company, responsible_id, availability, qrq_id, item_id, nomenclature_id, multiplicity, min_party, delivery_id, stock_id, assets_id, company_id3 ".$sql_data." ) VALUES (?,?,?,?,?,?,?,?, ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,? ".$sql_q." ); " ,
			array( $tmp_buy_sell_id,$in['parent_id'],$in['copy_id'],$in['login_id'],$in['company_id'],$in['company_id2'],$in['flag_buy_sell'],$in['status'],$in['name'],$url,$in['cities_id'],$in['categories_id'],$in['urgency_id'],$in['cost'],$in['cost1'],$in['currency_id'],$in['amount'],$in['amount1'],$in['unit_id1'],$in['amount2'],$in['unit_id2'],$in['amount_buy'],$in['form_payment_id'],$in['comments'],$in['comments_company'],$in['responsible_id'],$in['availability'],$in['qrq_id'],$in['item_id'],$in['nomenclature_id'],$in['multiplicity'],$in['min_party'],$in['delivery_id'],$in['stock_id'],$in['assets_id'],$in['company_id3'] ));
		if($STH){
			$buy_sell_id = $tmp_buy_sell_id;
			$ok = true;
			if( $flag_cron_new_buysell ){// Добавляем - Id новой завки , чтобы через крон по ней отправить оповещение
				reqInsertСronNewBuysell(array('buy_sell_id'=>$buy_sell_id));
			}
		}


		return array('STH'=>$STH,'buy_sell_id'=>$buy_sell_id);
	}


	// Delete - Сторонии предложения из Заявки
	function reqDeleteBuySellByQrqId($in=array()) {


		$STH = false;

		if(v_int($in['buy_sell_id'])){

			$STH = PreExecSQL(" DELETE FROM buy_sell WHERE status_buy_sell_id=10 AND parent_id=? AND qrq_id<>0
														AND NOT id IN (SELECT * FROM (SELECT t.parent_id FROM buy_sell t WHERE t.parent_id=parent_id) AS q)  ; " ,
				array( $in['buy_sell_id'] ));
			if($STH){
				$ok = true;
			}
		}


		return array('STH'=>$STH);
	}


	// Заявка/Объявление
	function reqBuySell($p=array()) {
		$sql = $sql_offer = $sql_select = $sql_inner_join = '';
		$sql_order = ' bs.data_insert DESC ';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','company_id','company_id2','flag_buy_sell','status_buy_sell_id','active',
			'flag','sbs_flag','order','url','status_offer_id','one','flag_interests','share_url',
			'categories_id','cities_id','value','flag_search' ));
		$parent_id 	= (isset($p['parent_id']))? 	$p['parent_id'] : '';
		if(($parent_id)||($parent_id===0)){
			$sql	= 'and bs.parent_id=?';
			$arr	= array($parent_id);
		}
		if($in['id']){
			$sql .= ' AND bs.id=? ';
			array_push($arr , $in['id']);
			$one = true;
		}
		if($in['company_id']){
			$sql .= ' AND bs.company_id=? ';
			array_push($arr , $in['company_id']);
		}
		if($in['flag_buy_sell']){
			$sql .= ' AND bs.flag_buy_sell=? ';
			array_push($arr , $in['flag_buy_sell']);
		}
		if($in['status_buy_sell_id']){
			$sql .= ' AND bs.status_buy_sell_id=? ';
			array_push($arr , $in['status_buy_sell_id']);
		}
		if($in['active']){
			$sql .= ' AND bs.active=? ';
			array_push($arr , $in['active']);
		}
		if($in['flag']=='page_buy'||$in['flag']=='page_sell'){
			$sql .= (!$in['share_url'])? " AND (	bs.status_buy_sell_id IN (3)
														OR ( bs.status_buy_sell_id IN (2) AND bs.company_id IN ( SELECT t.company_id_out FROM subscriptions t WHERE t.company_id_in=".COMPANY_ID." ) ) 
													) "
				: "";
			$sql_select = " , CASE WHEN bs.company_id<>".COMPANY_ID." AND bs.data_status_buy_sell_23>(	SELECT pvs.data_visited 
																										FROM company_page_visited_send pvs 
																										WHERE pvs.page_id=1 AND pvs.login_id=".LOGIN_ID." AND pvs.company_id=".COMPANY_ID." ) THEN 1 ELSE 0 END flag_new ";
			$sql_order = ' bs.data_status_buy_sell_23 DESC ';
		}
		if($in['sbs_flag']){
			$sql .= ' AND sbs.flag=? ';
			array_push($arr , $in['sbs_flag']);
		}
		if($in['url']){
			$sql .= ' AND bs.url=? ';
			array_push($arr , $in['url']);
			$one = true;
		}
		if($in['flag']=='flag_my_sell'){
			$sql .= " AND ( (bs.flag_buy_sell=1 AND bs.company_id=".COMPANY_ID.")
								OR CASE WHEN bs.company_id2=".COMPANY_ID." AND bs.company_id2>0 THEN bs.flag_buy_sell IN (1,2) 
																								ELSE bs.company_id2=".COMPANY_ID." AND bs.flag_buy_sell IN (1) END
							) ";
		}
		/*
			if($in['flag_interests']){
				$g		= new HtmlServive();
				$sql .= $g->SqlCompanyInterests(array('company_id'=>COMPANY_ID));
			}
			*/
		if($in['share_url']){
			$sql .= ' AND bs.id IN ( SELECT bss_ids.buy_sell_id
										FROM buy_sell_share bss, buy_sell_share_ids bss_ids
										WHERE bss_ids.buy_sell_share_id=bss.id AND bss.share_url=? ) ';
			array_push($arr , $in['share_url']);
		}


		if($in['order']=='min_cost'){
			//$sql_order = ' CASE WHEN cost_coefficient<bs.cost THEN cost_coefficient ELSE bs.cost END  ';
			$sql_order = ' cost_coefficient  ';
		}

		if($in['flag']=='shleyf_one'){
			$sql_order = ' bs.data_insert LIMIT 1  ';
			$one = true;
		}

		if($in['flag']=='last_buy'){
			$sql = ' AND bs.flag_buy_sell=2 AND bs.status_buy_sell_id IN (1,2,3) ';
			$sql_order = ' bs.data_insert DESC LIMIT 1  ';
			$one = true;
		}



		// поиск
		if($in['categories_id']){
			$sql .= ' AND bs.categories_id=? ';
			array_push($arr , $in['categories_id']);
		}
		if($in['cities_id']){
			$sql .= ' AND bs.cities_id=? ';
			array_push($arr , $in['cities_id']);
		}
		if($in['flag_search']==22){// по наименованию категории
			if($in['value']){
				$sql .= " and LOWER(sc.categories) LIKE ?";
				array_push($arr , '%'.$in['value'].'%');
			}
		}elseif($in['flag_search']==23){// по типу
			if($in['value']){
				$sql .= " AND bs.id IN ( SELECT bsa.buy_sell_id
															FROM attribute_value av, slov_attribute_value sav, buy_sell_attribute bsa
															WHERE bsa.attribute_value_id=av.id 
																AND av.attribute_id=23 AND av.attribute_value_id=sav.id
																AND LOWER(sav.attribute_value) LIKE ? ) ";
				array_push($arr , '%'.$in['value'].'%');
			}
		}else{// по наименованию/артикулу
			if($in['value']){
				$sql .= " and ( LOWER(bs.name) LIKE ? OR bs.id IN ( 	SELECT bsa.buy_sell_id
																						FROM buy_sell_attribute bsa
																						WHERE  bsa.attribute_id=33 
																								AND LOWER(bsa.value) LIKE ? ) ) ";
				array_push($arr , '%'.$in['value'].'%');
				array_push($arr , '%'.$in['value'].'%');
			}
		}
		///


		if($in['one']){
			$one = true;
		}

		$sql = "	SELECT 	bs.id, bs.parent_id, bs.copy_id, bs.login_id login_id_bs, bs.company_id, bs.company_id2, bs.flag_buy_sell, bs.name, bs.url, 
							bs.status_buy_sell_id, bs.cities_id,  
							CASE WHEN bs.availability=0 THEN '' ELSE bs.availability END availability ,
							bs.categories_id, bs.urgency_id, bs.cost, bs.cost1, bs.currency_id, bs.form_payment_id, 
							bs.multiplicity, bs.min_party, bs.delivery_id, bs.stock_id, bs.assets_id,
							bs.amount, bs.comments,
							bs.amount1,bs.unit_id1,bs.amount2,bs.unit_id2,
							bs.comments_company,
							bs.responsible_id, bs.nomenclature_id, bs.qrq_id , bs.item_id,
							bs.company_id3,
							bs.data_insert,
							su1.unit unit1, su2.unit unit2,
							(SELECT cr.company FROM company cr WHERE cr.id=bs.responsible_id) responsible,
							sfp.form_payment,
							cities.name cities_name, cities.url_cities, c.company, c.login_id,
							CASE WHEN c.avatar IS NULL OR c.avatar='' THEN 
														CASE WHEN c.flag_account=1 THEN '/image/profile-icon.png' ELSE '/image/profile-logo.png' END 
																	ELSE c.avatar END avatar,
							sc.categories, sc.url_categories, sc.unit_id, sc.unit_group_id, su.urgency, sbs.status_buy2, sbs.status_sell2, sunit.unit,
							DATE_FORMAT( bs.data_insert, '%d %M' ) ndata_insert,
							DATE_FORMAT( bs.data_status_buy_sell_23, '%d %M' ) data_status_buy_sell_23,
							(SELECT DATEDIFF(DATE_ADD(bs.data_status_buy_sell_23, INTERVAL 30 DAY), NOW())) day_noactive,
							DATE_FORMAT( bs.data_status_buy_sell_10, '%d %M' ) data_status_buy_sell_10,
							CASE WHEN bs.form_payment_id>0 THEN (SELECT t.coefficient FROM company_form_payment t 
																WHERE t.form_payment_id=bs.form_payment_id AND t.company_id=".COMPANY_ID.")*bs.cost 
														ELSE 0 END AS cost_coefficient,
							(SELECT t.id FROM buy_sell t 
								WHERE t.parent_id=bs.id AND t.company_id=".COMPANY_ID." LIMIT 1 ) flag_offer_company_id, /* есть предложение от текущей компании */
							(SELECT CONCAT(MIN(t.cost),'*',COUNT(t.id),'*',t.parent_id) FROM buy_sell t 
								WHERE (t.parent_id=bs.id OR t.parent_id=(SELECT t.parent_id FROM buy_sell t 
																	 WHERE t.id IN	(SELECT t.copy_id FROM buy_sell t 
																					 WHERE t.id=bs.id AND t.status_buy_sell_id IN (11,12))
																	)
										) AND t.status_buy_sell_id=10 LIMIT 1 ) flag_offer_min_cost, /* предложеная мин.цена и кол-во предложений */
							(SELECT COUNT(bs0.parent_id) FROM buy_sell bs0
								WHERE bs0.parent_id=bs.id  AND bs0.id IN (SELECT t.tid FROM notification t 
																	WHERE t.notification_id=2 AND t.login_id=".LOGIN_ID." AND t.company_id=".COMPANY_ID.") ) kol_notification_offer, /* оповещение количество предложений */
							( SELECT t.tid FROM notification t WHERE t.tid=bs.id AND t.login_id=".LOGIN_ID." AND t.company_id=".COMPANY_ID." LIMIT 1 ) kol_notification, /* оповещение конкретное по ID (маркировка) */
							(SELECT t.id FROM subscriptions t WHERE t.company_id_in=".COMPANY_ID." AND t.company_id_out=bs.company_id) flag_subscriptions_company_in, /* подписан на компанию чья заявка/объявление */ 
							(SELECT t.id FROM subscriptions t WHERE t.company_id_in=bs.company_id AND t.company_id_out=".COMPANY_ID.") flag_subscriptions_company_out, /* подписанным на компанию чья заявка/объявление */ 
							(SELECT SUM(t.amount) FROM buy_sell t WHERE t.parent_id=bs.id AND t.status_buy_sell_id=12) kol_status12 /* сколько исполнено для куплено */
							
							".$sql_select."
					FROM company c, a_cities cities, slov_categories sc, slov_urgency su, slov_status_buy_sell sbs, slov_unit sunit, buy_sell bs
					LEFT JOIN slov_form_payment sfp ON sfp.id=bs.form_payment_id
					LEFT JOIN slov_unit su1 ON su1.id=bs.unit_id1
					LEFT JOIN slov_unit su2 ON su2.id=bs.unit_id2
					
					".$sql_inner_join."
					WHERE bs.company_id=c.id AND cities.id=bs.cities_id AND bs.categories_id=sc.id 
							AND bs.urgency_id=su.id AND sbs.id=bs.status_buy_sell_id AND sc.unit_id=sunit.id 
							".$sql_offer."
							".$sql."
					ORDER BY ".$sql_order." ";
		/*
	if(!$in['id']){
	//vecho($sql.'*'.$in['company_id'].'*'.$in['flag_buy_sell'].'*'.$in['status_buy_sell_id'].'*'.$in['sbs_flag']);
	}
	*/
		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}
	/*
		// Используется в $f->FormBuySell ...
		function reqBuySell_FormBuySell($p=array()) {

			$sql = "	SELECT 	bs.id, bs.parent_id, bs.login_id login_id_bs, bs.flag_buy_sell, bs.status_buy_sell_id, bs.cities_id,
							bs.categories_id, bs.urgency_id, bs.delivery_id, bs.assets_id,
							bs.comments, bs.comments_company, bs.responsible_id, bs.currency_id, bs.stock_id, bs.name,
							CASE WHEN bs.availability=0 THEN '' ELSE bs.availability END availability ,
							sc.categories,
							(SELECT cr.company FROM company cr WHERE cr.id=bs.responsible_id) responsible,
							cities.name cities_name
					FROM a_cities cities, slov_categories sc, buy_sell bs
					WHERE cities.id=bs.cities_id AND bs.categories_id=sc.id
							AND bs.id=? ";

			$row = PreExecSQL_one($sql,array($p['id']));

			return $row;
		}
	*/

	// Используется в $t->TableOfferBuy ...
	function reqBuySell_TableOfferBuy($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;

		$in = fieldIn($p, array('id','company_id'));
		$parent_id 	= (isset($p['parent_id']))? 	$p['parent_id'] : '';

		if(($parent_id)||($parent_id===0)){
			$sql	= 'and bs.parent_id=?';
			$arr	= array($parent_id);
		}
		if($in['id']){
			$sql .= ' AND bs.id=? ';
			array_push($arr , $in['id']);
			$one = true;
		}
		if($in['company_id']){
			$sql .= ' AND bs.company_id=? ';
			array_push($arr , $in['company_id']);
		}

		$sql = "	SELECT 	bs.id, bs.company_id, bs.amount, bs.name, bs.comments, 
							sc.unit_group_id,
							bs.amount1, sunit.unit, su1.unit unit1,
							su.urgency,
							sbs.status_buy2
					FROM slov_categories sc, slov_unit sunit, slov_urgency su, slov_status_buy_sell sbs, buy_sell bs
					LEFT JOIN slov_unit su1 ON su1.id=bs.unit_id1
					WHERE bs.categories_id=sc.id AND sc.unit_id=sunit.id AND bs.urgency_id=su.id AND sbs.id=bs.status_buy_sell_id 
							".$sql."
					";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}


	// Используется в $f->FormBuyAmount ...
	function reqBuySell_FormBuyAmount($p=array()) {

		$sql = "	SELECT 	bs.id, bs.parent_id, bs.login_id login_id_bs, bs.company_id2, bs.flag_buy_sell, 
							bs.status_buy_sell_id, bs.cities_id, 
							bs.categories_id, bs.urgency_id, bs.delivery_id, bs.assets_id, bs.qrq_id,
							bs.comments, bs.comments_company, bs.responsible_id, bs.currency_id, bs.stock_id, bs.name,
							bs.cost, bs.cost1, 
							bs.min_party, bs.multiplicity, bs.form_payment_id,
							bs.nomenclature_id, bs.company_id3,
							
							CASE WHEN bs.availability=0 THEN '' ELSE bs.availability END availability ,
							sc.categories,
							(SELECT cr.company FROM company cr WHERE cr.id=bs.responsible_id) responsible,
							cities.name cities_name,
							
							bs.amount1, bs.unit_id1, bs.amount, bs.amount2, bs.unit_id2,
							su1.unit unit1,
							sunit.unit, 
							sc.unit_group_id, sc.unit_id,
							
							(SELECT t.id FROM subscriptions t WHERE t.company_id_in=".COMPANY_ID." AND t.company_id_out=bs.company_id) flag_subscriptions_company_in, /* подписан на компанию чья заявка/объявление */ 
							(SELECT t.id FROM subscriptions t WHERE t.company_id_in=bs.company_id AND t.company_id_out=".COMPANY_ID.") flag_subscriptions_company_out, /* подписанным на компанию чья заявка/объявление */ 
							
							(SELECT t.id FROM company_vip_function t WHERE t.company_id=bs.company_id AND vip_function_id IN (7,8) LIMIT 1 ) flag_vip_function_stock
							
					FROM a_cities cities, slov_categories sc, slov_unit sunit, buy_sell bs
					LEFT JOIN slov_unit su1 ON su1.id=bs.unit_id1
					WHERE cities.id=bs.cities_id AND bs.categories_id=sc.id AND sc.unit_id=sunit.id 
							AND bs.id=? ";

		$row = PreExecSQL_one($sql,array($p['id']));

		return $row;
	}

	// Используется в ajax.php->form_buy_sell ...
	function reqBuySell_ajax_form_buy_sell($p=array()) {

		$sql = "	SELECT 	bs.id, bs.status_buy_sell_id, bs.company_id,
							(SELECT t.id FROM subscriptions t WHERE t.company_id_in=".COMPANY_ID." AND t.company_id_out=bs.company_id) flag_subscriptions_company_in /* подписан на компанию чья заявка/объявление */ 
					FROM buy_sell bs
					WHERE bs.id=? ";

		$row = PreExecSQL_one($sql,array($p['id']));

		return $row;
	}


	// Используется в $bs->SaveBuyOffer ...
	function reqBuySell_SaveBuyOffer($p=array()) {

		$sql = "	SELECT 	bs.id, bs.parent_id, bs.company_id, bs.status_buy_sell_id, bs.flag_buy_sell, 
							bs.amount, bs.qrq_id, bs.item_id,
							bs.unit_id1, bs.unit_id2, bs.nomenclature_id, bs.categories_id,
							sc.unit_id, sunit.unit
					FROM slov_categories sc, slov_unit sunit, buy_sell bs
					WHERE bs.categories_id=sc.id AND sc.unit_id=sunit.id AND bs.id=? ";

		$row = PreExecSQL_one($sql,array($p['id']));

		return $row;
	}

	// Используется в $qrq->QrqInsertBuySell ...
	function reqBuySell_Amo($p=array()) {

		$sql = "	SELECT bs.id, bs.company_id, bs.name, bs.categories_id, bs.urgency_id, 
							bs.flag_buy_sell, bs.status_buy_sell_id, bs.nomenclature_id
					FROM buy_sell bs
					WHERE bs.id=? ";

		$row = PreExecSQL_one($sql,array($p['id']));

		return $row;
	}

	// Используется в ajax.php->save_buy_sell ...
	function reqBuySell_SaveBuySell($p=array()) {
		$sql = '';
		$arr = array();
		$sql_order = ' bs.data_insert DESC ';
		$in = fieldIn($p, array('id','flag','status_buy_sell_id'));
		$parent_id 	= (isset($p['parent_id']))? 	$p['parent_id'] : '';

		if(($parent_id)||($parent_id===0)){
			$sql	= 'and bs.parent_id=?';
			$arr	= array($parent_id);
		}
		if($in['id']){
			$sql .= ' AND bs.id=? ';
			array_push($arr , $in['id']);
		}
		if($in['status_buy_sell_id']){
			$sql .= ' AND bs.status_buy_sell_id=? ';
			array_push($arr , $in['status_buy_sell_id']);
		}
		if($in['flag']=='shleyf_one'){
			$sql_order = ' bs.data_insert LIMIT 1  ';
		}

		$sql = "	SELECT bs.id, bs.parent_id, bs.copy_id, bs.login_id login_id_bs, bs.flag_buy_sell, bs.status_buy_sell_id,
							bs.name, bs.currency_id, bs.categories_id, data_status_buy_sell_23, bs.data_insert,
							bs.cost, bs.cost1, bs.amount, bs.amount1, bs.unit_id2, bs.amount2, sc.unit_id, bs.unit_id1, 
							bs.company_id, bs.form_payment_id, bs.cities_id, bs.categories_id, bs.urgency_id, bs.company_id2,
							bs.availability, bs.multiplicity, bs.min_party, bs.comments, bs.comments_company,
							bs.nomenclature_id, bs.responsible_id, bs.stock_id, bs.assets_id, bs.company_id3,
							c.login_id,
							sc.unit_group_id
					FROM company c, slov_categories sc, buy_sell bs
					WHERE bs.company_id=c.id AND bs.categories_id=sc.id 
							".$sql."
					ORDER BY ".$sql_order." ";

		$row = PreExecSQL_one($sql,$arr);

		return $row;
	}


	// Используется в controllers/buysellone.php ...
	function reqBuySell_buysellone($p=array()) {
		$arr = array();
		$sql = '';
		$in = fieldIn($p, array('id','url','company_id'));
		$parent_id 	= (isset($p['parent_id']))? 	$p['parent_id'] : '';

		if(($parent_id)||($parent_id===0)){
			$sql	= 'and bs.parent_id=?';
			$arr	= array($parent_id);
		}
		if($in['id']){
			$sql .= ' AND bs.id=? ';
			array_push($arr , $in['id']);
		}
		if($in['company_id']){
			$sql .= ' AND bs.company_id=? ';
			array_push($arr , $in['company_id']);
		}
		if($in['url']){
			$sql .= ' AND bs.url=? ';
			array_push($arr , $in['url']);
			$one = true;
		}


		$sql = "	SELECT bs.id, bs.parent_id, bs.company_id, bs.company_id2, bs.name, bs.flag_buy_sell, bs.status_buy_sell_id,
							bs.categories_id, bs.comments, bs.amount, bs.cost,
							bs.url, bs.qrq_id,
							sc.url_categories, cities.url_cities,
							sunit.unit,
							cities.name cities_name, 
							c.company,
							(SELECT t.id FROM subscriptions t WHERE t.company_id_in=".COMPANY_ID." AND t.company_id_out=bs.company_id) flag_subscriptions_company_in /* подписан на компанию чья заявка/объявление */ 
					FROM company c, a_cities cities, slov_categories sc, slov_unit sunit, buy_sell bs
					WHERE cities.id=bs.cities_id AND bs.categories_id=sc.id AND sc.unit_id=sunit.id  
							".$sql." ";

		$row = PreExecSQL_one($sql,$arr);

		return $row;
	}


	// Используется в $api->Save1cBuy12 ...
	function reqBuySell1c_SavedBuy12($p=array()) {

		$sql = "	SELECT 	bs1.id
					FROM buy_sell_1c bs1
					WHERE bs1.flag=? AND bs1.id_1c=? ";

		$row = PreExecSQL_one($sql,array($p['flag'],$p['id_1c']));

		return $row;
	}
	/*
		// Используется в $api->Save1cBuy12 ...
		function reqBuySell1c($p=array()) {
			$sql = '';
			$arr = array();
			$one = false;
			$in = fieldIn($p, array('company_id','flag'));

			$company_id = isset($in['company_id'])? $in['company_id'] : COMPANY_ID;

			if($in['flag']=='data_1c'){
				$sql = " AND bs1.data_1c=(	SELECT MAX(t.data_1c)
											FROM buy_sell bs , buy_sell_1c t
											WHERE t.buy_sell_id=bs.id AND bs.company_id=".$company_id." ) ";
			}

			$sql = "	SELECT bs1.id, bs1.buy_sell_id, bs1.id_1c, bs1.data_1c
					FROM buy_sell bs , buy_sell_1c bs1
					WHERE bs1.buy_sell_id=bs.id AND bs.company_id=".$company_id." ".$sql." ";

			$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

			return $row;
		}
		*/
	// Используется в $api->saved1cBuy12 ...
	function reqBuySell1c_exportBuy12($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('company_id','flag'));

		$sql = "	SELECT bs1.id, bs1.buy_sell_id, bs1.id_1c, bs1.data_1c
					FROM buy_sell_1c bs1
					WHERE bs1.company_id=? AND bs1.flag=? AND bs1.buy_sell_id=0 
							AND bs1.data_1c=(	SELECT MAX(t.data_1c)
												FROM buy_sell_1c t
												WHERE t.company_id=? AND t.flag=? AND t.buy_sell_id=0  )  ";

		$row = PreExecSQL_all($sql,array($in['company_id'],$in['flag'],$in['company_id'],$in['flag']));

		return $row;
	}


	// МОИ ЗАЯВКИ страница
	function reqMyBuySell($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','company_id','flag_buy_sell','status_buy_sell_id','active','stock_id',
			'flag','sbs_flag',
			'categories_id','cities_id','value','nomenclature_id' ));

		$start_limit 	= (isset($p['start_limit'])&&v_int($p['start_limit']))? 	$p['start_limit'] : 0;


		if($in['id']){
			$sql .= ' AND bs.id=? ';
			array_push($arr , $in['id']);
			$one = true;
		}
		if($in['company_id']){
			$sql .= ' AND bs.company_id=? ';
			array_push($arr , $in['company_id']);
		}
		if($in['flag_buy_sell']){
			$sql .= ' AND bs.flag_buy_sell=? ';
			array_push($arr , $in['flag_buy_sell']);
		}
		if($in['status_buy_sell_id']){
			$sql .= ' AND bs.status_buy_sell_id=? ';
			array_push($arr , $in['status_buy_sell_id']);
		}
		if($in['active']){
			$sql .= ' AND bs.active=? ';
			array_push($arr , $in['active']);
		}
		if($in['stock_id']){
			$sql .= ' AND bs.stock_id=? ';
			array_push($arr , $in['stock_id']);
		}
		if($in['nomenclature_id']){
			$sql .= ' AND bs.nomenclature_id=? ';
			array_push($arr , $in['nomenclature_id']);
		}
		if($in['sbs_flag']){
			$sql .= ' AND sbs.flag=? ';
			array_push($arr , $in['sbs_flag']);
		}
		if($in['flag']=='flag_my_sell'){
			$sql .= " AND ( (bs.flag_buy_sell=1 AND bs.company_id=".COMPANY_ID.")
								OR CASE WHEN bs.company_id2=".COMPANY_ID." AND bs.company_id2>0 THEN bs.flag_buy_sell IN (1,2) 
																								ELSE bs.company_id2=".COMPANY_ID." AND bs.flag_buy_sell IN (1) END
							) ";
		}
		// поиск
		if($in['categories_id']){
			$sql .= ' AND bs.categories_id=? ';
			array_push($arr , $in['categories_id']);
		}
		if($in['cities_id']){
			$sql .= ' AND bs.cities_id=? ';
			array_push($arr , $in['cities_id']);
		}
		if($in['value']){
			$sql .= " and LOWER(bs.name) LIKE ?";
			array_push($arr , '%'.$in['value'].'%');
		}
		///



		$sql = "	SELECT 	bs.id, bs.parent_id, bs.copy_id, bs.login_id, bs.company_id, bs.company_id2, bs.flag_buy_sell, bs.name, bs.url, 
							bs.status_buy_sell_id, bs.urgency_id, bs.form_payment_id,
							bs.categories_id, bs.cost,bs.cost1, bs.currency_id, bs.amount,bs.amount_buy, 
							bs.amount1,bs.unit_id1,bs.amount2,bs.unit_id2,
							su1.unit unit1, su2.unit unit2,
							bs.comments, bs.comments_company,
							bs.responsible_id, bs.nomenclature_id, bs.stock_id,
							(SELECT cr.company FROM company cr WHERE cr.id=bs.responsible_id) responsible,
							CASE WHEN bs.availability=0 THEN '' ELSE bs.availability END availability ,
							sfp.form_payment,
							cities.name cities_name, cities.url_cities, c.company, c2.company company2,
							sc.categories, sc.url_categories, sc.unit_id, sc.unit_group_id, 
							su.urgency, sbs.status_buy2, sbs.status_sell2, sunit.unit, scurrency.currency,
							stock.stock, 1 kol_stock,
							DATE_FORMAT( bs.data_insert, '%d %M' ) ndata_insert,
							DATE_FORMAT( bs.data_status_buy_sell_23, '%d %M' ) data_status_buy_sell_23,
							(SELECT DATEDIFF(DATE_ADD(bs.data_status_buy_sell_23, INTERVAL 30 DAY), NOW())) day_noactive,
							'' ostatok
							
							/*
							(SELECT CONCAT(MIN(t.cost),'*',COUNT(t.id),'*',t.parent_id) FROM buy_sell t 
							WHERE t.parent_id=bs.id AND t.status_buy_sell_id=10 LIMIT 1 ) flag_offer_min_cost, /* предложеная мин.цена и кол-во предложений ОТ предложений */
							/*
							(SELECT CONCAT(MIN(t.cost),'*',COUNT(t.id),'*',t.parent_id) FROM buy_sell t 
							WHERE (t.parent_id=(SELECT t.parent_id FROM buy_sell t 
													 WHERE t.id IN	(SELECT t.copy_id FROM buy_sell t 
																	 WHERE t.id=bs.id AND t.status_buy_sell_id IN (11,12))
																	)
										) AND t.status_buy_sell_id=10 LIMIT 1 ) flag_offer_min_cost2, /* предложеная мин.цена и кол-во предложений ОТ купленных и исполненных */

							/*
							(SELECT COUNT(bs0.parent_id) FROM buy_sell bs0
								WHERE (
										bs0.parent_id=bs.id OR bs0.parent_id=( SELECT t.parent_id FROM buy_sell t WHERE t.id=(SELECT tt.copy_id FROM buy_sell tt WHERE tt.id=bs.id) )
										)  
										AND bs0.id IN (SELECT t.tid FROM notification t 
														WHERE t.notification_id=2 AND t.login_id=".LOGIN_ID." AND t.company_id=".COMPANY_ID.") ) kol_notification_offer, /* оповещение количество предложений */
							
							/*
							( SELECT t.tid FROM notification t WHERE t.tid=bs.id AND t.login_id=".LOGIN_ID." AND t.company_id=".COMPANY_ID." LIMIT 1 ) kol_notification, /* оповещение конкретное по ID (маркировка) */
							
							/*
							CASE WHEN bs.status_buy_sell_id=2 OR bs.status_buy_sell_id=3 THEN
									(
										SELECT SUM(t.amount) FROM buy_sell t WHERE t.parent_id IN (SELECT tt.id FROM buy_sell tt WHERE tt.parent_id=bs.id) AND t.status_buy_sell_id=11
									) ELSE '' END kol_status11,  /* количество купленного данного предложения */
							/*
							(SELECT SUM(t.amount) FROM buy_sell t WHERE t.parent_id=bs.id AND t.status_buy_sell_id=12) kol_status12, /* сколько исполнено для куплено */
							/*
							(SELECT COUNT(t.id) FROM buy_sell_files t WHERE t.buy_sell_id=bs.id) kol_photo,
							/*
							(SELECT vcb.kol FROM view_counter_buysellone vcb WHERE vcb.buy_sell_id=bs.id) kol_views /* кол-во просмотров */
							,
							(SELECT SUM(t.amount) FROM buy_sell t WHERE t.parent_id=bs.id AND t.flag_buy_sell=5) amount_reserve
					FROM company c, a_cities cities, slov_categories sc, slov_urgency su, slov_status_buy_sell sbs, slov_unit sunit, slov_currency scurrency, buy_sell bs
					LEFT JOIN slov_form_payment sfp ON sfp.id=bs.form_payment_id
					LEFT JOIN company c2 ON c2.id=bs.company_id2
					LEFT JOIN slov_unit su1 ON su1.id=bs.unit_id1
					LEFT JOIN slov_unit su2 ON su2.id=bs.unit_id2
					LEFT JOIN stock ON stock.id=bs.stock_id
					
					WHERE bs.company_id=c.id AND cities.id=bs.cities_id AND bs.categories_id=sc.id AND bs.urgency_id=su.id 
							AND sbs.id=bs.status_buy_sell_id AND sc.unit_id=sunit.id AND bs.currency_id=scurrency.id
							".$sql."
					ORDER BY CASE WHEN bs.data_status_buy_sell_23>bs.data_insert THEN bs.data_status_buy_sell_23 ELSE bs.data_insert END  DESC LIMIT ".$start_limit." , 10 ";
		/*
	if(!$in['id']){
	vecho($sql.'*'.$in['company_id'].'*'.$in['flag_buy_sell'].'*'.$in['status_buy_sell_id'].'*'.$in['sbs_flag']);
	exit;
	}
	*/

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}


	// МОИ ЗАЯВКИ страница  CACHE
	function reqMyBuySellCache($p=array()) {
		$sql = $sql_select = $sql_group = $sql_flag_buy_sell = $sql_categories_id = $sql_cities_id = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','company_id','flag_buy_sell','status_buy_sell_id','active',
			'flag','sbs_flag',
			'categories_id','cities_id','value','flag_interests_invite',
			'login_id_interests', 'company_id_interests' , 'group' , 'flag_group_id' , 'group_id' ));

		$start_limit 	= (isset($p['start_limit'])&&v_int($p['start_limit']))? 	$p['start_limit'] : 0;

		$sql_limit		= " LIMIT ".$start_limit." , 10 ";


		if($in['id']){
			$sql .= ' AND bs.id=? ';
			array_push($arr , $in['id']);
			$one = true;
		}
		if($in['company_id']){
			$sql_bs = " AND bs.company_id=".$in['company_id']." ";
			$sql .= ' AND bs.company_id=? ';
			array_push($arr , $in['company_id']);
		}
		if($in['flag_buy_sell']){
			$sql .= ' AND bs.flag_buy_sell=? ';
			$sql_flag_buy_sell = " AND bs.flag_buy_sell=".$in['flag_buy_sell']." ";
			array_push($arr , $in['flag_buy_sell']);
		}
		if($in['status_buy_sell_id']){
			$sql .= ' AND bs.status_buy_sell_id=? ';
			array_push($arr , $in['status_buy_sell_id']);
		}
		if($in['active']){
			$sql .= ' AND bs.active=? ';
			array_push($arr , $in['active']);
		}
		if($in['sbs_flag']){
			$sql .= ' AND sbs.flag=? ';
			array_push($arr , $in['sbs_flag']);
		}
		if($in['flag']=='flag_my_sell'){
			$sql .= $sql_bs = " AND ( (bs.flag_buy_sell=1 AND bs.company_id=".COMPANY_ID.")
													OR CASE WHEN bs.company_id2=".COMPANY_ID." AND bs.company_id2>0 THEN bs.flag_buy_sell IN (1,2) 
																													ELSE bs.company_id2=".COMPANY_ID." AND bs.flag_buy_sell IN (1) END
												) ";
		}
		// поиск
		if($in['categories_id']){
			$sql .= ' AND bs.categories_id=? ';
			$sql_categories_id = " AND bs.categories_id=".$in['categories_id']." ";
			array_push($arr , $in['categories_id']);
		}
		if($in['cities_id']){
			$sql .= ' AND bs.cities_id=? ';
			$sql_cities_id = " AND bs.cities_id=".$in['cities_id']." ";
			array_push($arr , $in['cities_id']);
		}
		if($in['value']){

			$sql_dop = '';
			$arr_sql_dop = array(11 => " 

													/*12 вложенность (наименование, имя заказа) копии в купленные*/
													SELECT bs.id, 
																CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END) attribute_value

														FROM buy_sell bs, slov_categories sc
														WHERE sc.active=1 AND bs.categories_id=sc.id
														".$sql_bs."
														AND bs.status_buy_sell_id IN (11)
														".$sql_flag_buy_sell."
														AND ( 		LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ? 
																OR 	LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ? 
																OR 	LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ?
															)
														
													UNION ALL
													
													SELECT bs3.id, ''
													FROM buy_sell bs3 
													WHERE 	bs3.company_id='".COMPANY_ID."'
															AND bs3.status_buy_sell_id IN (11) 
															AND bs3.flag_buy_sell='".$in['flag_buy_sell']."'	
															AND bs3.copy_id IN (
																				SELECT IFNULL(bs.id,0)
																				FROM buy_sell bs, slov_categories sc
																				WHERE sc.active=1 AND bs.categories_id=sc.id
																						AND bs.id IN (	SELECT IFNULL(bs2.copy_id,0)
																										FROM buy_sell bs2 
																										WHERE 	bs2.company_id='".COMPANY_ID."'
																												AND bs2.status_buy_sell_id IN (11) 
																												AND bs2.flag_buy_sell='".$in['flag_buy_sell']."'		
																									)
																									
																						".$sql_bs."
																						AND bs.status_buy_sell_id IN (6) 
																						".$sql_flag_buy_sell."
																						AND ( 		LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ? 
																									OR 	LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ? 
																									OR 	LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ?
																								)												
																			)
															
													UNION ALL
													/*12*/
						
													/*1 купленные*/
													SELECT bs.id,
															CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																ELSE avs.attribute_value END attribute_value
													FROM slov_attribute sa, categories_attribute ca, slov_categories sc, buy_sell bs , buy_sell_attribute bsa

													LEFT JOIN ( SELECT av.id, sav.attribute_value FROM attribute_value av, slov_attribute_value sav WHERE sav.id=av.attribute_value_id ) avs
																	ON avs.id=bsa.attribute_value_id

													WHERE bsa.buy_sell_id=bs.id AND ca.categories_id=bs.categories_id AND sa.id=ca.attribute_id
														AND bsa.attribute_id=ca.attribute_id AND (bsa.value<>'-' OR NOT avs.attribute_value IS NULL )
														AND sc.active=1 AND bs.categories_id=sc.id
														".$sql_bs."
														AND bs.status_buy_sell_id IN (11)
														".$sql_flag_buy_sell."
														AND ( 		LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																											ELSE avs.attribute_value END) LIKE ? 
																OR 	LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																											ELSE avs.attribute_value END) LIKE ? 
																OR LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																											ELSE avs.attribute_value END) LIKE ? )
													UNION ALL
													/*1*/
													
													/*2 вложенность копии в купленные*/
													SELECT bs3.id, ''
													FROM buy_sell bs3 
													WHERE 	bs3.company_id='".COMPANY_ID."'
															AND bs3.status_buy_sell_id IN (11) 
															AND bs3.flag_buy_sell='".$in['flag_buy_sell']."'	
															AND bs3.copy_id IN (
															
																				SELECT bs.id
																				FROM slov_attribute sa, categories_attribute ca, slov_categories sc, buy_sell bs , buy_sell_attribute bsa 

																				LEFT JOIN ( SELECT av.id, sav.attribute_value FROM attribute_value av, slov_attribute_value sav WHERE sav.id=av.attribute_value_id ) avs 
																				ON avs.id=bsa.attribute_value_id 

																				WHERE bsa.buy_sell_id=bs.id AND ca.categories_id=bs.categories_id AND sa.id=ca.attribute_id 
																						AND bsa.attribute_id=ca.attribute_id AND (bsa.value<>'-' OR NOT avs.attribute_value IS NULL ) 
																						AND sc.active=1 AND bs.categories_id=sc.id
																						AND bs.id IN (	SELECT IFNULL(bs2.copy_id,0)
																										FROM buy_sell bs2 
																										WHERE 	bs2.company_id='".COMPANY_ID."'
																												AND bs2.status_buy_sell_id IN (11) 
																												AND bs2.flag_buy_sell='".$in['flag_buy_sell']."'		
																									)
																									
																						".$sql_bs."
																						AND bs.status_buy_sell_id IN (6) 
																						".$sql_flag_buy_sell."
																						AND ( 		LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																																			ELSE avs.attribute_value END) LIKE ? 
																								OR 	LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																																			ELSE avs.attribute_value END) LIKE ? 
																								OR LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																																			ELSE avs.attribute_value END) LIKE ? )												
																			)
													

													UNION ALL
													/*2*/

													",
				12 => " 	
													/*123 вложенность (наименование, имя заказа) копии в исполненные*/
													SELECT bs.id,''
													FROM buy_sell bs, slov_categories sc
													WHERE sc.active=1 AND bs.categories_id=sc.id
														".$sql_bs."
														AND bs.status_buy_sell_id IN (12)
														".$sql_flag_buy_sell."
														AND ( 		LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ? 
																OR 	LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ? 
																OR 	LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ?
															)
													UNION ALL
													
													SELECT bs3.id, ''
													FROM buy_sell bs3 
													WHERE 	bs3.company_id='".COMPANY_ID."'
															AND bs3.status_buy_sell_id IN (12) 
															AND bs3.flag_buy_sell='".$in['flag_buy_sell']."'	
															AND bs3.parent_id IN (
																				SELECT IFNULL(bs.id,0)	
																				FROM buy_sell bs, slov_categories sc
																				WHERE sc.active=1 AND bs.categories_id=sc.id
																						AND bs.id IN (	SELECT IFNULL(bs2.parent_id,0)
																										FROM buy_sell bs2 
																										WHERE 	bs2.company_id='".COMPANY_ID."'
																												AND bs2.status_buy_sell_id IN (12) 
																												AND bs2.flag_buy_sell='".$in['flag_buy_sell']."'		
																									)
																									
																						".$sql_bs."
																						AND bs.status_buy_sell_id IN (11) 
																						".$sql_flag_buy_sell."
																						AND ( 		LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ? 
																								OR 	LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ? 
																								OR 	LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ?
																							)											
																			)
													

													UNION ALL
													
													SELECT bs3.id, ''
													FROM buy_sell bs3 
													WHERE 	bs3.company_id='".COMPANY_ID."'
															AND bs3.status_buy_sell_id IN (12) 
															AND bs3.flag_buy_sell='".$in['flag_buy_sell']."'	
															AND bs3.copy_id IN (
															
																				SELECT 	IFNULL(bs.id,0)
																				FROM buy_sell bs, slov_categories sc
																				WHERE sc.active=1 AND bs.categories_id=sc.id
																						AND bs.id IN (	SELECT IFNULL(bs2.copy_id,0)
																										FROM buy_sell bs2 
																										WHERE 	bs2.company_id='".COMPANY_ID."'
																												AND bs2.status_buy_sell_id IN (12) 
																												AND bs2.flag_buy_sell='".$in['flag_buy_sell']."'		
																									)
																									
																						".$sql_bs."
																						AND bs.status_buy_sell_id IN (6) 
																						".$sql_flag_buy_sell."
																						AND ( 		LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ? 
																								OR 	LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ? 
																								OR 	LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ?
																							)											
																			)
													

													UNION ALL
													/*123*/
											
													/*1 исполненные*/
													SELECT bs.id, ''
													FROM slov_attribute sa, categories_attribute ca, slov_categories sc, buy_sell bs , buy_sell_attribute bsa

													LEFT JOIN ( SELECT av.id, sav.attribute_value FROM attribute_value av, slov_attribute_value sav WHERE sav.id=av.attribute_value_id ) avs
																	ON avs.id=bsa.attribute_value_id

													WHERE bsa.buy_sell_id=bs.id AND ca.categories_id=bs.categories_id AND sa.id=ca.attribute_id
														AND bsa.attribute_id=ca.attribute_id AND (bsa.value<>'-' OR NOT avs.attribute_value IS NULL )
														AND sc.active=1 AND bs.categories_id=sc.id
														".$sql_bs."
														AND bs.status_buy_sell_id IN (12)
														".$sql_flag_buy_sell."
														AND ( 		LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																											ELSE avs.attribute_value END) LIKE ? 
																OR 	LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																											ELSE avs.attribute_value END) LIKE ? 
																OR LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																											ELSE avs.attribute_value END) LIKE ? )
													UNION ALL
													/*1*/
													
													/*2 вложенность купленных в исполненные*/
													SELECT bs3.id, ''
													FROM buy_sell bs3 
													WHERE 	bs3.company_id='".COMPANY_ID."'
															AND bs3.status_buy_sell_id IN (12) 
															AND bs3.flag_buy_sell='".$in['flag_buy_sell']."'	
															AND bs3.parent_id IN (
																				SELECT IFNULL(bs.id,0)	
																				FROM slov_attribute sa, categories_attribute ca, slov_categories sc, buy_sell bs , buy_sell_attribute bsa 

																				LEFT JOIN ( SELECT av.id, sav.attribute_value FROM attribute_value av, slov_attribute_value sav WHERE sav.id=av.attribute_value_id ) avs 
																				ON avs.id=bsa.attribute_value_id 

																				WHERE bsa.buy_sell_id=bs.id AND ca.categories_id=bs.categories_id AND sa.id=ca.attribute_id 
																						AND bsa.attribute_id=ca.attribute_id AND (bsa.value<>'-' OR NOT avs.attribute_value IS NULL ) 
																						AND sc.active=1 AND bs.categories_id=sc.id
																						AND bs.id IN (	SELECT IFNULL(bs2.parent_id,0)
																										FROM buy_sell bs2 
																										WHERE 	bs2.company_id='".COMPANY_ID."'
																												AND bs2.status_buy_sell_id IN (12) 
																												AND bs2.flag_buy_sell='".$in['flag_buy_sell']."'		
																									)
																									
																						".$sql_bs."
																						AND bs.status_buy_sell_id IN (11) 
																						".$sql_flag_buy_sell."
																						AND ( 		LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																																			ELSE avs.attribute_value END) LIKE ? 
																								OR 	LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																																			ELSE avs.attribute_value END) LIKE ? 
																								OR LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																																			ELSE avs.attribute_value END) LIKE ? )												
																			)
													

													UNION ALL
													/*2*/
													
													/*3 вложенность копии в исполненные*/
													SELECT bs3.id, ''
													FROM buy_sell bs3 
													WHERE 	bs3.company_id='".COMPANY_ID."'
															AND bs3.status_buy_sell_id IN (12) 
															AND bs3.flag_buy_sell='".$in['flag_buy_sell']."'	
															AND bs3.copy_id IN (
															
																				SELECT 	IFNULL(bs.id,0)
																				FROM slov_attribute sa, categories_attribute ca, slov_categories sc, buy_sell bs , buy_sell_attribute bsa 

																				LEFT JOIN ( SELECT av.id, sav.attribute_value FROM attribute_value av, slov_attribute_value sav WHERE sav.id=av.attribute_value_id ) avs 
																				ON avs.id=bsa.attribute_value_id 

																				WHERE bsa.buy_sell_id=bs.id AND ca.categories_id=bs.categories_id AND sa.id=ca.attribute_id 
																						AND bsa.attribute_id=ca.attribute_id AND (bsa.value<>'-' OR NOT avs.attribute_value IS NULL ) 
																						AND sc.active=1 AND bs.categories_id=sc.id
																						AND bs.id IN (	SELECT IFNULL(bs2.copy_id,0)
																										FROM buy_sell bs2 
																										WHERE 	bs2.company_id='".COMPANY_ID."'
																												AND bs2.status_buy_sell_id IN (12) 
																												AND bs2.flag_buy_sell='".$in['flag_buy_sell']."'		
																									)
																									
																						".$sql_bs."
																						AND bs.status_buy_sell_id IN (6) 
																						".$sql_flag_buy_sell."
																						AND ( 		LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																																			ELSE avs.attribute_value END) LIKE ? 
																								OR 	LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																																			ELSE avs.attribute_value END) LIKE ? 
																								OR LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																																			ELSE avs.attribute_value END) LIKE ? )												
																			)
													

													UNION ALL
													/*3*/

														");

			if($in['status_buy_sell_id']==11){// поиск в КУПЛЕНО
				$sql_dop = $arr_sql_dop[11];
				/*1и2 куплено*/
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
				/*1и2 куплено*/
			}
			elseif($in['status_buy_sell_id']==12){// поиск в ИСПОЛНЕНО
				$sql_dop = $arr_sql_dop[12];
				/*1и2и3 исполнено*/
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
				/*1и2и3 исполнено*/

			}elseif(!$in['status_buy_sell_id']){// мои заявки общее

				$sql_dop = implode(' ',$arr_sql_dop);
				/*1и2 куплено*/
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
				/*1и2 куплено*/

				/*1и2и3 исполнено*/
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
				/*1и2и3 исполнено*/

			}

			$sql .= " AND bs.id IN (
													SELECT qw.id
													FROM (
														SELECT bs.id, 
																CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END) attribute_value

														FROM buy_sell bs, slov_categories sc
														WHERE sc.active=1 AND bs.categories_id=sc.id
														".$sql_bs."
														AND bs.status_buy_sell_id IN (1,2,3,4,14,15)
														".$sql_flag_buy_sell."
														AND ( 		LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ? 
																OR 	LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ? 
																OR 	LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ?
															)
														
													UNION ALL

														SELECT bs.id,
															CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																ELSE avs.attribute_value END attribute_value
														FROM slov_attribute sa, categories_attribute ca, slov_categories sc, buy_sell bs , buy_sell_attribute bsa
		
														LEFT JOIN ( SELECT av.id, sav.attribute_value FROM attribute_value av, slov_attribute_value sav WHERE sav.id=av.attribute_value_id ) avs
																		ON avs.id=bsa.attribute_value_id

														WHERE bsa.buy_sell_id=bs.id AND ca.categories_id=bs.categories_id AND sa.id=ca.attribute_id
															AND bsa.attribute_id=ca.attribute_id AND (bsa.value<>'-' OR NOT avs.attribute_value IS NULL )
															AND sc.active=1 AND bs.categories_id=sc.id
															".$sql_bs."
															AND bs.status_buy_sell_id IN (1,2,3,4,14,15)
															".$sql_flag_buy_sell."
															AND ( 		LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																												ELSE avs.attribute_value END) LIKE ? 
																	OR 	LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																												ELSE avs.attribute_value END) LIKE ? 
																	OR LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																												ELSE avs.attribute_value END) LIKE ? )
														
													UNION ALL
													
													".$sql_dop."
									
														SELECT bs.id,
																c.company attribute_value

														FROM buy_sell bs, slov_categories sc, company c
														WHERE 	sc.active=1 AND bs.categories_id=sc.id
																".$sql_bs."
																AND bs.company_id2=c.id
																AND bs.status_buy_sell_id IN (11,12,14,15) 
																".$sql_flag_buy_sell."
																
																AND ( LOWER(c.company) LIKE ? OR LOWER(c.company) LIKE ? OR LOWER(c.company) LIKE ? )
														
													UNION ALL
									
														SELECT bs.id,
																c.company attribute_value

														FROM buy_sell bs, slov_categories sc, company c
														WHERE 	sc.active=1 AND bs.categories_id=sc.id
																".$sql_bs."
																AND bs.responsible_id=c.id
																AND bs.status_buy_sell_id IN (1,2,3,4,11,12,14,15) 
																".$sql_flag_buy_sell."
																
																AND ( LOWER(c.company) LIKE ? OR LOWER(c.company) LIKE ? OR LOWER(c.company) LIKE ? )
														
														
													) qw

													WHERE 1=1 
														/*AND ( LOWER(qw.attribute_value) LIKE ? OR LOWER(qw.attribute_value) LIKE ? OR LOWER(qw.attribute_value) LIKE ? )*/
														

										) ";

			array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
			array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
			array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
			array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
			//array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');


		}
		///
		//vecho($sql);
		if($in['flag_interests_invite']){

			$login_id_interests 		= (isset($in['login_id_interests'])&&!empty($in['login_id_interests']))? 		$in['login_id_interests'] 	: LOGIN_ID;
			$company_id_interests 	= (isset($in['company_id_interests'])&&!empty($in['company_id_interests']))? 	$in['company_id_interests'] 	: COMPANY_ID;

			$g		= new HtmlServive();
			$sql .= $g->SqlCompanyInterests(array('login_id'=>$login_id_interests,'company_id'=>$company_id_interests,'flag'=>2));
		}

		//vecho($in['flag_interests_invite'].$sql.$in['company_id']);

		// Группировка
		if($in['group'] && !$in['flag_group_id']){
			if($in['group']=='group_assets'){
				$sql_dop_group = 'assets_id';
			}elseif($in['group']=='group_responsible'){
				$sql_dop_group = 'responsible_id';
			}elseif($in['group']=='group_comments_company'){
				$sql_dop_group = 'comments_company';
			}


			$sql_select = "COUNT(bs.id) kol_group,
								MAX( CASE WHEN bs.data_status_buy_sell_23>bs.data_insert THEN bs.data_status_buy_sell_23 
																							ELSE bs.data_insert END ), ";
			$sql_group = " GROUP BY bs.".$sql_dop_group." ";
		}
		// Выборка Группировки
		if($in['flag_group_id']){

			$sql_limit = "";// выбираем все записи

			if($in['group']=='group_assets'){
				$sql .= ' AND bs.assets_id=? ';
				array_push($arr , $in['group_id']);
			}elseif($in['group']=='group_responsible'){
				$sql .= ' AND bs.responsible_id=? ';
				array_push($arr , $in['group_id']);
			}elseif($in['group']=='group_comments_company'){
				$sql .= ' AND bs.comments_company=? ';
				array_push($arr , $in['group_id']);
			}

		}




		$rf = reqSearchFilterParamCompany(array('login_id'=>LOGIN_ID,'company_id'=>COMPANY_ID));

		$sql_desc = ($rf['sort_12']==1)? " DESC " : "";

		if($rf['sort_who']=='sort_categories'){
			$sql_sort = " sc.categories ".$sql_desc." , ".$sql_sort;
		}elseif($rf['sort_who']=='sort_name'){
			$sql_sort = " bs.name ".$sql_desc." , ".$sql_sort;
		}else{
			$sql_sort = " CASE WHEN bs.data_status_buy_sell_23>bs.data_insert THEN bs.data_status_buy_sell_23 
																				ELSE bs.data_insert END ".$sql_desc." ";
		}


		$sql = "	SELECT 
							".$sql_select."
							bs.id, bs.login_id, bs.flag_buy_sell, bs.status_buy_sell_id, bs.categories_id, bs.responsible_id, 
							bs.company_id, bs.company_id2, bs.comments_company, bs.assets_id,
							DATE_FORMAT( bs.data_status_buy_sell_23, '%d %M' ) data_status_buy_sell_23,
							(SELECT DATEDIFF(DATE_ADD(bs.data_status_buy_sell_23, INTERVAL 30 DAY), NOW())) day_noactive,
							c2.company company2,
							(SELECT cr.company FROM company cr WHERE cr.id=bs.responsible_id) responsible,
							(SELECT vcb.kol FROM view_counter_buysellone vcb WHERE vcb.buy_sell_id=bs.id) kol_views, /* кол-во просмотров */
							CASE WHEN bs.status_buy_sell_id=2 OR bs.status_buy_sell_id=3 THEN
											(
													SELECT SUM(t.amount) FROM buy_sell t WHERE t.parent_id IN (SELECT tt.id FROM buy_sell tt WHERE tt.parent_id=bs.id) AND t.status_buy_sell_id=11 AND t.active=1
											) ELSE '' END kol_status11,  /* количество купленного данного предложения */
							bsc.cache_2, bsc.cache_1
					FROM slov_status_buy_sell sbs, buy_sell_cache bsc, slov_categories sc, buy_sell bs
					LEFT JOIN company c2 ON c2.id=bs.company_id2
					WHERE bsc.buy_sell_id=bs.id AND sbs.id=bs.status_buy_sell_id AND bs.categories_id=sc.id
							".$sql."
					".$sql_group."
					ORDER BY ".$sql_sort." 
							".$sql_limit." ";
		/*
	if(!$in['id']){
	vecho($sql.'*'.$in['company_id'].'*'.$in['flag_buy_sell'].'*'.$in['status_buy_sell_id'].'*'.$in['sbs_flag'].'*'.$in['categories_id'].'*'.$in['cities_id'].'*'.$group_id);
	exit;
	}
	*/

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// проверяем это сотрудник или владелец компании
	function reqMyBuySell_ProverkaInvite($p=array()) {

		$login_id 		= (isset($p['login_id'])&&!empty($p['login_id']))? 		$p['login_id'] 		: LOGIN_ID;
		$company_id 	= (isset($p['company_id'])&&!empty($p['company_id']))? 	$p['company_id'] 	: COMPANY_ID;

		$sql = " SELECT qw.login_id FROM
					(
						SELECT lcp.login_id FROM login_company_prava lcp
						WHERE lcp.company_id=".$company_id." 
							AND NOT lcp.login_id IN (SELECT t.login_id FROM company t WHERE t.id=".$company_id.")
					) qw
					WHERE qw.login_id=".$login_id."
					";

		$row = PreExecSQL_one($sql,array());

		return $row;
	}


	function reqMyBuySell_OfferMinCost($p=array()) {

		$sql = " SELECT 

						(SELECT CONCAT(MIN(t.cost),'*',COUNT(t.id),'*',t.parent_id) FROM buy_sell t 
						WHERE t.parent_id=".$p['buy_sell_id']." AND t.status_buy_sell_id=10 LIMIT 1 ) flag_offer_min_cost, /* предложеная мин.цена и кол-во предложений ОТ предложений */
											
						(SELECT CONCAT(MIN(t.cost),'*',COUNT(t.id),'*',t.parent_id) FROM buy_sell t 
						WHERE (t.parent_id=(SELECT t.parent_id FROM buy_sell t 
												 WHERE t.id IN	(SELECT t.copy_id FROM buy_sell t 
																 WHERE t.id=".$p['buy_sell_id']." AND t.status_buy_sell_id IN (11,12))
																)
									) AND t.status_buy_sell_id=10 LIMIT 1 ) flag_offer_min_cost2, /* предложеная мин.цена и кол-во предложений ОТ купленных и исполненных */
						
						(SELECT COUNT(bs0.parent_id) FROM buy_sell bs0
						WHERE (
								bs0.parent_id=".$p['buy_sell_id']." OR bs0.parent_id=( SELECT t.parent_id FROM buy_sell t WHERE t.id=(SELECT tt.copy_id FROM buy_sell tt WHERE tt.id=".$p['buy_sell_id'].") )
								)  
								AND bs0.id IN (SELECT t.tid FROM notification t 
												WHERE t.notification_id=2 AND t.login_id=".LOGIN_ID." AND t.company_id=".COMPANY_ID.") ) kol_notification_offer /* оповещение количество предложений */

					";
	//vecho($sql);
		$row = PreExecSQL_one($sql,array());

		return $row;
	}


	function reqBuySellActionOfferMinCost($p=array()) {

		$sql = " SELECT bs.company_id, bs.nomenclature_id
					FROM buy_sell bs 
					WHERE bs.id=".$p['id']."
					";

		$row = PreExecSQL_one($sql,array());

		return $row;
	}


	function reqMyBuySell_DopParam($p=array()) {

		$p['unit_group_id'] = ($p['unit_group_id'])? $p['unit_group_id'] : 0;

		$sql = " SELECT 
						
						( SELECT t.tid FROM notification t WHERE t.tid=".$p['buy_sell_id']." AND t.login_id=".LOGIN_ID." AND t.company_id=".COMPANY_ID." LIMIT 1 ) kol_notification, /* оповещение конкретное по ID (маркировка) */
							CASE WHEN ".$p['status_buy_sell_id']."=2 OR ".$p['status_buy_sell_id']."=3 THEN
											(
													SELECT SUM(t.amount) FROM buy_sell t WHERE t.parent_id IN (SELECT tt.id FROM buy_sell tt WHERE tt.parent_id=".$p['buy_sell_id'].") AND t.status_buy_sell_id=11
											) ELSE '' END kol_status11,  /* количество купленного данного предложения */
						
						(SELECT t.id FROM buy_sell t WHERE t.parent_id=".$p['buy_sell_id']." AND t.status_buy_sell_id=7 LIMIT 1) id_shleyf,/* создад заявку другой и получаем копию(шлейф) */
							
						(SELECT CASE WHEN ".$p['unit_group_id']."=1 THEN SUM(t.amount1) ELSE SUM(t.amount) END summ FROM buy_sell t WHERE t.parent_id=".$p['buy_sell_id']." AND t.status_buy_sell_id=12) kol_status12, /* сколько исполнено для куплено */
							
						(SELECT COUNT(t.id) FROM buy_sell_files t WHERE t.buy_sell_id=".$p['buy_sell_id'].") kol_photo,
							
						(SELECT vcb.kol FROM view_counter_buysellone vcb WHERE vcb.buy_sell_id=".$p['buy_sell_id'].") kol_views /* кол-во просмотров */
					";

		$row = PreExecSQL_one($sql,array());

		return $row;
	}


	// Заявка/Объявление ЧУЖИЕ
	function reqBuySell_pageBuy($p=array()) {
		$sql = '';
		$sql_order = ' bs.data_insert DESC ';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','flag_interests','share_url','company_id','flag_companyprofile',
			'categories_id','cities_id','value','flag_search','interests_id' ));

		$start_limit 	= (isset($p['start_limit'])&&v_int($p['start_limit']))? 	$p['start_limit'] : 0;

		$parent_id 	= (isset($p['parent_id']))? 	$p['parent_id'] : '';
		if(($parent_id)||($parent_id===0)){
			$sql	= 'and bs.parent_id=?';
			$arr	= array($parent_id);
		}
		if($in['id']){
			$sql .= ' AND bs.id=? ';
			array_push($arr , $in['id']);
			$one = true;
		}

		if($in['company_id']){
			$sql .= ' AND bs.company_id=? ';
			array_push($arr , $in['company_id']);
		}

		$t_status_buy_sell_id = '';
		if($in['flag_companyprofile']){
			$t_status_buy_sell_id = ',2,3';
		}

		$sql .= (!$in['share_url'])? " AND (	bs.status_buy_sell_id IN (3".$t_status_buy_sell_id.")
														OR ( bs.status_buy_sell_id IN (2".$t_status_buy_sell_id.") AND bs.company_id IN ( SELECT t.company_id_out FROM subscriptions t WHERE t.company_id_in=".COMPANY_ID." ) ) 
													) "
			: "";

		if( ($in['flag_interests']&&!$in['share_url']) || ($in['interests_id']) ){
			$g		= new HtmlServive();
			$sql .= $g->SqlCompanyInterests(array('company_id'=>COMPANY_ID,'flag'=>1,'interests_id'=>$in['interests_id']));
		}

		if($in['share_url']){
			$sql .= ' AND bs.id IN ( SELECT bss_ids.buy_sell_id
										FROM buy_sell_share bss, buy_sell_share_ids bss_ids
										WHERE bss_ids.buy_sell_share_id=bss.id AND bss.share_url=? ) ';
			array_push($arr , $in['share_url']);
		}


		// поиск
		if($in['categories_id']&&!$in['flag_interests']){

			$arr_c = explode(',',$in['categories_id']);
			$ins = str_repeat('?, ',  count ($arr_c) - 1) . '?';
			$sql .= ' AND bs.categories_id IN ('.$in['categories_id'].') ';

			/*
						$sql .= ' AND bs.categories_id=? ';
						array_push($arr , $in['categories_id']);
						*/
			//vecho($sql);
			//vecho($arr);
			//exit;
		}
		if($in['cities_id']&&!$in['flag_interests']){
			$sql .= ' AND bs.cities_id=? ';
			array_push($arr , $in['cities_id']);
		}
		if($in['flag_search']==22){// по наименованию категории
			if($in['value']&&empty($arr_c)){
				$sql .= " and LOWER(sc.categories) LIKE ?";
				array_push($arr , '%'.$in['value'].'%');
			}
		}elseif($in['flag_search']==23){// по типу
			if($in['value']){
				$sql .= " AND bs.id IN ( SELECT bsa.buy_sell_id
															FROM attribute_value av, slov_attribute_value sav, buy_sell_attribute bsa
															WHERE bsa.attribute_value_id=av.id 
																AND av.attribute_id=23 AND av.attribute_value_id=sav.id
																AND LOWER(sav.attribute_value) LIKE ? ) ";
				array_push($arr , '%'.$in['value'].'%');
			}
		}else{// по наименованию/артикулу
			if($in['value']){
				$sql .= " and ( LOWER(bs.name) LIKE ? OR bs.id IN ( 	SELECT bsa.buy_sell_id
																						FROM buy_sell_attribute bsa
																						WHERE  bsa.attribute_id=33 
																								AND LOWER(bsa.value) LIKE ? )
																		OR ( LOWER(c.company) LIKE ? OR LOWER(c.company) LIKE ? OR LOWER(c.company) LIKE ? )
																								) ";
				array_push($arr , '%'.$in['value'].'%');
				array_push($arr , '%'.$in['value'].'%');
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
			}
		}
		///

		$sql = "	SELECT 	bs.id, bs.company_id, bs.name, bs.url, bs.status_buy_sell_id,
							bs.categories_id, bs.urgency_id, bs.cost, 
							bs.multiplicity, bs.min_party,
							bs.amount, bs.comments, 
							bs.responsible_id, bs.nomenclature_id,
							sfp.form_payment,
							cities.name cities_name, cities.url_cities, c.company,
							CASE WHEN c.avatar IS NULL OR c.avatar='' THEN 
														CASE WHEN c.flag_account=1 THEN '/image/profile-icon.png' ELSE '/image/profile-logo.png' END 
																	ELSE c.avatar END avatar,
							sc.categories, sc.url_categories, su.urgency,  sunit.unit,
							DATE_FORMAT( bs.data_status_buy_sell_23, '%d %M' ) data_status_buy_sell_23,
							(SELECT DATEDIFF(DATE_ADD(bs.data_status_buy_sell_23, INTERVAL 30 DAY), NOW())) day_noactive,
							CASE WHEN bs.company_id<>".COMPANY_ID." AND bs.data_status_buy_sell_23>(SELECT pvs.data_visited 
																									FROM company_page_visited_send pvs 
																									WHERE pvs.page_id=1 AND pvs.login_id=".LOGIN_ID." AND pvs.company_id=".COMPANY_ID." ) 
										THEN 1 ELSE 0 END flag_new,
							CASE WHEN bs.status_buy_sell_id=2 OR bs.status_buy_sell_id=3 THEN
							(
								SELECT SUM(t.amount) FROM buy_sell t WHERE t.parent_id IN (SELECT tt.id FROM buy_sell tt WHERE tt.parent_id=bs.id) AND t.status_buy_sell_id=11
							) ELSE '' END kol_status11  /* количество купленного данного предложения */
					FROM company c, a_cities cities, slov_categories sc, slov_urgency su, slov_unit sunit, buy_sell bs
					LEFT JOIN slov_form_payment sfp ON sfp.id=bs.form_payment_id
					WHERE bs.company_id=c.id AND cities.id=bs.cities_id AND bs.categories_id=sc.id AND bs.urgency_id=su.id AND sc.unit_id=sunit.id 
							AND bs.flag_buy_sell=2
							/*and bs.id=2498851*/
							".$sql."
					ORDER BY bs.data_status_buy_sell_23 DESC LIMIT ".$start_limit." , 10 ";
		/*
			if(!$in['id']){
			vecho($sql);
			}
	*/
		$row = PreExecSQL_all($sql,$arr);

		return $row;
	}




	// Есть ли хоть одна Заявка/Объявление (для левого меню)
	function reqBuySellLeftMenu($p=array()) {

		if($p['flag_buy_sell']==2){
			$sql = "	SELECT bs.id
						FROM slov_status_buy_sell sbs, buy_sell bs 
						WHERE sbs.id=bs.status_buy_sell_id AND bs.company_id=".COMPANY_ID." 
								AND bs.flag_buy_sell=2 AND bs.active=1 AND sbs.flag=1
							LIMIT 1 ";
		}else{
			$sql = "	SELECT bs.id FROM buy_sell bs 
						WHERE ( (bs.flag_buy_sell=1 AND bs.company_id=".COMPANY_ID.")
									OR CASE WHEN bs.company_id2=".COMPANY_ID." AND bs.company_id2>0 THEN bs.flag_buy_sell IN (1,2) 
																						ELSE bs.company_id2=".COMPANY_ID." AND bs.flag_buy_sell IN (1) END
							) LIMIT 1 ";
		}

		//vecho($sql);
		$row = PreExecSQL_one($sql,array());

		return $row;
	}

	// Изображение к заявка/объявление
	function reqBuySellFiles($p=array()) {
		$sql = '';
		$one = false;
		$arr = array();
		$in = fieldIn($p, array('id_md5','buy_sell_id'));
		if($in['id_md5']){
			$sql	= " and MD5(CONCAT('".MD5."',f.id))=? ";
			$arr	= array($in['id_md5']);
			$one = true;
		}
		if($in['buy_sell_id']){// файлы о привязке
			$sql .= ' and f.buy_sell_id=?';
			array_push($arr , $in['buy_sell_id']);
		}

		$sql = " SELECT f.id, f.buy_sell_id, f.path, f.name_file, f.type_file,
									MD5(CONCAT('".MD5."',f.id)) id_md5
					FROM buy_sell_files f
					WHERE 1=1 ".$sql." 
					ORDER BY f.name_file ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}


	// Страница объявление sell.php
	function reqBuySell_PageSell($p=array()) {
		$sql = $sql_cities = '';
		$one = false;
		$arr = array();
		$in = fieldIn($p, array('val_grouping','categories_id','cities_id','value','flag_search','company_id','share_url','etp'));

		$sql_order = " bs.data_insert DESC ";

		$sql_sell = " AND ( 
								bs.status_buy_sell_id IN (3) OR ( bs.status_buy_sell_id IN (2) AND bs.company_id IN ( 	
																													SELECT t.company_id_out 
																													FROM subscriptions t 
																													WHERE t.company_id_in=".COMPANY_ID." ) 
															
																) 
															OR (  bs.company_id IN ( SELECT t.company_id FROM slov_qrq t WHERE t.promo=1 ) )
							) ";


		$sql_grouping = "
						/*исключаем сгруппированные*/
						AND NOT bs.id IN (	SELECT t.buy_sell_id
											FROM view_grouping_id_val_page_sell t
											WHERE NOT t.buy_sell_id IN (SELECT tt.buy_sell_id FROM view_grouping_id_kol_page_sell tt) )
						
						/**/
							";

																						// по умолчанию
		$sql_no_etp = " AND NOT bs.id IN ( SELECT buy_sell_id FROM buy_sell_etp_sell be ) ";// исключаем етп предложения (чтобы не попали других пользователей, которые запросили)




		if($in['val_grouping']){// Раскрываем Сгруппированные строки
			$sql_no_etp = '';
			$sql_order = " bs.cost ";
			$sql .= " AND bs.id IN (	SELECT t.buy_sell_id 
										FROM view_grouping_id_val_page_sell t
										WHERE t.val=? ) ";
			$sql_grouping = '';
			array_push($arr , $in['val_grouping']);
		}


		if($in['company_id']){
			$sql .= ' AND bs.company_id=? ';
			array_push($arr , $in['company_id']);
		}

		if($in['share_url']){
			$sql_sell = '';
			$sql .= ' AND bs.id IN ( SELECT bss_ids.buy_sell_id
										FROM buy_sell_share bss, buy_sell_share_ids bss_ids
										WHERE bss_ids.buy_sell_share_id=bss.id AND bss.share_url=? ) ';
			array_push($arr , $in['share_url']);

		}


		// поиск
		
		if($in['categories_id']){
			$arr_c = explode(',',$in['categories_id']);
			$ins = str_repeat('?, ',  count ($arr_c) - 1) . '?';
			$sql .= ' AND bs.categories_id IN ('.$in['categories_id'].') ';
			/*
						$sql .= ' AND bs.categories_id=? ';
						array_push($arr , $in['categories_id']);
						*/
		}
		if($in['cities_id']){
			$sql_cities = " AND bs.cities_id='".$in['cities_id']."' ";
		}
		if($in['flag_search']==22){// по наименованию категории
			if($in['value']&&empty($arr_c)){
				$sql .= " and LOWER(sc.categories) LIKE ?";
				array_push($arr , '%'.$in['value'].'%');
			}
		}elseif($in['flag_search']==23){// по типу
			if($in['value']){
				$sql .= " AND bs.id IN ( SELECT bsa.buy_sell_id
															FROM attribute_value av, slov_attribute_value sav, buy_sell_attribute bsa
															WHERE bsa.attribute_value_id=av.id 
																AND av.attribute_id=23 AND av.attribute_value_id=sav.id
																AND LOWER(sav.attribute_value) LIKE ? ) ";
				array_push($arr , '%'.$in['value'].'%');
			}
		}else{// по наименованию/артикулу
					
			if($in['value']){

				$sql_order = " bs.cost ";

				// вывести предложения с Етп
				$sql_no_etp = $sql_etp = '';
				if($in['etp']){
					$sql_cities = '';// при Этп город не учитывать (пока не понятно как с этп город учитыать 18-05-2022)
					$sql_etp = " OR bs.id IN (
											SELECT buy_sell_id
											FROM buy_sell_etp_sell be
											WHERE be.cookie_session='".COOKIE_SESSION."' AND be.company_id=".COMPANY_ID." 
											)";
					//array_push($arr , COOKIE_SESSION);
					//array_push($arr , COMPANY_ID);
				}

				$sql .= " and ( LOWER(bs.name) LIKE ? OR bs.id IN ( 	SELECT bsa.buy_sell_id
																						FROM buy_sell_attribute bsa
																						WHERE  bsa.attribute_id=33 
																								AND LOWER(bsa.value) LIKE ? ) 
																		".$sql_etp."						
													)
																								";
				array_push($arr , '%'.$in['value'].'%');
				array_push($arr , '%'.$in['value'].'%');
				
			}
		}
		///


		$sql = " SELECT bs.id, bs.login_id, bs.company_id, bs.name, bs.url, bs.categories_id, bs.cost, bs.multiplicity, bs.min_party,
						bs.amount, bs.comments,  bs.urgency_id, bs.form_payment_id,
						bs.availability, bs.qrq_id,
						sfp.form_payment, 
						c.company,
						cities.name cities_name, cities.url_cities, 
						sc.categories, sc.url_categories, 
						su.urgency, 
						sunit.unit, scurrency.currency,
						
						vg.val val_grouping, vg.kol kol_grouping, vg.min_cost min_cost_grouping, vg.attribute_ids attribute_ids_grouping,
						
						DATE_FORMAT( bs.data_status_buy_sell_23, '%d %M' ) data_status_buy_sell_23, 
						(SELECT DATEDIFF(DATE_ADD(bs.data_status_buy_sell_23, INTERVAL 30 DAY), NOW())) day_noactive, 
					 
						CASE WHEN bs.form_payment_id>0 THEN (SELECT t.coefficient FROM company_form_payment t 
											WHERE t.form_payment_id=bs.form_payment_id AND t.company_id=".COMPANY_ID.")*bs.cost ELSE 0 END AS cost_coefficient, 
										
						CASE WHEN bs.status_buy_sell_id=2 OR bs.status_buy_sell_id=3 THEN
							(
								SELECT SUM(t.amount) FROM buy_sell t WHERE t.parent_id=bs.id AND t.status_buy_sell_id=11
							) ELSE '' END kol_status11,  /* количество купленного данного предложения */
						

						(SELECT t.id FROM subscriptions t WHERE t.company_id_in=".COMPANY_ID." AND t.company_id_out=bs.company_id) flag_subscriptions_company_in, /* подписан на компанию чья заявка/объявление */ 
						(SELECT t.id FROM subscriptions t WHERE t.company_id_in=bs.company_id AND t.company_id_out=".COMPANY_ID.") flag_subscriptions_company_out /* подписчик компании чья заявка/объявление */ 

					 
									
					FROM company c, a_cities cities, slov_categories sc, slov_urgency su, slov_unit sunit, slov_currency scurrency, buy_sell bs 
					LEFT JOIN view_grouping_id_kol_page_sell vg ON vg.buy_sell_id=bs.id AND vg.kol>1
					LEFT JOIN slov_form_payment sfp ON sfp.id=bs.form_payment_id 

					WHERE bs.company_id=c.id AND cities.id=bs.cities_id AND bs.categories_id=sc.id AND bs.urgency_id=su.id AND sc.unit_id=sunit.id AND bs.currency_id=scurrency.id
							AND bs.parent_id=0 AND bs.flag_buy_sell=1
							
							".$sql_sell."
							
							/*исключаем сгруппированные*/
							".$sql_grouping."
							/**/
							
							".$sql."
							
							".$sql_cities."
							
							".$sql_no_etp."

					ORDER BY ".$sql_order."   ";
	//vecho($sql);
	//exit;
		$row = PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Предложения на заявки
	function reqBuySell_Offer($p=array()) {
		$sql = $inner_join_grouping = $sql_order = '';
		$sql_select_grouping = " '' cost_grouping, '' val_grouping, '' kol_grouping, ";
		$one = false;
		$arr = array();
		$in = fieldIn($p, array('id','val_grouping','company_id','flag','login_id','group','start_limit','flag_limit','end_limit'));

		$in['start_limit'] 	= ($in['start_limit'])? 	$in['start_limit'] 	: 0;
		$in['end_limit'] 	= ($in['end_limit'])? 	$in['end_limit'] 	: 5;

		$sql_limit = ($in['flag_limit'])? " LIMIT ".$in['start_limit']." , ".$in['end_limit']." " : '';


		$parent_id 	= (isset($p['parent_id']))? 	$p['parent_id'] : '';
		if(($parent_id)||($parent_id===0)){
			$sql	= 'and bs.parent_id=?';
			$arr	= array($parent_id);
		}

		if($in['id']){
			$sql .= ' AND bs.id=? ';
			$arr	= array($in['id']);
			$one = true;
		}

		if($in['company_id']){
			$sql .= ' AND bs.company_id=? ';
			array_push($arr , $in['company_id']);
		}

		if($in['login_id']){
			$sql .= ' AND bs.login_id=? ';
			array_push($arr , $in['login_id']);
		}


		if($in['group']&&$parent_id){
			$sql_select_grouping = " vg.val val_grouping, vg.cost cost_grouping, vg.kol kol_grouping, ";
			// view_grouping_kol_offer - рабочий , но долго...
			// INNER JOIN view_grouping_kol_offer  vg ON vg.buy_sell_id=bs.id AND vg.parent_id=bs.parent_id
			// (ТАК БЫСТРЕЕ)
			$inner_join_grouping = " INNER JOIN (SELECT `qw`.`parent_id` AS `parent_id`, IFNULL(`qw`.`val`,'vdo_qrq_vdo') AS `val`,
														  COUNT(`qw`.`parent_id`) AS `kol`,
														  MIN(`qw`.`cost`) AS `cost`, `qw`.`id`        AS `buy_sell_id`
												FROM (SELECT
														`bs`.`id`         AS `id`,
														`bs`.`parent_id`  AS `parent_id`,
														`bs`.`cost`       AS `cost`,
														CASE WHEN bs.form_payment_id>0 THEN IFNULL(((SELECT t.coefficient FROM company_form_payment t 
																WHERE t.form_payment_id=bs.form_payment_id AND t.company_id=".COMPANY_ID.")*bs.cost),bs.cost) ELSE 0 END AS cost_coefficient,
								
														GROUP_CONCAT((CASE WHEN (`bsa`.`attribute_value_id` <> '') THEN `bsa`.`attribute_value_id` ELSE `bsa`.`value` END) SEPARATOR ',') AS `val`
													  FROM (`dailysnab_db`.`buy_sell` `bs`
														 LEFT JOIN `dailysnab_db`.`buy_sell_attribute` `bsa`
														   ON (((`bsa`.`buy_sell_id` = `bs`.`id`)
																AND `bsa`.`attribute_id` IN(SELECT
																							  `ca`.`attribute_id`
																							FROM `dailysnab_db`.`categories_attribute` `ca`
																							WHERE ((`ca`.`categories_id` = `bs`.`categories_id`)
																								   AND (`ca`.`grouping_sell` = 1))))))
													  WHERE ((`bs`.`flag_buy_sell` = 2)
															 AND (`bs`.`status_buy_sell_id` = 10))
															 AND bs.parent_id=".$parent_id."
													  GROUP BY `bs`.`id`,`bs`.`parent_id`
													  ORDER BY GROUP_CONCAT(IFNULL(`bsa`.`value`,`bsa`.`attribute_value_id`)SEPARATOR ','),cost_coefficient) `qw`
												GROUP BY `qw`.`parent_id`,`qw`.`val`) vg ON vg.buy_sell_id=bs.id AND vg.parent_id=bs.parent_id ";
		}

		if($in['val_grouping']){// Раскрываем Сгруппированные строки
			// view_grouping_id_val_offer - рабочий , но долго...
			//$sql .= " AND bs.id IN (	SELECT vv.buy_sell_id
			//						FROM view_grouping_id_val_offer vv
			//						WHERE vv.parent_id=".$parent_id." AND vv.val=? ) ";
			// (ТАК БЫСТРЕЕ)
			$sql .= " AND bs.id IN (	SELECT qw.buy_sell_id
										FROM (
											SELECT
											  `bs`.`id`        AS `buy_sell_id`,
											  `bs`.`parent_id` AS `parent_id`,
											  IFNULL(GROUP_CONCAT((CASE WHEN (`bsa`.`attribute_value_id` <> '') THEN `bsa`.`attribute_value_id` ELSE `bsa`.`value` END) SEPARATOR ','),'vdo_qrq_vdo') AS `val`
											FROM (`buy_sell` `bs`
											   LEFT JOIN `buy_sell_attribute` `bsa`
												 ON (((`bsa`.`buy_sell_id` = `bs`.`id`)
												  AND `bsa`.`attribute_id` IN(SELECT
																`ca`.`attribute_id`
																  FROM `categories_attribute` `ca`
																  WHERE ((`ca`.`categories_id` = `bs`.`categories_id`)
																	 AND (`ca`.`grouping_sell` = 1))))))
											WHERE ((`bs`.`flag_buy_sell` = 2)
												   AND (`bs`.`status_buy_sell_id` = 10))
												   AND bs.parent_id=".$parent_id."
												   
											GROUP BY `bs`.`id`,`bs`.`parent_id`
										) qw
										WHERE qw.val=? ) ";
			array_push($arr , $in['val_grouping']);
		}


		if($in['flag']=='count'){// Количество

			$one = true;

			$sql_select = " COUNT(qw.id) kol , MIN(cost_coefficient) min_cost 
								FROM (
									 SELECT
												bs.id , 
									CASE WHEN bs.form_payment_id>0 THEN IFNULL(((SELECT t.coefficient FROM company_form_payment t 
												WHERE t.form_payment_id=bs.form_payment_id AND t.company_id=".COMPANY_ID.")*bs.cost),bs.cost) ELSE 0 END AS cost_coefficient

									 ";

			$sql_order = " ) qw ";

		}else{

			$sql_select = "bs.id, bs.parent_id, bs.login_id, bs.company_id, bs.name, bs.url, bs.categories_id, bs.cost, bs.cost1,
								bs.multiplicity, bs.min_party, bs.delivery_id,
								bs.amount, bs.comments, 
								bs.amount1, bs.unit_id1, bs.amount2, bs.unit_id2,
								su1.unit unit1, su2.unit unit2,
								bs.availability, bs.form_payment_id, bs.nomenclature_id,bs.qrq_id,
								DATE_FORMAT( bs.data_insert, '%d %M %H:%i' ) data_insert,
								DATE_FORMAT( bs.data_status_buy_sell_10, '%d %M' ) data_status_buy_sell_10,
								sfp.form_payment, 
								cities.name cities_name, cities.url_cities, 
								sc.categories, sc.url_categories, sc.unit_id, sc.unit_group_id, 
								su.urgency, 
								sunit.unit, scurrency.currency,
								c.company,
									CASE WHEN c.avatar IS NULL OR c.avatar='' THEN 
																CASE WHEN c.flag_account=1 THEN '/image/profile-icon.png' ELSE '/image/profile-logo.png' END 
																			ELSE c.avatar END avatar,
								".$sql_select_grouping."
							 
								CASE WHEN bs.form_payment_id>0 THEN IFNULL(((SELECT t.coefficient FROM company_form_payment t 
													WHERE t.form_payment_id=bs.form_payment_id AND t.company_id=".COMPANY_ID.")*bs.cost),bs.cost) ELSE 0 END AS cost_coefficient, 
												
								(SELECT t.id FROM subscriptions t WHERE t.company_id_in=".COMPANY_ID." AND t.company_id_out=bs.company_id) flag_subscriptions_company_in, /* подписан на компанию чья заявка/объявление */ 
								(SELECT t.id FROM subscriptions t WHERE t.company_id_in=bs.company_id AND t.company_id_out=".COMPANY_ID.") flag_subscriptions_company_out, /* подписчик компании чья заявка/объявление */ 
								
								( SELECT t.tid FROM notification t WHERE t.tid=bs.id AND t.login_id=".LOGIN_ID." AND t.company_id=".COMPANY_ID." LIMIT 1 ) kol_notification, /* оповещение конкретное по ID (маркировка) */
								
								(SELECT SUM(t.amount_buy) FROM buy_sell t WHERE t.parent_id=bs.id AND t.active=1) kol_status11,  /* количество купленного данного предложения */
							 
								(SELECT t.value FROM buy_sell_attribute t WHERE t.buy_sell_id=bs.id AND t.attribute_id=7 LIMIT 1) qrq_srok_dn
								";

		}


		$sql = " SELECT 
							".$sql_select."
			
					FROM company c, a_cities cities, slov_categories sc, slov_urgency su, slov_unit sunit, slov_currency scurrency, buy_sell bs 
					".$inner_join_grouping."
					LEFT JOIN slov_form_payment sfp ON sfp.id=bs.form_payment_id
					LEFT JOIN slov_unit su1 ON su1.id=bs.unit_id1
					LEFT JOIN slov_unit su2 ON su2.id=bs.unit_id2

					WHERE bs.company_id=c.id AND cities.id=bs.cities_id AND bs.categories_id=sc.id 
							AND bs.urgency_id=su.id AND sc.unit_id=sunit.id AND bs.currency_id=scurrency.id
						
							AND bs.status_buy_sell_id=10
					
							".$sql."

					ORDER BY cost_coefficient  ".$sql_limit."
					
					".$sql_order."
					
					  ";

	//if($in['flag']=='count'){// Количество

	//vecho($sql.'*'.$parent_id.'*'.$in['company_id'].'*'.$in['val_grouping']);

	//}
	//vecho($sql.'*'.$parent_id.'*'.$in['company_id']);
		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}


	// купленное количество по заявке
	function reqBuySell_Offer_AmountBuy( $p=array() ) {

		$sql = "	SELECT SUM(t.amount) amount_buy FROM buy_sell t
					WHERE t.parent_id IN (
											SELECT tt.id FROM buy_sell tt
											WHERE tt.parent_id=".$p['id']."
										) 
							AND t.status_buy_sell_id=11 ";

		$row = PreExecSQL_one($sql,array());

		return $row;
	}


	// Заявка/Объявление - динамические параметры
	function reqBuySellLastStatusBuySellId() {

		$sql = "	SELECT status_buy_sell_id 
					FROM buy_sell 
					WHERE login_id=".LOGIN_ID."
					ORDER BY data_status_buy_sell_23 DESC LIMIT 1";

		$row = PreExecSQL_one($sql,array());

		return $row;
	}


	// Заявка/Объявление - динамические параметры
	function reqBuySellRowShare($ids=0) {
		$arr = explode(',',$ids);
		$in  = str_repeat('?,', count($arr) - 1) . '?';

		$sql = "	SELECT bs.id 
					FROM buy_sell bs
					WHERE bs.company_id=".COMPANY_ID." AND bs.status_buy_sell_id IN (2,3)
							AND bs.id IN (".$in.")
					ORDER BY id ";

		$row = PreExecSQL_all($sql,$arr);

		return $row;
	}


	// Заявка/Объявление - динамические параметры
	function reqBuySellAttribute($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','buy_sell_id','attribute_id','attribute_value_id','one'));
		if($in['buy_sell_id']){
			$sql .= ' AND bsa.buy_sell_id=? ';
			array_push($arr , $in['buy_sell_id']);
		}
		if($in['attribute_id']){
			$sql .= ' AND bsa.attribute_id=? ';
			array_push($arr , $in['attribute_id']);
		}
		if($in['attribute_value_id']){
			$sql .= ' AND bsa.attribute_value_id=? ';
			array_push($arr , $in['attribute_value_id']);
		}
		if($in['one']){
			$one = true;
		}

		$sql = "	SELECT bsa.id, bsa.buy_sell_id, bsa.attribute_id, bsa.attribute_value_id, bsa.value
					FROM buy_sell_attribute bsa
					WHERE 1=1 ".$sql." ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}


	/*
		// Заявка/Объявление - Наименование Бренда (использется qrq)
		function reqBuySellAttributeBrand($p=array()) {

			$sql = "	SELECT sav.attribute_value
					FROM attribute_value av, slov_attribute_value sav, buy_sell_attribute bsa
					WHERE bsa.attribute_value_id=av.id AND av.attribute_value_id=sav.id
							AND av.attribute_id=3 AND bsa.buy_sell_id=? ";

			$row = PreExecSQL_one($sql,array($p['buy_sell_id']));

			return $row;
		}
		*/

	// Заявка/Объявление - количество заявок/объявлений пользователей
	function reqCountBuySellByCompany($p=array()) {

		$in = fieldIn($p, array('categories_id','flag_buy_sell'));

		$sql = "	SELECT COUNT(bs.id) kol 
					FROM buy_sell bs
					WHERE bs.parent_id=0 AND bs.status_buy_sell_id=3 AND bs.company_id=? AND bs.categories_id=? AND bs.flag_buy_sell=?
					";

		$row = PreExecSQL_one($sql,array(COMPANY_ID,$in['categories_id'],$in['flag_buy_sell']));

		return $row;
	}

	// выбераем последнюю срочность, если создавалась заявка в течении 15 минут
	function reqBuySellUrgency15min($p=array()) {

		$in = fieldIn($p, array('categories_id'));

		$sql = "	SELECT bs.urgency_id FROM buy_sell bs
					WHERE bs.data_insert>=DATE_SUB(NOW(), INTERVAL 15 MINUTE) AND bs.company_id=? AND bs.flag_buy_sell=2 LIMIT 1
					";

		$row = PreExecSQL_one($sql,array(COMPANY_ID));

		return $row;
	}

	// выбераем последнюю добавленную запись
	function reqBuySell_LastId($p=array()) {

		$in = fieldIn($p, array('flag_buy_sell','status_buy_sell_id'));

		$sql_status_buy_sell_id = ($in['status_buy_sell_id'])? $in['status_buy_sell_id'] : '1,2,3';

		$sql = "	SELECT bs.id , bs.delivery_id
							/*
							, bs.parent_id, bs.copy_id, bs.login_id login_id_bs, bs.company_id, bs.flag_buy_sell, bs.name, bs.url,
						   bs.status_buy_sell_id, bs.cities_id,
						   CASE WHEN bs.availability=0 THEN '' ELSE bs.availability END availability ,
						   bs.categories_id, bs.urgency_id, bs.cost, bs.currency_id, bs.form_payment_id,
						   bs.multiplicity, bs.min_party,
						   bs.amount, bs.comments,
						   bs.comments_company,
						   bs.responsible_id, bs.nomenclature_id
							*/
				   FROM buy_sell bs
				  
				   WHERE bs.flag_buy_sell=? AND bs.status_buy_sell_id IN (".$sql_status_buy_sell_id.")
						AND bs.company_id=".COMPANY_ID."
				   ORDER BY bs.id DESC LIMIT 1 
					";

		$row = PreExecSQL_one($sql,array($in['flag_buy_sell']));

		return $row;
	}


	// Заявка/Объявление - заметки пользователей
	function reqBuySellNote($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','buy_sell_id','company_id','one'));
		if($in['buy_sell_id']){
			$sql .= ' AND bsn.buy_sell_id=? ';
			array_push($arr , $in['buy_sell_id']);
		}
		if($in['company_id']){
			$sql .= ' AND bsn.company_id=? ';
			array_push($arr , $in['company_id']);
		}
		if($in['one']){
			$one = true;
		}

		$sql = "	SELECT bsn.id, bsn.buy_sell_id, bsn.company_id, bsn.note
					FROM buy_sell_note bsn
					WHERE 1=1 ".$sql." ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Заявка - сумма покупок заявки
	function reqBuySellBuyOffer($p=array()) {

		$in = fieldIn($p, array('buy_sell_id'));

		$sql = "	SELECT SUM(t.amount) sum_amount
					FROM buy_sell t
					WHERE t.parent_id IN (SELECT tt.id FROM buy_sell tt WHERE tt.parent_id=?)
							AND t.status_buy_sell_id=11 ";

		/* сумма-стоимость покупки
			$sql = "	SELECT SUM(CASE WHEN t.unit_id1=1 THEN t.amount_buy*t.cost1 ELSE (t.cost1/t.amount1)*t.amount_buy END) sum_cost, sc.currency
					FROM buy_sell t, slov_currency sc
					WHERE t.currency_id=sc.id
							AND t.parent_id IN (SELECT tt.id FROM buy_sell tt WHERE tt.parent_id=?)
							AND t.status_buy_sell_id=11
					GROUP BY sc.currency DESC ";
			*/

		$row = PreExecSQL_one($sql,array($in['buy_sell_id']));

		return $row;
	}

	// Заявка/Объявление - динамические параметры
	function reqSlovStatusBuySellByCompany($p=array()) {
		$sql = $sql_dop = $sql_no1 = $sql_no2 = $sql_bs = '';
		$arr = array();
		$in = fieldIn($p, array('flag_buy_sell','flag','flag_interests_invite'));
		$arr = array($in['flag_buy_sell']);

		if($in['flag_buy_sell']==1){
			$sql_no1 = ' AND 1=2 ';
			$url_priznak = 'sell';
			$dop_sql = " AND ( (bs.flag_buy_sell=1 AND bs.company_id=".COMPANY_ID.") OR (bs.flag_buy_sell=2 AND bs.company_id2=".COMPANY_ID.") )";
		}elseif($in['flag_buy_sell']==2){
			$url_priznak = 'buy';
			$dop_sql = " AND bs.flag_buy_sell=2 AND bs.company_id=".COMPANY_ID." ";
			$sql_no2 = ' AND 1=2 ';
		}elseif($in['flag_buy_sell']==4){
			$url_priznak = 'buy';
			$dop_sql = " AND bs.flag_buy_sell=4 AND bs.company_id=".COMPANY_ID." ";
			$sql_no2 = ' AND 1=2 ';
		}


		if($in['flag_interests_invite']){
			$g		= new HtmlServive();
			$sql_bs 	= $g->SqlCompanyInterests(array('login_id'=>LOGIN_ID,'company_id'=>COMPANY_ID,'flag'=>2));
		}

		$sql = "	SELECT sbs.id, sbs.status_buy, sbs.status_sell, IFNULL(bs.kol,0) kol, sbs.sort, '".$url_priznak."' url_priznak,
							IFNULL(( 	
								SELECT COUNT(bs0.id) 
								FROM buy_sell bs0
								WHERE 	bs0.id IN (
												SELECT bs.parent_id FROM buy_sell bs
												WHERE bs.id IN (SELECT t.tid FROM notification t WHERE t.notification_id=2 AND t.login_id=".LOGIN_ID." AND t.company_id=".COMPANY_ID." ".$sql_no1.")
												) 
										AND bs0.status_buy_sell_id=sbs.id ".$sql_no1."
							),0)
							+
							IFNULL((	
								SELECT COUNT(DISTINCT bs.id) FROM buy_sell bs
								WHERE bs.id IN (SELECT t.tid FROM notification t WHERE t.notification_id IN (3) AND t.login_id=".LOGIN_ID." AND t.company_id=".COMPANY_ID." ".$sql_no1.")
									AND bs.status_buy_sell_id=sbs.id ".$sql_no1."
							),0)
							+
							IFNULL((	
								SELECT COUNT(DISTINCT bs.id) FROM buy_sell bs
								WHERE bs.id IN (SELECT t.tid FROM notification t WHERE t.notification_id IN (5,6,7,8) AND t.login_id=".LOGIN_ID." AND t.company_id=".COMPANY_ID." ".$sql_no2.")
									AND bs.status_buy_sell_id=sbs.id ".$sql_no2."
							),0) kol_notification /* Оповещение (заявки по которым есть предложение) */
					FROM slov_status_buy_sell sbs
					LEFT JOIN (	SELECT bs.status_buy_sell_id, COUNT(bs.id) kol
								FROM buy_sell bs
								WHERE bs.active=1 ".$dop_sql." ".$sql_bs."
								GROUP BY bs.status_buy_sell_id ) bs ON bs.status_buy_sell_id=sbs.id
					WHERE NOT sbs.id IN (5,6,13) AND sbs.flag=".$in['flag']."

					ORDER BY 5 ";

		$row = PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Заявка/Объявление - 6 динамическиx параметров для табличного представления ()
	function reqBuySellAttributeSixParam($p=array()) {
		$sql = $sql_sort = '';
		$arr = array();
		$in = fieldIn($p, array('flag','buy_sell_id','categories_id','where'));

		$prefix = 'buy_sell';

		$sql_select = "	sa.attribute, 
							CASE WHEN bsa.attribute_value_id=0 OR bsa.attribute_value_id IS NULL THEN bsa.value ELSE avs.attribute_value END  attribute_value ";
		$sql_group = " bsa.value , avs.attribute_value ";

		if($in['flag']=='six'){
			$sql_sort = ' AND ca.sort<7 ';
			$sql_select = "	GROUP_CONCAT(DISTINCT sa.attribute ORDER BY ca.sort SEPARATOR ', ') attribute,
								GROUP_CONCAT(CASE WHEN bsa.attribute_value_id=0 OR bsa.attribute_value_id IS NULL THEN bsa.value ELSE avs.attribute_value END  ORDER BY ca.sort SEPARATOR ', ') attribute_value ";
			$sql_group = " ca.sort ";
		}

		if($in['where']=='nomenclature'){
			$prefix = 'nomenclature';
		}

		$sql = "	SELECT ca.sort, sa.id, ".$sql_select."
					FROM slov_attribute sa, categories_attribute ca, ".$prefix."_attribute bsa
					LEFT JOIN (	SELECT av.id, sav.attribute_value
							FROM attribute_value av, slov_attribute_value sav
							WHERE av.categories_id=".$in['categories_id']." AND sav.id=av.attribute_value_id ) avs ON avs.id=bsa.attribute_value_id
					WHERE bsa.".$prefix."_id=".$in['buy_sell_id']." AND ca.categories_id=".$in['categories_id']." AND sa.id=ca.attribute_id AND bsa.attribute_id=ca.attribute_id
								AND (bsa.value<>'-' OR NOT avs.attribute_value IS NULL )
							".$sql_sort."
					GROUP BY ".$sql_group."
					ORDER BY ca.sort ";
		//vecho($sql);

	//if(!$in['categories_id']){
		//vecho($sql.$in['buy_sell_id']);
	//}
		$row = PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Админка - Проверка удаления Атрибутов в категории и Значение Атрибутов
	function reqProverkaDelete_CategoriesAttribute_SlovAttributeValue($p=array()) {
		$sql = '';
		$arr = array();
		$in = fieldIn($p, array('categories_attribute_id','slov_attribute_value_id'));

		if($in['categories_attribute_id']){
			$sql	= ' and ca.id=?';
			$arr = array($in['categories_attribute_id']);
		}
		if($in['slov_attribute_value_id']){
			$sql	= ' and sav.id=?';
			$arr = array($in['slov_attribute_value_id']);
		}


		$sql = "	SELECT COUNT(bsa.id) kol
					FROM categories_attribute ca, attribute_value av, slov_attribute_value sav, buy_sell_attribute bsa
					WHERE bsa.attribute_value_id=av.id AND av.attribute_value_id=sav.id 
							AND ca.categories_id=av.categories_id AND av.attribute_id=ca.attribute_id 
							".$sql."
					 ";

		$row = PreExecSQL_one($sql,$arr);

		return $row;
	}


	// Проверяем сколько прошло дней при нажатии "Купить", "Исполено", "Отмена" , "Возврат"  и т.д.
	function reqProverkaDay($p=array()) {
		$row = array('kol_day'=>0);

		if($p['data_insert']){
			$sql = "	SELECT (TO_DAYS(NOW())-TO_DAYS('".$p['data_insert']."')) kol_day ";

			$row = PreExecSQL_one($sql,array());
		}

		return $row;
	}



	function reqProverkaAmountBuy($p=array()) {
		$sql = '';
		$arr = array();
		$in = fieldIn($p, array('buy_sell_id','flag','status'));

		// Проверяем количество требуемое в заявке при нажатии |"Купить" в предложение| или |"Отменить" в куплено|
		if($in['flag']==11){
			// если купили более или равно чем изначально заявка
			$sql = "	SELECT 	CASE WHEN 
									(	
										SELECT SUM(t.amount) FROM buy_sell t 
										WHERE t.parent_id IN (	SELECT tt.id 
																FROM buy_sell tt 
																WHERE tt.parent_id=".$in['buy_sell_id']." ) 
												AND t.status_buy_sell_id=11	AND t.active=1
									)
									>=
									(SELECT bs.amount FROM buy_sell bs WHERE bs.id=".$in['buy_sell_id'].") 
								THEN 1 ELSE 0 END flag_amount
						";
		}
		// Проверяем количество |"Исполнено+Возврат" после "Куплено"| с КУПЛЕНО
		elseif($in['flag']==12){
			$sql_amount = ($in['status']==12)? 'amount_buy' : 'amount1';
			$sql = "	SELECT CASE WHEN
							 (SELECT CASE WHEN sc.unit_group_id=1 THEN SUM(t.amount1) ELSE SUM(t.amount) END summ
						FROM buy_sell t, slov_categories sc WHERE t.categories_id=sc.id AND t.parent_id=".$in['buy_sell_id']." AND t.status_buy_sell_id IN (12,14))
							 >=
							 (SELECT CASE WHEN sc.unit_group_id=1 THEN SUM(bs.".$sql_amount.") ELSE SUM(bs.amount) END summ
						FROM buy_sell bs, slov_categories sc WHERE bs.categories_id=sc.id AND bs.id=".$in['buy_sell_id'].")
					   THEN 1 ELSE 0 END flag_amount
						";
			/*
				$sql = "	SELECT 	CASE WHEN
									(SELECT SUM(t.amount) FROM buy_sell t WHERE t.parent_id=".$in['buy_sell_id']." AND t.status_buy_sell_id IN (12,14))
									>=
									(SELECT bs.amount FROM buy_sell bs WHERE bs.id=".$in['buy_sell_id'].")
						THEN 1 ELSE 0 END flag_amount
						";
				*/
		}
		// Проверяем количество "Возвращено" после "Возврат"
		elseif($in['flag']==15){
			$sql = "	SELECT CASE WHEN
							 (SELECT CASE WHEN sc.unit_group_id=1 THEN SUM(t.amount1) ELSE SUM(t.amount) END summ
						FROM buy_sell t, slov_categories sc WHERE t.categories_id=sc.id AND t.parent_id=".$in['buy_sell_id']." AND t.status_buy_sell_id IN (15))
							 >=
							 (SELECT CASE WHEN sc.unit_group_id=1 THEN SUM(bs.amount1) ELSE SUM(bs.amount) END summ
						FROM buy_sell bs, slov_categories sc WHERE bs.categories_id=sc.id AND bs.id=".$in['buy_sell_id'].")
					   THEN 1 ELSE 0 END flag_amount
						";
			/*
				$sql = "	SELECT 	CASE WHEN
									(SELECT SUM(t.amount) FROM buy_sell t WHERE t.parent_id=".$in['buy_sell_id']." AND t.status_buy_sell_id IN (15))
									>=
									(SELECT bs.amount FROM buy_sell bs WHERE bs.id=".$in['buy_sell_id'].")
						THEN 1 ELSE 0 END flag_amount
						";
				*/
		}

	//vecho($sql);

		$row = PreExecSQL_one($sql,array());

		return $row;
	}


	// УБРАТЬ !!!! (проверить поиском)
	// Проверяем количество требуемое в заявке при нажатии "Купить" предложения
	/*function reqProverkaAmountOfferByBuy($p=array()) {
			$sql = '';
			$arr = array();
			$in = fieldIn($p, array('buy_sell_id'));


			$sql = "	SELECT CASE WHEN SUM(bo.amount_offer)>=( SELECT t.amount FROM buy_sell t WHERE t.id=(SELECT t.parent_id FROM buy_sell t WHERE t.id='".$in['buy_sell_id']."')) THEN 1 ELSE 0 END flag_amount ,
							(SELECT t.parent_id FROM buy_sell t WHERE t.id='".$in['buy_sell_id']."') buy_sell_id
					FROM buy_offer bo
					WHERE bo.status_offer_id IN (11,12)
							AND bo.buy_sell_id IN (SELECT t.id FROM buy_sell t
													WHERE t.parent_id=(SELECT t.parent_id FROM buy_sell t WHERE t.id='".$in['buy_sell_id']."'))
					 ";

			$row = PreExecSQL_one($sql,array());

			return $row;
		}*/


	// Заявка/Объявление - История изменений
	function reqHistoryBuySell($p=array()) {
		$sql = $sql_sort = '';
		$arr = array();
		$in = fieldIn($p, array('buy_sell_id'));

		$sql = "	SELECT h.id, h.login_id, h.buy_sell_id, h.value_new, h.value_old, h.comments, 
							DATE_FORMAT( h.data_insert, '%d %M %H:%i' ) data_insert,
							(	SELECT c.company
								FROM company c
								WHERE c.flag_account=1 AND c.login_id=h.login_id ) company
					FROM history_buy_sell h
					WHERE h.buy_sell_id='".$in['buy_sell_id']."'
					ORDER BY id desc ";

		$row = PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Админка - Поисковые запросы - Наименования и Артикул
	function reqAdminSearchNameArticul($p=array()) {
		$sql = $sql_sort = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('kol','ipage','count_page'));


		$sql = "	SELECT 'Наименование' pole, 1 flag_pole, bs.name, bs.categories_id, sc.categories, COUNT(bs.id) kol, 
						GROUP_CONCAT(DISTINCT CASE WHEN bs.flag_buy_sell=1 THEN 'Объявление' ELSE 'Заявка' END ORDER BY bs.flag_buy_sell) nflag_buy_sell
					FROM buy_sell bs, slov_categories sc
					WHERE bs.flag_buy_sell IN (1,2) AND bs.categories_id=sc.id
					GROUP BY bs.name, sc.categories
					UNION ALL 
					SELECT 'Артикул' pole, 2 flag_pole, bsa.value, bs.categories_id, sc.categories, COUNT(bsa.id) kol, 
						GROUP_CONCAT(DISTINCT CASE WHEN bs.flag_buy_sell=1 THEN 'Объявление' ELSE 'Заявка' END ORDER BY bs.flag_buy_sell) nflag_buy_sell
					FROM buy_sell bs, buy_sell_attribute bsa, slov_attribute sa, slov_categories sc
					WHERE bsa.buy_sell_id=bs.id AND bs.categories_id=sc.id AND bsa.attribute_id=sa.id AND bsa.attribute_id=33
					GROUP BY bsa.value, sc.categories ";
		$sql_order 		= " ORDER BY 6 DESC LIMIT ".$in['ipage'].",".$in['count_page']." ";

		if($in['kol']==true){
			$sql = "	SELECT COUNT(qw.pole) kol
						FROM (
								".$sql."
						) qw ";
			$one = true;
		}else{
			$sql = $sql.$sql_order;
		}


		/*
			$sql = "	SELECT 'Наименование' pole, 1 flag_pole, bs.name, bs.categories_id,
						GROUP_CONCAT(DISTINCT bs.flag_buy_sell ORDER BY bs.flag_buy_sell) flag_search, sc.categories, COUNT(bs.id) kol,
						GROUP_CONCAT(DISTINCT CASE WHEN bs.flag_buy_sell=1 THEN 'Объявление' ELSE 'Заявка' END ORDER BY bs.flag_buy_sell) nflag_buy_sell
					FROM buy_sell bs, slov_categories sc
					WHERE bs.flag_buy_sell IN (1,2) AND bs.categories_id=sc.id
					GROUP BY bs.name, sc.categories
					UNION ALL
					SELECT 'Артикул' pole, 2 flag_pole, bsa.value, bs.categories_id,
						GROUP_CONCAT(DISTINCT bs.flag_buy_sell ORDER BY bs.flag_buy_sell) flag_search, sc.categories, COUNT(bsa.id) kol,
						GROUP_CONCAT(DISTINCT CASE WHEN bs.flag_buy_sell=1 THEN 'Объявление' ELSE 'Заявка' END ORDER BY bs.flag_buy_sell) nflag_buy_sell
					FROM buy_sell bs, buy_sell_attribute bsa, slov_attribute sa, slov_categories sc
					WHERE bsa.buy_sell_id=bs.id AND bs.categories_id=sc.id AND bsa.attribute_id=sa.id AND bsa.attribute_id=33
					GROUP BY bsa.value, sc.categories
					ORDER BY 7 DESC ";
			*/
		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}



	// Поисковый запрос
	function reqSearchCategories($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id'));

		$start_limit 	= (isset($p['start_limit'])&&v_int($p['start_limit']))? 	$p['start_limit'] : 0;

		if($in['id']){
			$sql = 'AND s.id=?';
			$arr = array($in['id']);
			$one = true;
		}


		$sql = "	SELECT s.id, s.name, s.categories_id, 
							sc.categories
					FROM search_categories s, slov_categories sc
					WHERE s.categories_id=sc.id ".$sql."
					ORDER BY s.id DESC LIMIT ".$start_limit." , 25
					";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}


	/*
		// Поисковый запрос
		function reqSearchRequest($p=array()) {
			$sql = '';
			$one = false;
			$arr = array();
			$in = fieldIn($p, array('id','value','kol','ipage','count_page'));
			$in['ipage'] = ($in['ipage'])? $in['ipage'] : 0;


			if($in['id']){
				$sql .= ' AND sr.id=? ';
				array_push($arr , $in['id']);
				$one = true;
				$in['count_page'] = 1;
			}
			if($in['value']){//часть наименования
				$sql .= " and LOWER(sr.value) LIKE ?";
				array_push($arr , '%'.$in['value'].'%');
			}

			$sql_select = " sr.id, sr.flag_pole, sr.categories_id, sr.value,
							CASE WHEN sr.flag_pole=1 THEN 'Наименование'
								WHEN sr.flag_pole=2 THEN 'Артикул'
							END nflag_pole,
							sc.categories ";

			$sql_ = "	SELECT {SQL_SELECT}
						FROM search_request sr, slov_categories sc
						WHERE sr.categories_id=sc.id ".$sql."
					";

			$sql_order 		= " ORDER BY sr.data_insert DESC LIMIT ".$in['ipage'].",".$in['count_page']." ";

			if($in['kol']==true){
				$sql_select = " COUNT(sr.id) kol ";
				$sql = str_replace('{SQL_SELECT}',$sql_select,$sql_);
				$one = true;
			}else{
				$sql = str_replace('{SQL_SELECT}',$sql_select,$sql_);
				$sql = $sql.$sql_order;
			}


			$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

			return $row;
		}
		*/


	// Поисковый запрос - Autocomplete
	function reqSearchRequestAutocomplete($p=array()) {
		$sql = $sql_union4 = $sql_union5 = $sql_union6 = $sql_union7 = $sql_union8 = $sql_union41 = '';
		$one = false;
		$arr = array();
		$in = fieldIn($p, array('value','flag','flag_buy_sell','categories_id','cities_id','where'));

		if($in['value']){//часть наименования
			$sql1 = " and ( LOWER(s.name) LIKE ? OR LOWER(s.name) LIKE ? OR LOWER(s.name) LIKE ? ) ";
			/*array_push($arr , '%'.$in['value'].'%');  УБРАЛ ВЕЗДЕ*/
			array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
			$sql2 = " and ( LOWER(sc.categories) LIKE ? OR LOWER(sc.categories) LIKE ? OR LOWER(sc.categories) LIKE ? ) ";
			array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
			$sql3 = " and ( LOWER(sav.attribute_value) LIKE ? OR LOWER(sav.attribute_value) LIKE ? OR LOWER(sav.attribute_value) LIKE ? ) ";
			array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
		}

		if($in['flag']=='modal'||$in['flag']=='top'||$in['flag']=='mainpage'){// вызываем, Поиск в Верху(и в модали) и на Главной
			if( $in['value'] && COMPANY_ID ){//часть наименования
				//$sql4 = " and LOWER(bs.name) LIKE ? ";
				/*
						$sql4 = " AND ( LOWER(bs.name) LIKE ? OR LOWER(bs.name) LIKE ? OR LOWER(bs.name) LIKE ? ) ";
						array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
						*/
				$sql5 = " and ( LOWER(c.company) LIKE ? OR LOWER(c.company) LIKE ? OR LOWER(c.company) LIKE ? ) ";
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
				$sql6 = " and ( LOWER(c.company) LIKE ? OR LOWER(c.company) LIKE ? OR LOWER(c.company) LIKE ? ) ";
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
				$sql7 = " and ( LOWER(c.company) LIKE ? OR LOWER(c.company) LIKE ? OR LOWER(c.company) LIKE ? ) ";
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
			}
			// Заявка/Объявление
			$sql_flag_buy_sell = '';
			if(v_int($in['flag_buy_sell'])){
				$sql_flag_buy_sell = " AND bs.flag_buy_sell=".$in['flag_buy_sell']." ";
			}

			// Если выбран город
			$sql_cities_id4 = $sql_cities_id5 = '';
			if( v_int($in['cities_id']) && $in['cities_id']>0 ){
				$sql_cities_id4 = " AND bs.cities_id=".$in['cities_id']." ";
				$sql_cities_id5 = " AND c.cities_id=".$in['cities_id']." ";
			}
			// Если выбрана категория
			$inner_join5 = '';
			if(v_int($in['categories_id'])&&$in['categories_id']>0){
				$inner_join5 = " INNER JOIN company_categories cc ON cc.company_id=c.id AND cc.categories_id=".$in['categories_id']." ";
			}

			if(COMPANY_ID){
				// Компании с выбранной категорией
				$sql_union5 = " 	UNION ALL
										(
										SELECT '', c.company,
												CASE WHEN c.flag_account=1 THEN 'Пользователь'
												WHEN c.flag_account=2 THEN 'Компания'
												END company,
												'',
												'',
												'' id_attribute,
												'' nomenclature_id,
												5 flag
										FROM company c
										".$inner_join5."
										WHERE c.flag_account IN (1,2) ".$sql_cities_id5." ".$sql5."	
										ORDER BY c.company LIMIT 1
										) ";
				// Компания с подпиской (на текущую компанию)
				$sql_union6 = " 	UNION ALL
										(
										SELECT '', c.company,
												CASE WHEN c.flag_account=1 THEN 'Пользователь'
												WHEN c.flag_account=2 THEN 'Компания'
												END company,
												'',
												'',
												'' id_attribute,
												'' nomenclature_id,
												6 flag
										FROM company c
										INNER JOIN subscriptions sub ON sub.company_id_out=c.id AND sub.company_id_in=".COMPANY_ID."
										".$inner_join5."
										WHERE c.flag_account IN (1,2) ".$sql_cities_id5." ".$sql6."	
										ORDER BY c.company LIMIT 1
										) ";
				// Компания(текущая) на которую подписаны
				$sql_union7 = " 	UNION ALL
										(
										SELECT '', c.company,
												CASE WHEN c.flag_account=1 THEN 'Пользователь'
												WHEN c.flag_account=2 THEN 'Компания'
												END company,
												'',
												'',
												'' id_attribute,
												'' nomenclature_id,
												7 flag
										FROM company c
										INNER JOIN subscriptions sub ON sub.company_id_in=c.id AND sub.company_id_out=".COMPANY_ID."
										".$inner_join5."
										WHERE c.flag_account IN (1,2) ".$sql_cities_id5." ".$sql7."	
										ORDER BY c.company LIMIT 1
										) ";
			}

			// Мои заявки
			$sql_dop = "";
			$flag_n 	= 40;		// по умолчанию
			$str_flag 	= '';		// по умолчанию
			$status_buy_sell_id = '1,2,3,4,11,12,14,15';
			//vecho($in['where']);
			$arr_w = explode('/',$in['where']);
			if(isset($arr_w[1])&&$arr_w[1]=='buy-sell'){
				$sql_flag_buy_sell = "";
				$sql_bs = " AND 1=2 ";
				if(isset($arr_w[2])&&$arr_w[2]=='buy'){
					$str_flag 			= 'Мои заявки';
					$str_company_id2	= 'Поставщик';
					$sql_flag_buy_sell 	= " AND bs.flag_buy_sell='2' ";
					$sql_bs 			= " AND bs.company_id=".COMPANY_ID." ";
				}elseif(isset($arr_w[2])&&$arr_w[2]=='sell'){
					$str_flag 			= 'Мои объявления';
					$str_company_id2	= 'Покупатель';
					$sql_bs 			= " AND ( (bs.flag_buy_sell=1 AND bs.company_id=".COMPANY_ID.")
														OR CASE WHEN bs.company_id2=".COMPANY_ID." AND bs.company_id2>0 THEN bs.flag_buy_sell IN (1,2) 
																														ELSE bs.company_id2=".COMPANY_ID." AND bs.flag_buy_sell IN (1) END
													) ";
				}

				// массив доп запросов
				$arr_sql_dop = array( 	11 => " 
														/*2 вложенность (наименование, имя заказа) копии в Куплено*/
														SELECT 'Наименование' attribute,
																CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END) attribute_value ,
																bs.data_insert

														FROM buy_sell bs, slov_categories sc
														WHERE 	sc.active=1 AND bs.categories_id=sc.id
																AND bs.id IN (	SELECT bs2.copy_id
																				FROM buy_sell bs2 
																				WHERE 	bs2.company_id='".COMPANY_ID."'
																						AND bs2.status_buy_sell_id IN (11) 
																						AND bs2.flag_buy_sell='".$in['flag_buy_sell']."'		
																			)
																".$sql_bs."
																AND bs.status_buy_sell_id IN (6)
																".$sql_flag_buy_sell."
																AND ( 		LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ? 
																		OR 	LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ? 
																		OR 	LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ?
																	)

														UNION ALL
														/*2*/

						
														/*2 вложенность (динамич.поля) копии в Куплено*/
														SELECT 	sa.attribute, 
																CASE WHEN bsa.attribute_value_id=0 THEN bsa.value 
																					ELSE avs.attribute_value END attribute_value ,
																bs.data_insert
														FROM slov_attribute sa, categories_attribute ca, slov_categories sc, buy_sell bs , buy_sell_attribute bsa 

														LEFT JOIN ( SELECT av.id, sav.attribute_value FROM attribute_value av, slov_attribute_value sav WHERE sav.id=av.attribute_value_id ) avs 
														ON avs.id=bsa.attribute_value_id 

														WHERE bsa.buy_sell_id=bs.id AND ca.categories_id=bs.categories_id AND sa.id=ca.attribute_id 
																AND bsa.attribute_id=ca.attribute_id AND (bsa.value<>'-' OR NOT avs.attribute_value IS NULL ) 
																AND sc.active=1 AND bs.categories_id=sc.id
																AND bs.id IN (	SELECT bs2.copy_id
																				FROM buy_sell bs2 
																				WHERE 	bs2.company_id='".COMPANY_ID."'
																						AND bs2.status_buy_sell_id IN (11) 
																						AND bs2.flag_buy_sell='".$in['flag_buy_sell']."'		
																			)
																			
																".$sql_bs."
																AND bs.status_buy_sell_id IN (6) 
																".$sql_flag_buy_sell."
																AND ( 		LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																													ELSE avs.attribute_value END) LIKE ? 
																		OR 	LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																													ELSE avs.attribute_value END) LIKE ? 
																		OR LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																													ELSE avs.attribute_value END) LIKE ? )
														UNION ALL
														/*2*/
														",
					12 => " 
														/*23 вложенность (наименование, имя заказа) копии в Исполненные*/
														SELECT 'Наименование' attribute,
																CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END) attribute_value ,
																bs.data_insert

														FROM buy_sell bs, slov_categories sc
														WHERE 	sc.active=1 AND bs.categories_id=sc.id
																AND bs.id IN (	SELECT IFNULL(bs2.parent_id,0)
																				FROM buy_sell bs2 
																				WHERE 	bs2.company_id='".COMPANY_ID."'
																						AND bs2.status_buy_sell_id IN (12) 
																						AND bs2.flag_buy_sell='".$in['flag_buy_sell']."'		
																			)
																".$sql_bs."
																AND bs.status_buy_sell_id IN (6)
																".$sql_flag_buy_sell."
																AND ( 		LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ? 
																		OR 	LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ? 
																		OR 	LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ?
																	)
														UNION ALL
														
														SELECT 'Наименование' attribute,
																CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END) attribute_value ,
																bs.data_insert

														FROM buy_sell bs, slov_categories sc
														WHERE 	sc.active=1 AND bs.categories_id=sc.id
																AND bs.id IN (	SELECT IFNULL(bs2.copy_id,0)
																				FROM buy_sell bs2 
																				WHERE 	bs2.company_id='".COMPANY_ID."'
																						AND bs2.status_buy_sell_id IN (12) 
																						AND bs2.flag_buy_sell='".$in['flag_buy_sell']."'		
																			)
																".$sql_bs."
																AND bs.status_buy_sell_id IN (6)
																".$sql_flag_buy_sell."
																AND ( 		LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ? 
																		OR 	LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ? 
																		OR 	LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ?
																	)
																	
														UNION ALL
														/*23*/
												
												
														
														
														/*2 вложенность (динамич.поля) купленных в исполненные*/
														SELECT 	sa.attribute, 
																CASE WHEN bsa.attribute_value_id=0 THEN bsa.value 
																					ELSE avs.attribute_value END attribute_value ,
																bs.data_insert
														FROM slov_attribute sa, categories_attribute ca, slov_categories sc, buy_sell bs , buy_sell_attribute bsa 

														LEFT JOIN ( SELECT av.id, sav.attribute_value FROM attribute_value av, slov_attribute_value sav WHERE sav.id=av.attribute_value_id ) avs 
														ON avs.id=bsa.attribute_value_id 

														WHERE bsa.buy_sell_id=bs.id AND ca.categories_id=bs.categories_id AND sa.id=ca.attribute_id 
																AND bsa.attribute_id=ca.attribute_id AND (bsa.value<>'-' OR NOT avs.attribute_value IS NULL ) 
																AND sc.active=1 AND bs.categories_id=sc.id
																AND bs.id IN (	SELECT IFNULL(bs2.parent_id,0)
																				FROM buy_sell bs2 
																				WHERE 	bs2.company_id='".COMPANY_ID."'
																						AND bs2.status_buy_sell_id IN (12) 
																						AND bs2.flag_buy_sell='".$in['flag_buy_sell']."'		
																			)
																			
																".$sql_bs."
																AND bs.status_buy_sell_id IN (11) 
																".$sql_flag_buy_sell."
																AND ( 		LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																													ELSE avs.attribute_value END) LIKE ? 
																		OR 	LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																													ELSE avs.attribute_value END) LIKE ? 
																		OR LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																													ELSE avs.attribute_value END) LIKE ? )
														UNION ALL
														/*2*/
														
														/*3 вложенность копии в исполненные*/
														SELECT 	sa.attribute, 
																CASE WHEN bsa.attribute_value_id=0 THEN bsa.value 
																					ELSE avs.attribute_value END attribute_value ,
																bs.data_insert
														FROM slov_attribute sa, categories_attribute ca, slov_categories sc, buy_sell bs , buy_sell_attribute bsa 

														LEFT JOIN ( SELECT av.id, sav.attribute_value FROM attribute_value av, slov_attribute_value sav WHERE sav.id=av.attribute_value_id ) avs 
														ON avs.id=bsa.attribute_value_id 

														WHERE bsa.buy_sell_id=bs.id AND ca.categories_id=bs.categories_id AND sa.id=ca.attribute_id 
																AND bsa.attribute_id=ca.attribute_id AND (bsa.value<>'-' OR NOT avs.attribute_value IS NULL ) 
																AND sc.active=1 AND bs.categories_id=sc.id
																AND bs.id IN (	SELECT IFNULL(bs2.copy_id,0)
																				FROM buy_sell bs2 
																				WHERE 	bs2.company_id='".COMPANY_ID."'
																						AND bs2.status_buy_sell_id IN (12) 
																						AND bs2.flag_buy_sell='".$in['flag_buy_sell']."'		
																			)
																			
																".$sql_bs."
																AND bs.status_buy_sell_id IN (6) 
																".$sql_flag_buy_sell."
																AND ( 		LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																													ELSE avs.attribute_value END) LIKE ? 
																		OR 	LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																													ELSE avs.attribute_value END) LIKE ? 
																		OR LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																													ELSE avs.attribute_value END) LIKE ? )
														UNION ALL
														/*3*/

														"

				);



				$flag_n = isset($arr_w[3])?  $arr_w[3] : 40;
				if($flag_n==40){
					$sql_dop = implode(' ',$arr_sql_dop);
					/*2куплено*/
					array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
					array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
					/*2куплено*/
					/*2и3исполнено*/
					array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
					array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
					array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
					array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
					/*2и3исполнено*/
				}elseif($flag_n==1){
					$flag_n = 41;
					$status_buy_sell_id = 1;
					$str_flag 	= 'Не опубликованные';
				}elseif($flag_n==2){
					$flag_n = 42;
					$status_buy_sell_id = 2;
					$str_flag 	= 'Опубликованные';
				}elseif($flag_n==3){
					$flag_n = 43;
					$status_buy_sell_id = 3;
					$str_flag 	= 'Активные';
				}elseif($flag_n==4){
					$flag_n = 44;
					$status_buy_sell_id = 4;
					$str_flag 	= 'Архив';
				}elseif($flag_n==11){
					$flag_n = 411;
					$status_buy_sell_id = 11;
					$str_flag 	= 'Куплено';
					$sql_dop = $arr_sql_dop[11];
					/*2куплено*/
					array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
					array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
					/*2куплено*/
				}elseif($flag_n==12){
					$flag_n = 412;
					$status_buy_sell_id = 12;
					$str_flag 	= 'Исполнено';
					$sql_dop = $arr_sql_dop[12];
					/*2и3исполнено*/
					array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
					array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
					array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
					array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
					/*2и3исполнено*/
				}elseif($flag_n==14){
					$flag_n = 414;
					$status_buy_sell_id = 14;
					$str_flag 	= 'Возврат';
				}elseif($flag_n==15){
					$flag_n = 415;
					$status_buy_sell_id = 15;
					$str_flag 	= 'Возвращено';
				}

				$sql_union41 = " 	UNION ALL
								(
								SELECT DISTINCT
										0 categories_id, '".$in['value']."' `value`, 
										qw.attribute nflag_pole,
										'".$str_flag."',
										'',
										'' id_attribute,
										'' nomenclature_id,
										".$flag_n." flag
								
								FROM (
									SELECT 'Наименование' attribute,
											CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END) attribute_value ,
											bs.data_insert

									FROM buy_sell bs, slov_categories sc
									WHERE 	sc.active=1 AND bs.categories_id=sc.id
											".$sql_bs."
											AND bs.status_buy_sell_id IN (".$status_buy_sell_id.")
											".$sql_flag_buy_sell."
											AND ( 		LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ? 
													OR 	LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ? 
													OR 	LOWER(CONCAT(bs.name, ' ', bs.comments, ' ', CASE WHEN bs.comments_company IS NULL THEN '' ELSE bs.comments_company END)) LIKE ?
												)

									UNION ALL

									SELECT 	sa.attribute, 
											CASE WHEN bsa.attribute_value_id=0 THEN bsa.value 
																ELSE avs.attribute_value END attribute_value ,
											bs.data_insert
									FROM slov_attribute sa, categories_attribute ca, slov_categories sc, buy_sell bs , buy_sell_attribute bsa 

									LEFT JOIN ( SELECT av.id, sav.attribute_value FROM attribute_value av, slov_attribute_value sav WHERE sav.id=av.attribute_value_id ) avs 
									ON avs.id=bsa.attribute_value_id 

									WHERE bsa.buy_sell_id=bs.id AND ca.categories_id=bs.categories_id AND sa.id=ca.attribute_id 
											AND bsa.attribute_id=ca.attribute_id AND (bsa.value<>'-' OR NOT avs.attribute_value IS NULL ) 
											AND sc.active=1 AND bs.categories_id=sc.id
											".$sql_bs."
											AND bs.status_buy_sell_id IN (".$status_buy_sell_id.") 
											".$sql_flag_buy_sell."
											AND ( 		LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																								ELSE avs.attribute_value END) LIKE ? 
													OR 	LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																								ELSE avs.attribute_value END) LIKE ? 
													OR LOWER(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value
																								ELSE avs.attribute_value END) LIKE ? )
									
									UNION ALL
									
									
									".$sql_dop."
									
									
									SELECT 	'".$str_company_id2."' attribute,
											c.company attribute_value ,
											bs.data_insert

									FROM buy_sell bs, slov_categories sc, company c
									WHERE 	sc.active=1 AND bs.categories_id=sc.id
											".$sql_bs."
											AND bs.company_id2=c.id
											AND bs.status_buy_sell_id IN (".$status_buy_sell_id.") 
											".$sql_flag_buy_sell."
											
											AND ( LOWER(c.company) LIKE ? OR LOWER(c.company) LIKE ? OR LOWER(c.company) LIKE ? )
									
									UNION ALL
									
									SELECT 	'Ответственный' attribute,
											c.company attribute_value ,
											bs.data_insert

									FROM buy_sell bs, slov_categories sc, company c
									WHERE 	sc.active=1 AND bs.categories_id=sc.id
											".$sql_bs."
											AND bs.responsible_id=c.id
											AND bs.status_buy_sell_id IN (".$status_buy_sell_id.") 
											".$sql_flag_buy_sell."
											
											AND ( LOWER(c.company) LIKE ? OR LOWER(c.company) LIKE ? OR LOWER(c.company) LIKE ? )
											
								) qw

								WHERE 1=1
										AND ( LOWER(qw.attribute_value) LIKE ? OR LOWER(qw.attribute_value) LIKE ? OR LOWER(qw.attribute_value) LIKE ? )
								ORDER BY qw.data_insert DESC LIMIT 4
								) ";

				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');

			}elseif(isset($arr_w[1])&&$arr_w[1]=='nomenclature'){

				$flag_n = 50;


				$sql_union41 = " 	UNION ALL
									(
									SELECT DISTINCT
											0 categories_id, '".$in['value']."' `value`, 
											qw.attribute nflag_pole,
											'Номенклатура',
											'',
											'' id_attribute,
											'' nomenclature_id,
											".$flag_n." flag
									
									FROM (
										SELECT 'Наименование' attribute,
												n.name attribute_value ,
												n.data_insert

										FROM nomenclature n, slov_categories sc
										WHERE 	sc.active=1 AND n.categories_id=sc.id
												AND ( 		LOWER(n.name) LIKE ? 
														OR 	LOWER(n.name) LIKE ? 
														OR 	LOWER(n.name) LIKE ?
													)

										UNION ALL

										SELECT 	sa.attribute, 
												CASE WHEN na.attribute_value_id=0 THEN na.value 
																	ELSE avs.attribute_value END attribute_value ,
												n.data_insert
										FROM slov_attribute sa, categories_attribute ca, slov_categories sc, nomenclature n , nomenclature_attribute na 

										LEFT JOIN ( SELECT av.id, sav.attribute_value FROM attribute_value av, slov_attribute_value sav WHERE sav.id=av.attribute_value_id ) avs 
												ON avs.id=na.attribute_value_id 

										WHERE na.nomenclature_id=n.id AND ca.categories_id=n.categories_id AND sa.id=ca.attribute_id 
												AND na.attribute_id=ca.attribute_id AND (na.value<>'-' OR NOT avs.attribute_value IS NULL ) 
												AND sc.active=1 AND n.categories_id=sc.id
												AND ( 		LOWER(CASE WHEN na.attribute_value_id=0 THEN na.value
																									ELSE avs.attribute_value END) LIKE ? 
														OR 	LOWER(CASE WHEN na.attribute_value_id=0 THEN na.value
																									ELSE avs.attribute_value END) LIKE ? 
														OR LOWER(CASE WHEN na.attribute_value_id=0 THEN na.value
																									ELSE avs.attribute_value END) LIKE ? )
										
										
									) qw

									WHERE 1=1
											AND ( LOWER(qw.attribute_value) LIKE ? OR LOWER(qw.attribute_value) LIKE ? OR LOWER(qw.attribute_value) LIKE ? )
									ORDER BY qw.data_insert DESC LIMIT 4
									) ";

				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');


			}elseif(isset($arr_w[1])&&$arr_w[1]=='subscriptions'){

				$flag_n = 60;


				$sql_union41 = " 	UNION ALL
									(
										SELECT DISTINCT	0 categories_id, '".$in['value']."' `value`, 
											'Пользователи' nflag_pole,
											'',
											'',
											'' id_attribute,
											'' nomenclature_id,
											60 flag

										FROM company c
										WHERE 	1=1
												AND ( LOWER(c.company) LIKE ? OR LOWER(c.company) LIKE ? OR LOWER(c.company) LIKE ? )
										
										ORDER BY c.data_insert DESC LIMIT 4
										
									) ";

				array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');

			}
			//vecho($sql_union41);
		}

		// Номенклатура - для Заявок, Активы, Склад
		if( ($in['flag_buy_sell']==4) || ($in['flag_buy_sell']==5) || (($in['flag_buy_sell']==2)&&$in['flag']=='buy_sell')){// При создании заявки
			/*$sql_union8 = " 	UNION ALL
										(
										SELECT n.categories_id, n.name,
												'Номенклатура',
												'',
												'' id_attribute,
												n.id nomenclature_id,
												8 flag
										FROM nomenclature n
										WHERE n.company_id=".COMPANY_ID."
												AND LOWER(n.name) LIKE ?
										ORDER BY n.name LIMIT 2
										) ";*/
			$sql_union8 = " 	UNION ALL
										(
										SELECT n.categories_id, n.name,
												'Номенклатура',
												'',
												'',
												'' id_attribute,
												n.id nomenclature_id,
												8 flag
										FROM nomenclature n
										WHERE n.company_id=".COMPANY_ID."
												AND ( LOWER(n.name) LIKE ? OR LOWER(n.name) LIKE ? OR LOWER(n.name) LIKE ? )
										ORDER BY 2 LIMIT 2
										)
										UNION ALL
										(
										SELECT n.categories_id, n.name,
												'Номенклатура Артикул',
												'',
												'',
												'' id_attribute,
												n.id nomenclature_id,
												8 flag
										FROM nomenclature n , nomenclature_attribute na
										WHERE n.company_id=".COMPANY_ID." AND na.nomenclature_id=n.id AND na.attribute_id=33
												
												AND (  LOWER(na.value) LIKE ? OR LOWER(na.value) LIKE ? )
										ORDER BY 2 LIMIT 2
										) ";
			/*array_push($arr , '%'.$in['value'].'%');*/
			array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
			array_push($arr , ''.$in['value'].'%'); array_push($arr , '%/'.$in['value'].'%');
		}

		$sql_slov_categories = '';
		if($in['flag']=='buy_sell'){
			$sql_slov_categories = " AND sc.level=3 ";
		}

		$sql = "	SELECT *
					FROM (
						(SELECT s.categories_id, s.name `value`, 'Наименование' nflag_pole,
							sc.categories,
							'' categories_2,
							'' id_attribute,
							s.id nomenclature_id,
							21 flag
						FROM search_categories s, slov_categories sc
						WHERE sc.active=1 AND s.categories_id=sc.id ".$sql1."
						ORDER BY s.data_insert DESC LIMIT 4)

						UNION ALL 
						(SELECT sc.id, sc.categories categories4,
							'Категория',
							(	SELECT (SELECT tt.categories 
										FROM slov_categories tt 
										WHERE tt.id=t.parent_id)
								FROM slov_categories t 
								WHERE t.id=sc.parent_id
							) categories,
							'',
							'' id_attribute,
							'' nomenclature_id,
							22 flag
						FROM slov_categories sc
						WHERE sc.active=1 ".$sql_slov_categories." ".$sql2."
						ORDER BY sc.categories LIMIT 4)
						UNION ALL
						(SELECT av.categories_id, sav.attribute_value, 'Тип',
							sc.categories, 
							(SELECT (SELECT tt.categories 
									FROM slov_categories tt 
									WHERE tt.id=t.parent_id) 
							FROM slov_categories t 
							WHERE t.id=sc.parent_id) categories_2,
							av.id id_attribute,
							'' nomenclature_id,
							23 flag
						FROM attribute_value av, slov_attribute_value sav, slov_categories sc
						WHERE sc.active=1 AND av.categories_id=sc.id AND av.attribute_id=23 AND av.attribute_value_id=sav.id
								".$sql3."
						ORDER BY sav.attribute_value LIMIT 4)
						
						
						".$sql_union5."
						
						".$sql_union6."
						
						".$sql_union7."
						
						".$sql_union8."
						
						".$sql_union41."
						
					) qw
					WHERE 1=1 ".$sql." ";


		$row = PreExecSQL_all($sql,$arr);

		return $row;
	}

	/*
		// Поисковый запрос для АДМИНКИ (для подсветки выбранных словосочетаний)
		function reqSearchRequestAdminSearch($p=array()) {

			$sql = "	SELECT sr.id
					FROM search_request sr
					WHERE sr.flag_pole='".$p['flag_pole']."' and sr.categories_id='".$p['categories_id']."' and sr.value='".$p['value']."'
				";

			$row = PreExecSQL_one($sql,array());

			return $row;
		}
		*/

	// Подписки
	function reqSubscriptions($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','company_id_in','company_id_out','one','kol'));
		if($in['company_id_in']){
			$sql .= ' AND s.company_id_in=? ';
			array_push($arr , $in['company_id_in']);
		}
		if($in['company_id_out']){
			$sql .= ' AND s.company_id_out=? ';
			array_push($arr , $in['company_id_out']);
		}
		if($in['one']){
			$one = true;
		}

		$sql_select = " s.id, s.company_id_in, s.company_id_out ";

		$sql_ = "	SELECT {SQL_SELECT}
						FROM subscriptions s
						WHERE 1=1 ".$sql."
					";

		$sql_order 		= " ";

		if($in['kol']==true){
			$sql_select = " COUNT(s.id) kol ";
			$sql = str_replace('{SQL_SELECT}',$sql_select,$sql_);
			$one = true;
		}else{
			$sql = str_replace('{SQL_SELECT}',$sql_select,$sql_);
			$sql = $sql.$sql_order;
		}


		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Подписка если не авторизован
	function reqSubscriptionsNoAutorize($p=array()) {

		$sql = "	SELECT s.id, s.company_id_from
					FROM subscriptions_no_autorize s
					WHERE s.cookie_session='".$p['cookie_session']."'
				";

		$row = PreExecSQL_one($sql,array());

		return $row;
	}


	// Оповещение
	function reqSlovNotification($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','login_id','company_id','page_id'));
		$in['login_id']		= ($in['login_id'])? 	$in['login_id'] 		: LOGIN_ID;
		$in['company_id']	= ($in['company_id'])? 	$in['company_id'] 	: COMPANY_ID;
		$in['page_id'] 		= ($in['page_id'])? 		$in['page_id'] 		: 0;

		if($in['id']){
			$sql .= ' AND sn.id=? ';
			array_push($arr , $in['id']);
			$one = true;
		}

		$sql = "	SELECT sn.id, sn.parent_id, sn.notification,
							n1.notification_param_id notification_param_id1, 
							n2.notification_param_id notification_param_id2,
							(
							SELECT 	TIMESTAMPDIFF(SECOND,pvs.data_last_send_email,NOW()) flag_data_last_send_email /* 86400 - одни сутки */
							FROM company_page_visited_send pvs
							WHERE pvs.login_id=".$in['login_id']." AND pvs.company_id=".$in['company_id']." AND pvs.page_id=".$in['page_id']."
							) flag_data_last_send_email
					FROM slov_notification sn
					LEFT JOIN notification_company_param n1 ON n1.notification_id=sn.id AND n1.flag=1 AND n1.login_id=".$in['login_id']." AND n1.company_id=".$in['company_id']."
					LEFT JOIN notification_company_param n2 ON n2.notification_id=sn.id AND n2.flag=2 AND n2.login_id=".$in['login_id']." AND n2.company_id=".$in['company_id']."
					WHERE 1=1 ".$sql."
					ORDER BY sn.sort ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}


	// Оповещение - параметры (наступление события)
	function reqSlovNotificationParam($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		//$in = fieldIn($p, array('id'));

		$sql = "	SELECT snp.id, snp.notification_param
					FROM slov_notification_param snp ";

		$row = PreExecSQL_all($sql,$arr);

		return $row;
	}
	/*
		// Оповещение - параметры (наступление события)
		function reqNotification($p=array()) {
			$sql = '';
			$arr = array();
			$one = false;
			$in = fieldIn($p, array('notification_id','company_id','tid'));

			$sql = ' AND n.notification_id=? AND n.company_id=? AND n.tid=? ';
			$arr = array($in['notification_id'],$in['company_id'],$in['tid']);

			$sql = "	SELECT n.id, n.notification_id, n.company_id, n.tid
					FROM notification n
					WHERE 1=1 ".$sql."	";

			$row = PreExecSQL_one($sql,$arr);

			return $row;
		}
		*/

	// настройки уведомления пользователя на сайте "о новых заявках" и "о новых срочных заявках"
	function reqNotificationParamId_1011($p=array()) {
		$sql = "	SELECT 
					(
					SELECT n1.notification_param_id FROM notification_company_param n1 WHERE n1.flag=1 AND n1.login_id=".LOGIN_ID." AND n1.company_id=".COMPANY_ID." AND n1.notification_id=10
					) notification_param_id_10,
					(
					SELECT n2.notification_param_id FROM notification_company_param n2 WHERE n2.flag=1 AND n2.login_id=".LOGIN_ID." AND n2.company_id=".COMPANY_ID." AND n2.notification_id=11
					) notification_param_id_11 ";
		$row = PreExecSQL_one($sql,array());

		return $row;
	}


	// Insert - Уведомление (оповещение)
	function reqInsertNotification($in=array()) {
		$STH = false;
		$in['login_id']			= isset($in['login_id'])? 				$in['login_id'] 			: LOGIN_ID;
		$in['company_id']		= isset($in['company_id'])? 				$in['company_id'] 		: COMPANY_ID;
		$in['notification_id'] 	= isset($in['notification_id'])? 		$in['notification_id'] 	: 0;
		$in['tid'] 				= isset($in['tid'])? 					$in['tid'] 				: 0;

		if($in['notification_id']&&$in['tid']){

			$STH = PreExecSQL(" INSERT INTO notification (notification_id,login_id,company_id,tid) VALUES (?,?,?,?); " ,
				array( $in['notification_id'],$in['login_id'],$in['company_id'],$in['tid'] ));

		}

		return array('STH'=>$STH);
	}

	// Delete - Уведомление (оповещение)
	function reqDeleteNotification($in=array()) {
		$STH = $sql_tid = false;


		$in['notification_id'] 	= isset($in['notification_id'])? 		$in['notification_id'] 	: 0;
		$in['tid'] 				= isset($in['tid'])? 					$in['tid'] 				: 0;

		if($in['notification_id']){

			if($in['tid']){
				$sql_tid = " AND tid IN (".$in['tid'].") ";
			}

			$STH = PreExecSQL(" DELETE FROM notification WHERE notification_id=? AND login_id=? AND company_id=? ".$sql_tid."; " ,
				array( $in['notification_id'],LOGIN_ID,COMPANY_ID ));

		}

		return array('STH'=>$STH);
	}


	// Оповещение - левое меню
	function reqNotificationMenu($in=array()) {

		if($in['id']==8){
			/*
				$sql = "	SELECT COUNT(DISTINCT bs.parent_id) kol FROM buy_sell bs
						WHERE bs.id IN (SELECT t.tid FROM notification t
										WHERE t.notification_id=2 AND t.company_id=".COMPANY_ID." )  ";
				*/
			$sql = "	SELECT 	COUNT(DISTINCT bs.parent_id)
								+
								(
								SELECT COUNT(t.tid) kol
								FROM notification t 
								WHERE t.notification_id IN (3) AND t.login_id=".LOGIN_ID." AND t.company_id=".COMPANY_ID."
								) kol
						FROM buy_sell bs
						WHERE bs.id IN (
										SELECT bs1.id FROM buy_sell bs1
										WHERE bs1.id IN (
												SELECT bs.parent_id FROM buy_sell bs
												WHERE bs.id IN (SELECT t.tid FROM notification t 
														WHERE t.notification_id=2 AND t.login_id=".LOGIN_ID." AND t.company_id=".COMPANY_ID." )
												)
											AND bs1.status_buy_sell_id<>5 
									)  ";
			$row = PreExecSQL_one($sql,array());
		}elseif($in['id']==9){
			$sql = "	SELECT COUNT(t.tid) kol
						FROM notification t 
						WHERE t.notification_id IN (5,6,7,8) AND t.login_id=".LOGIN_ID." AND t.company_id=".COMPANY_ID." ";

			$row = PreExecSQL_one($sql,array());
		}elseif($in['id']==5){
			$sql = "	SELECT COUNT(t.tid) kol
						FROM notification t 
						WHERE t.notification_id=13 AND t.login_id=".LOGIN_ID." AND t.company_id=".COMPANY_ID." ";

			$row = PreExecSQL_one($sql,array());
		}elseif($in['id']==1011){// о новых заявка (или срочных)
			$sql_dop = '';
			$r = reqNotificationParamId_1011();
			// если в настройках пользователь указал "о новых срочных заявках"
			if( $r['notification_param_id_10']==3 && (!$r['notification_param_id_11']||$r['notification_param_id_11']==1) ){
				$sql_dop = ' AND bs.urgency_id=1 ';
			}

			if( !$r['notification_param_id_10']||$r['notification_param_id_10']==1|| !$r['notification_param_id_11']||$r['notification_param_id_11']==1 ){

				$sql = "	SELECT COUNT(bs.id) kol FROM buy_sell bs
								WHERE 	bs.company_id<>".COMPANY_ID."
										".$sql_dop."
										AND (	bs.status_buy_sell_id IN (3)
												OR ( bs.status_buy_sell_id IN (2) AND bs.company_id IN ( SELECT t.company_id_out FROM subscriptions t WHERE t.company_id_in=".COMPANY_ID." ) ) 
										) 
										AND bs.data_status_buy_sell_23>(SELECT pvs.data_visited 
																		FROM company_page_visited_send pvs 
																		WHERE pvs.page_id=1 AND pvs.login_id=".LOGIN_ID." AND pvs.company_id=".COMPANY_ID.") ";

				$row = PreExecSQL_one($sql,array());

			}else{
				$row['kol'] = 0;
			}
		}



		return $row['kol'];
	}


	// Добавляем - Id новой завки , чтобы через крон по ней отправить оповещение
	function reqInsertСronNewBuysell($in=array()) {

		$STH = PreExecSQL(" INSERT INTO cron_new_buysell (buy_sell_id) VALUES (?); " ,
			array( $in['buy_sell_id'] ));


		return array('STH'=>$STH);
	}

	// Удаляем - Посещение пользователем страницы
	function reqDeleteCompanyPageVisitedSend($in=array()) {
		$STH = false;
		$in['login_id'] 		= (isset($in['login_id'])&&!empty($in['login_id']))? 		$in['login_id'] 		: LOGIN_ID;
		$in['company_id'] 	= (isset($in['company_id'])&&!empty($in['company_id']))? 	$in['company_id'] 	: COMPANY_ID;

		$STH = PreExecSQL(" DELETE FROM company_page_visited_send WHERE page_id=? AND login_id=? AND company_id=?; " ,
			array( $in['page_id'],$in['login_id'],$in['company_id'] ));

		return array('STH'=>$STH);
	}


	// Добавляем - Посещение пользователем страницы
	function reqInsertCompanyPageVisitedSend($in=array()) {
		$STH = false;
		$in['login_id'] 					= (isset($in['login_id'])&&!empty($in['login_id']))? 			$in['login_id'] 				: LOGIN_ID;
		$in['company_id'] 				= (isset($in['company_id'])&&!empty($in['company_id']))? 		$in['company_id'] 			: COMPANY_ID;
		$in['data_visited']				= isset($in['data_visited'])? 								$in['data_visited']			: 'NULL';
		$in['data_last_send_email'] 		= isset($in['data_last_send_email'])? 						$in['data_last_send_email']	: 'NULL';

		if(COMPANY_ID){
			$STH = PreExecSQL(" INSERT INTO company_page_visited_send (login_id,company_id,page_id,data_visited,data_last_send_email) VALUES (?,?,?,".$in['data_visited'].",".$in['data_last_send_email']."); " ,
				array( $in['login_id'],$in['company_id'],$in['page_id'] ));
		}


		return array('STH'=>$STH);
	}


	// Интересы - задаваемые параметры
	function SlovInterestsParam($p=array()) {
		$arr = array();

		$sql = "	SELECT sip.id, sip.interests_param
					FROM slov_interests_param sip
					";

		$row = PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Интересы
	function reqInterestsCompanyParam($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','company_id'));
		$in['company_id'] = ($in['company_id'])? $in['company_id'] : COMPANY_ID;


		if($in['id']){
			$sql .= ' AND sn.id=? ';
			array_push($arr , $in['id']);
			$one = true;
		}



		$sql = "	SELECT icp.id, icp.company_id, icp.interests_id, icp.interests_param_id, icp.tid
					FROM interests_company_param icp
					WHERE icp.company_id=".$in['company_id']." ".$sql."
					";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Интересы - выбираем последнее значение interests_id
	function reqInterestsCompanyParamMaxInterestsId() {

		$sql = "	SELECT IFNULL(MAX(t.interests_id)+1,1) interests_id FROM interests_company_param t ";

		$row = PreExecSQL_one($sql,array());

		return $row;
	}

	// Интересы - есть ли выбран хоть один интерес
	function reqInterestsCompanyParamByOneInterest() {

		$sql = "	SELECT COUNT(icp.id) kol
					FROM interests_company_param icp
					WHERE icp.company_id=".COMPANY_ID." ";

		$row = PreExecSQL_one($sql,array());

		return $row;
	}

	// Интересы - interests_id условия компаний
	function reqInterestsCompanyParamGroupInterestsId($p=array()) {
		$sql = '';

		$p['company_id'] 	= isset($p['company_id'])? 		$p['company_id'] 	: COMPANY_ID;
		$p['login_id'] 		= isset($p['login_id'])? 		$p['login_id'] 		: '';
		$p['interests_id'] 	= isset($p['interests_id'])? 	$p['interests_id'] 	: '';


		$sql = '';
		if($p['login_id']){
			$sql .= ' AND icp.login_id='.$p['login_id'].' ';
		}


		if($p['interests_id']){
			$sql .= ' AND icp.interests_id='.$p['interests_id'].' ';
		}


		$sql = "	SELECT icp.interests_id
					FROM interests_company_param icp
					WHERE icp.company_id=".$p['company_id']." AND icp.flag=".$p['flag']."
							".$sql."
					GROUP BY icp.interests_id ";

		$row = PreExecSQL_all($sql,array());

		return $row;
	}

	// Интересы - interests_id условия компаний
	function reqInterestsCompanyParamGroupInterestsParamId($p=array()) {
		$in = fieldIn($p, array('company_id','interests_id'));

		$in['company_id'] = ($in['company_id'])? $in['company_id'] : COMPANY_ID;
		$p['login_id'] 		= isset($p['login_id'])? $p['login_id'] : '';

		$sql = '';
		if($p['login_id']){
			$sql = ' AND icp.login_id='.$p['login_id'].' ';
		}

		$arr = array($in['company_id'],$in['interests_id']);

		$sql = "	SELECT icp.interests_param_id, sip.sql_value
					FROM interests_company_param icp, slov_interests_param sip
					WHERE icp.interests_param_id=sip.id AND icp.company_id=? AND icp.interests_id=?
							".$sql."
					GROUP BY icp.interests_param_id, sip.sql_value ";

		$row = PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Интересы - выбранные значения компанией
	function reqInterestsCompanyParamTid($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('company_id','interests_id','interests_param_id','views'));
		$in['company_id'] = ($in['company_id'])? $in['company_id'] : COMPANY_ID;

		$arr = array($in['company_id'],$in['interests_id'],$in['interests_param_id']);

		if($in['views']){
			$sql .= ' AND icp.views=? ';
			array_push($arr , $in['views']);
		}


		$sql = "	SELECT icp.tid
					FROM interests_company_param icp
					WHERE icp.company_id=? AND icp.interests_id=? AND icp.interests_param_id=?
							".$sql."
					";

		$row = PreExecSQL_all($sql,$arr);

		return $row;
	}


	// Поделиться
	function reqBuySellShare($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('share_url'));

		if($in['share_url']){
			$sql .= ' AND bss.share_url=? ';
			array_push($arr , $in['share_url']);
			$one = true;
		}else{
			$sql .= ' AND 1=2 ';
			$one = true;
		}

		$sql = "	SELECT bss.id, bss.company_id_to, bss.email, bss.share_url, bss.name, bss.comments, bss.company_id_from 
					FROM buy_sell_share bss
					WHERE 1=1 ".$sql."
					";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Приглашенные сотрудники
	function reqWorkerByProfile($p=array()) {

		$sql = "	SELECT 1 flag, lcp.id, l.email, c.phone, c.company, lcp.position, lcp.prava_id,
							CASE WHEN c.avatar IS NULL OR c.avatar='' THEN 
														CASE WHEN c.flag_account=1 THEN '/image/profile-icon.png' ELSE '/image/profile-logo.png' END 
																	ELSE c.avatar END avatar
					FROM login_company_prava lcp, login l, company c
					WHERE lcp.login_id=l.id AND c.login_id=l.id AND l.id<>".LOGIN_ID."
							AND c.flag_account=1 AND lcp.company_id=".COMPANY_ID."
					
					UNION ALL

					SELECT 2 flag, iw.id, iw.email, '' phone, iw.name, iw.position, iw.prava_id,
							'/image/profile-icon.png' avatar
					FROM invite_workers iw
					WHERE iw.company_id=".COMPANY_ID."
						
					ORDER BY 5
					";

		$row = PreExecSQL_all($sql,array());

		return $row;
	}

	// Сотрудники добавленные , но не зарегистрированые
	function reqInviteWorkers($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','email'));

		if($in['id']){
			$sql = 'AND iw.id=?';
			$arr = array($in['id']);
			$one = true;
		}
		if($in['email']){
			$sql .= ' and email=?';
			array_push($arr , $in['email']);
		}

		if(!$sql){
			$sql = " AND 1=2 ";
		}

		$sql = "	SELECT iw.id, iw.company_id, iw.email, iw.name, iw.position, iw.prava_id
					FROM invite_workers iw
					WHERE 1=1 ".$sql."
					";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}


	// Autocomplete - Имя заказа
	function reqAutocompleteCommentsCompany($p=array()){
		$sql = '';
		$in = fieldIn($p, array('flag_buy_sell'));
		$arr = array();


		if($in['flag_buy_sell']){
			$sql .= ' AND bs.flag_buy_sell=? ';
			array_push($arr , $in['flag_buy_sell']);
		}

		if($p['value']){//часть наименования
			$sql .= " and LOWER(bs.comments_company) LIKE ?";
			array_push($arr , '%'.$p['value'].'%');
		}


		$sql = "	SELECT bs.comments_company 
					FROM buy_sell bs 
					WHERE bs.company_id=".COMPANY_ID."  ".$sql."
					GROUP BY bs.comments_company LIMIT 10 ";

		$row = PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Autocomplete - Ответственный
	function reqAutocompleteResponsible($p=array()){
		$sql = '';
		//$in = fieldIn($p, array('value'));
		$arr = array();

		if($p['value']){//часть наименования
			$sql .= " and LOWER(c.company) LIKE ?";
			array_push($arr , '%'.$p['value'].'%');
			array_push($arr , '%'.$p['value'].'%');
		}


		$sql = "	SELECT c.id, c.company
					FROM login_company_prava lcp, login l, company c
					WHERE lcp.login_id=l.id AND c.login_id=l.id AND l.id<>".LOGIN_ID."
							AND c.flag_account=1 AND lcp.company_id=".COMPANY_ID."
							".$sql."
					UNION ALL
					SELECT c.id, c.company
					FROM company c
					WHERE c.login_id=".LOGIN_ID." AND c.flag_account=4
							".$sql."
					ORDER BY 2 ";

		$row = PreExecSQL_all($sql,$arr);

		return $row;
	}


	// Поиск - сохраненные пользователем параметры поиска
	function reqSearchFilterParamCompany($p=array()){

		$in = fieldIn($p, array('login_id','company_id'));

		if($in['company_id']){// авторизованный
			$sql = " AND f.login_id=? AND f.company_id=? ";
			$arr = array($in['login_id'],$in['company_id']);
		}else{// НЕ авторизованный
			$sql = " AND f.cookie_session=? AND f.company_id=0 ";
			$arr = array(COOKIE_SESSION);
		}


		$sql = "	SELECT f.flag_search, f.categories_id, f.cities_id, f.flag, f.flag_interest, f.cookie_session,
							f.sort_12, f.sort_who, f.flag_buy_sell
					FROM search_filter_param_company f
					WHERE 1=1 ".$sql." ";

		$row = PreExecSQL_one($sql,$arr);

		return $row;
	}


	// Insert - Счетчик просмотра объявления или предложения
	function reqInsertCounterBuysellone($p=array()) {

		if(LOGIN_ID){

			$sql = "	SELECT cb.id 
						FROM counter_buysellone cb
						WHERE cb.login_id=? AND cb.company_id=? AND cb.buy_sell_id=? ";

			$row = PreExecSQL_one($sql,array( LOGIN_ID,COMPANY_ID,$p['buy_sell_id'] ));

			if(empty($row)){

				$STH = PreExecSQL(" INSERT INTO counter_buysellone (login_id,company_id,buy_sell_id) VALUES (?,?,?); " ,
					array( LOGIN_ID,COMPANY_ID,$p['buy_sell_id'] ));

			}

		}else{

			$sql = "	SELECT cb.id 
						FROM counter_buysellone_ip cb
						WHERE cb.buy_sell_id=? AND cb.ip=? ";

			$row = PreExecSQL_one($sql,array( $p['buy_sell_id'] , $_SERVER['HTTP_X_REAL_IP'] ));

			if(empty($row)){

				$STH = PreExecSQL(" INSERT INTO counter_buysellone_ip (buy_sell_id,ip) VALUES (?,?); " ,
					array( $p['buy_sell_id'] , $_SERVER['HTTP_X_REAL_IP'] ));

			}

		}

		return '';
	}


	// Insert - Добавить в cron Опубликованую||Активную заявку
	function reqInsertCronAmoBuySell($p=array()) {

		$STH = PreExecSQL(" INSERT INTO cron_amo_buy_sell (buy_sell_id,token) VALUES (?,?); " ,
			array( $p['buy_sell_id'],AMO_TOKEN));
		if($STH){
			$ok = true;
		}

		return array('STH'=>$STH);
	}


	// Insert - Добавить html представление брендов из /qrq/amo/searchbrend.php
	function reqInsertAmoHtmlSearchbrend($p=array()) {

		$STH = PreExecSQL(" INSERT INTO amo_html_searchbrend (buy_sell_id,html) VALUES (?,?); " ,
			array( $p['buy_sell_id'],$p['html'] ));
		if($STH){
			$ok = true;
		}

		return array('STH'=>$STH);
	}

	// html представления вопросов со стороних сервисов (qrq)
	function reqAmoHtmlSearchbrend($p=array()){
		$sql = '';
		//$in = fieldIn($p, array('id'));
		$arr = array();


		$sql = "	SELECT qq.id, qq.buy_sell_id, qq.html
					FROM amo_html_searchbrend qq, buy_sell bs
					WHERE qq.buy_sell_id=bs.id AND bs.company_id=".COMPANY_ID."
							AND bs.id=?
					ORDER BY qq.id ";

		$row = PreExecSQL_one($sql,array($p['buy_sell_id']));

		return $row;
	}


	// Insert - Добавить в cron артиклы для получения предложений со стороних сервисов
	function reqInsertCronAmoBuysellSearch($p=array()) {

		$in['brand'] = isset($in['brand'])?	$in['brand'] : '';

		$STH = PreExecSQL(" INSERT INTO cron_amo_buy_sell_search (buy_sell_id,token,brand,searchtext) VALUES (?,?,?,?); " ,
			array( $p['buy_sell_id'],$p['token'],$p['brand'],$p['searchtext'] ));
		if($STH){
			$ok = true;
		}

		return array('STH'=>$STH);
	}


	// Номенклатура
	function reqNomenclature($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','company_id','value'));

		$start_limit 	= (isset($p['start_limit'])&&v_int($p['start_limit']))? 	$p['start_limit'] : 0;

		if($in['id']){
			$sql = 'AND n.id=?';
			$arr = array($in['id']);
			$one = true;
		}
		if($in['company_id']){
			$sql .= ' and company_id=?';
			array_push($arr , $in['company_id']);
		}

		// поиск
		if($in['value']){
			$sql .= " AND n.id IN (
													SELECT qw.id
													FROM (
														SELECT n.id, 
																n.name attribute_value

														FROM nomenclature n, slov_categories sc
														WHERE sc.active=1 AND n.categories_id=sc.id
														AND ( 		LOWER(n.name) LIKE ? 
																OR 	LOWER(n.name) LIKE ? 
																OR 	LOWER(n.name) LIKE ?
															)
														
													UNION ALL

														SELECT n.id,
															CASE WHEN na.attribute_value_id=0 THEN na.value
																ELSE avs.attribute_value END attribute_value
														FROM slov_attribute sa, categories_attribute ca, slov_categories sc, nomenclature n , nomenclature_attribute na
		
														LEFT JOIN ( SELECT av.id, sav.attribute_value FROM attribute_value av, slov_attribute_value sav WHERE sav.id=av.attribute_value_id ) avs
																		ON avs.id=na.attribute_value_id

														WHERE na.nomenclature_id=n.id AND ca.categories_id=n.categories_id AND sa.id=ca.attribute_id
															AND na.attribute_id=ca.attribute_id AND (na.value<>'-' OR NOT avs.attribute_value IS NULL )
															AND sc.active=1 AND n.categories_id=sc.id
															AND ( 		LOWER(CASE WHEN na.attribute_value_id=0 THEN na.value
																												ELSE avs.attribute_value END) LIKE ? 
																	OR 	LOWER(CASE WHEN na.attribute_value_id=0 THEN na.value
																												ELSE avs.attribute_value END) LIKE ? 
																	OR LOWER(CASE WHEN na.attribute_value_id=0 THEN na.value
																												ELSE avs.attribute_value END) LIKE ? )

													) qw

													WHERE 1=1 
														AND ( LOWER(qw.attribute_value) LIKE ? OR LOWER(qw.attribute_value) LIKE ? OR LOWER(qw.attribute_value) LIKE ? )
														

										) ";

			array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
			array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');
			array_push($arr , ''.$in['value'].'%'); array_push($arr , '% '.$in['value'].'%'); array_push($arr , '%-'.$in['value'].'%');


		}
		///


		$sql = "	SELECT n.id, n.login_id, n.company_id, n.name, n.categories_id, n.1c_nomenclature_id,
							sc.categories,
							(SELECT COUNT(bs.id) FROM buy_sell bs WHERE bs.nomenclature_id=n.id) flag_nomenclature_bs
					FROM nomenclature n, slov_categories sc
					WHERE n.categories_id=sc.id ".$sql."
					ORDER BY id DESC LIMIT ".$start_limit." , 25
					";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}


	// Insert - Номенклатура
	function reqInsertNomenclature($in=array()) {

		$in['1c_nomenclature_id'] = (isset($in['1c_nomenclature_id']))? $in['1c_nomenclature_id'] : 0;

		$STH = PreExecSQL(" INSERT INTO nomenclature (login_id,company_id,name,1c_nomenclature_id,categories_id) VALUES (?,?,?,?,?); " ,
			array( LOGIN_ID,COMPANY_ID,$in['name'],$in['1c_nomenclature_id'],$in['categories_id'] ));
		if($STH){
			$nomenclature_id = $GLOBALS['db']->lastInsertId();
			$ok = true;
		}


		return array('STH'=>$STH,'nomenclature_id'=>$nomenclature_id);
	}



	//Показывать окно впросы со стороних серверов
	function reqFlagSetTimeoutQrqHtmlQuestion($p=array()){

		$sql = "	SELECT q.id 
					FROM  amo_html_searchbrend q, buy_sell bs
					WHERE q.buy_sell_id=bs.id AND bs.company_id=".COMPANY_ID." LIMIT 1 ";

		$row = PreExecSQL_one($sql,array());

		return $row;
	}


