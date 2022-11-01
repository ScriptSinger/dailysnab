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
//			$sql .= ' and pass=?';
//			array_push($arr , $in['pass']);
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
							sc.unit_id, bs.unit_id2, bs.amount2, bs.unit_id1, bs.amount1, bs.amount_buy,
							su1.unit unit1, su2.unit unit2,
							sc.url_categories, cities.url_cities,
							sc.unit_group_id,
							sunit.unit,
							cities.name cities_name, 
							c.company,
							(SELECT t.id FROM subscriptions t WHERE t.company_id_in=".COMPANY_ID." AND t.company_id_out=bs.company_id) flag_subscriptions_company_in /* подписан на компанию чья заявка/объявление */ 
					FROM company c, a_cities cities, slov_categories sc, slov_unit sunit, buy_sell bs
					LEFT JOIN slov_unit su1 ON su1.id=bs.unit_id1
					LEFT JOIN slov_unit su2 ON su2.id=bs.unit_id2
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



	// Сводные цифры по статусам заявки
	function reqCountStatusBuySellByNomenclature($p=array()){
		$row = array();
		if(v_int($p['nomenclature_id'])){

			$sql = "	SELECT sbs.id, sbs.status_bs_count, 
										CASE WHEN sbs.id=31 THEN ROUND((	SELECT SUM(qw.amount) 
																			FROM (
																				SELECT bs.amount
																				FROM buy_sell bs
																				WHERE  bs.flag_buy_sell=5 AND bs.nomenclature_id=?
																				UNION ALL
																				SELECT s.ostatok
																				FROM 1c_nomost s
																				WHERE s.nomenclature_id=?
																				) qw) ,0) /*количество на складе*/
														ELSE COUNT(bs.id)  /*остальное количество по статусам*/
														END kol 
						FROM slov_status_buy_sell sbs
						LEFT JOIN buy_sell bs ON bs.status_buy_sell_id=sbs.id
										AND bs.flag_buy_sell=2 AND bs.active=1
										AND bs.nomenclature_id=? 
						WHERE sbs.id IN (2,3,11,12,14,15,31)
						GROUP BY sbs.id ";
			//vecho($sql.$p['nomenclature_id']);
			$row = PreExecSQL_all($sql,array($p['nomenclature_id'],$p['nomenclature_id'],$p['nomenclature_id']));

		}

		return $row;
	}


	// Количество на каких складах и какой остаток по номенклатуре
	function reqStockByNomenclature($p=array()){

		$sql = "	SELECT qw.stock, qw.unit, SUM(qw.amount) amount
					FROM (
						SELECT bs.amount, stock.stock, sunit.unit
						FROM buy_sell bs, slov_categories sc, slov_unit sunit, stock
						WHERE bs.categories_id=sc.id AND sc.unit_id=sunit.id AND bs.stock_id=stock.id AND bs.flag_buy_sell=5 AND bs.nomenclature_id=?
						UNION ALL
						SELECT s.ostatok, stock.stock, sunit.unit
						FROM 1c_nomost s, nomenclature n , slov_categories sc, slov_unit sunit, stock
						WHERE s.nomenclature_id=n.id AND n.categories_id=sc.id AND sc.unit_id=sunit.id AND s.stock_id=stock.id AND s.nomenclature_id=?
					) qw
					GROUP BY qw.stock, qw.unit ";

		$row = PreExecSQL_all($sql,array($p['nomenclature_id'],$p['nomenclature_id']));

		return $row;
	}

	// Последнии записи по статусам заявки
	function reqCompanyStatusBuySellByNomenclature($p=array()){

		$sql = "	SELECT CASE WHEN bs.status_buy_sell_id=2 OR bs.status_buy_sell_id=3 THEN c.company ELSE c2.company END company, bs.amount, sunit.unit, bs.cost, DATE_FORMAT( bs.data_insert, '%d %M' ) ndata_insert,
						(	SELECT GROUP_CONCAT(CASE WHEN sav.attribute_value IS NULL THEN bsa.value ELSE sav.attribute_value END SEPARATOR ', ') attribute  FROM  buy_sell_attribute bsa
							LEFT JOIN attribute_value av ON bsa.attribute_value_id=av.id
							LEFT JOIN slov_attribute_value sav ON av.attribute_value_id=sav.id
							WHERE bsa.buy_sell_id=bs.id
									AND bsa.attribute_id IN (SELECT ca.attribute_id FROM categories_attribute ca
															WHERE ca.categories_id=bs.categories_id AND ca.no_empty_sell=1) ) attribute
					FROM company c, slov_categories sc, slov_unit sunit, buy_sell bs
					LEFT JOIN company c2 ON bs.company_id2=c2.id 
					WHERE bs.categories_id=sc.id AND sc.unit_id=sunit.id AND bs.company_id=c.id 
						AND bs.flag_buy_sell=2 AND bs.active=1
						AND bs.status_buy_sell_id=? AND bs.nomenclature_id=? 
					ORDER BY bs.data_insert DESC LIMIT 5 ";

		$row = PreExecSQL_all($sql,array($p['status_buy_sell_id'],$p['nomenclature_id']));

		return $row;
	}

	// Меню - Склад
	function reqNavTabsStock($p=array()) {
		$sql = '';
		$arr = array();
		//$in = fieldIn($p, array('id','company_id'));

		$sql = "	SELECT 31 sbs_id, s.id stock_id, s.stock, IFNULL(sum(bs.kol),0) kol
					FROM stock s
					LEFT JOIN (	SELECT bs.stock_id, COUNT(bs.id) kol
								FROM buy_sell bs, nomenclature n
								WHERE bs.nomenclature_id=n.id AND bs.active=1 AND bs.flag_buy_sell=5 AND bs.status_buy_sell_id=31
									AND bs.company_id=".COMPANY_ID."
								GROUP BY n.id, bs.stock_id ) bs ON bs.stock_id=s.id
					WHERE s.company_id=".COMPANY_ID."
					
					UNION ALL

					SELECT sbs.id sbs_id, bs.stock_id, sbs.status_buy, IFNULL(bs.kol,0) kol
					FROM slov_status_buy_sell sbs
					LEFT JOIN (	SELECT bs.status_buy_sell_id, bs.stock_id, COUNT(bs.id) kol
								FROM buy_sell bs
								WHERE bs.active=1 AND bs.flag_buy_sell=5 AND bs.status_buy_sell_id IN (32,33) 
										AND bs.company_id=".COMPANY_ID." 
								GROUP BY bs.status_buy_sell_id ) bs ON bs.status_buy_sell_id=sbs.id
					WHERE sbs.id IN (32,33)

					ORDER BY 2,1
					";

		$row = PreExecSQL_all($sql,$arr);

		return $row;
	}


	// Склад
	function reqStock($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','company_id','flag','not_id'));

		$sql_order = " s.stock ";// по умолчанию

		$in['company_id'] = ($in['company_id'])? $in['company_id'] : COMPANY_ID;

		if($in['id']){
			$sql = 'AND s.id=?';
			$arr = array($in['id']);
			$one = true;
		}
		if($in['not_id']){
			$sql = 'AND s.id<>?';
			array_push($arr , $in['not_id']);
		}
		if($in['company_id']){
			$sql .= ' and s.company_id=?';
			array_push($arr , $in['company_id']);
		}

		if( ($in['flag']=='add_stock') && $in['company_id']){
			$one = true;
			$sql_order = " s.id LIMIT 1 ";
		}

		$sql = "	SELECT s.id, s.company_id, s.stock, s.address
					FROM stock s
					WHERE 1=1 ".$sql."
					ORDER BY ".$sql_order."
					";


		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// МОЙ СКЛАД
	function reqMyStockBuySell($p=array()) {
		$sql = $sql_status_buy_sell_id = $sql_stock_id1 = $sql_stock_id2 = $sql_company_id1 = $sql_company_id2 = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','company_id','status_buy_sell_id','stock_id',
			'categories_id','cities_id','value' ));

		$start_limit 	= (isset($p['start_limit'])&&v_int($p['start_limit']))? 	$p['start_limit'] : 0;

		$in['company_id'] = ($in['company_id'])? $in['company_id'] : COMPANY_ID;

		if($in['id']){
			$sql .= ' AND bs.id=? ';
			array_push($arr , $in['id']);
			$one = true;
		}
		if($in['company_id']){
			$sql_company_id1 = ' AND bs.company_id='.$in['company_id'].' ';
			$sql_company_id2 = ' AND n.company_id='.$in['company_id'].' ';
		}
		if($in['status_buy_sell_id']){
			$sql_status_buy_sell_id = ' AND bs.status_buy_sell_id=? ';
			array_push($arr , $in['status_buy_sell_id']);
		}
		if($in['stock_id']){
			$sql_stock_id1 = ' AND bs.stock_id='.$in['stock_id'].' ';
			$sql_stock_id2 = ' AND s.stock_id='.$in['stock_id'].' ';
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


		$sql = "	SELECT n.id, n.id nomenclature_id, n.name, n.categories_id, n.company_id, n.data_insert,
							5 flag_buy_sell, bs.status_buy_sell_id,
							bs.amount1,bs.unit_id1,bs.amount2,bs.unit_id2,bs.amount_buy, 
							bs.login_id,
							COUNT(bs.id) kol_stock, 
							AVG(bs.cost) cost,
							SUM(bs.amount) amount,
							(SELECT SUM(t.amount) FROM buy_sell t WHERE t.parent_id=bs.id AND t.flag_buy_sell=5) amount_reserve,
							sc.categories, sc.unit_group_id,
							sunit.unit,
							scurrency.currency,
							(SELECT t.ostatok FROM 1c_nomost t WHERE t.nomenclature_id=n.id AND t.stock_id=bs.stock_id) ostatok,
							'' urgency , 5 urgency_id , '' status_sell2 , '' cities_name , '' url ,
							'' url_categories , '' url_cities , '' comments , '' cost1 , '' company2 , 
							'' availability , '' form_payment , 1 form_payment_id , '' data_status_buy_sell_23 
							

					FROM buy_sell bs, slov_categories sc, slov_unit sunit, slov_currency scurrency, nomenclature n
					WHERE bs.nomenclature_id=n.id AND bs.categories_id=sc.id AND sc.unit_id=sunit.id AND bs.currency_id=scurrency.id
							AND bs.flag_buy_sell=5
							".$sql_company_id1."  
							".$sql_status_buy_sell_id." 
							".$sql_stock_id1."
							".$sql."
					GROUP BY n.id
					/*
					UNION ALL
					SELECT n.id, n.id nomenclature_id, n.name, n.categories_id, n.company_id, n.data_insert,
						5 flag_buy_sell, 31 status_buy_sell_id,
						'' amount1,'' unit_id1,'' amount2,'' unit_id2,'' amount_buy,
						(SELECT t.login_id FROM company t WHERE t.id=n.company_id) login_id,
						0 kol_stock,
						'' cost,
						'' amount,
						'' amount_reserve,
						sc.categories, '' unit_group_id,
						'' unit,
						'' currency,
						s.ostatok,
						'' urgency , 5 urgency_id , '' status_sell2 , '' cities_name , '' url ,
						'' url_categories , '' url_cities , '' comments , '' cost1 , '' company2 , 
						'' availability , '' form_payment , 1 form_payment_id , '' data_status_buy_sell_23 
					FROM 1c_nomost s, slov_categories sc, nomenclature n
					WHERE n.categories_id=sc.id AND s.nomenclature_id=n.id
							".$sql_company_id2." 
							".$sql_stock_id2."
					GROUP BY n.id
					ORDER BY 1 DESC LIMIT ".$start_limit." , 10	*/
									";

		/*
			$sql = "	SELECT bs.nomenclature_id, COUNT(bs.id) kol_stock,
							bs.id, bs.login_id, bs.company_id, bs.company_id2, bs.flag_buy_sell, bs.name, bs.url,
							bs.status_buy_sell_id, bs.urgency_id, bs.form_payment_id,
							bs.categories_id,
							AVG(bs.cost) cost,
							bs.cost1, bs.currency_id,
							SUM(bs.amount) amount,
							bs.amount_buy,
							bs.amount1,bs.unit_id1,bs.amount2,bs.unit_id2,
							su1.unit unit1, su2.unit unit2,
							bs.comments, bs.comments_company,
							bs.responsible_id, bs.stock_id,
							(SELECT cr.company FROM company cr WHERE cr.id=bs.responsible_id) responsible,
							CASE WHEN bs.availability=0 THEN '' ELSE bs.availability END availability ,
							sfp.form_payment,
							cities.name cities_name, cities.url_cities, c.company, c2.company company2,
							sc.categories, sc.url_categories, sc.unit_id, sc.unit_group_id,
							su.urgency, sbs.status_buy2, sbs.status_sell2, sunit.unit, scurrency.currency,
							stock.stock,
							DATE_FORMAT( bs.data_insert, '%d %M' ) ndata_insert,
							'' data_status_buy_sell_23,
							'' day_noactive,
							(SELECT SUM(t.amount) FROM buy_sell t WHERE t.parent_id=bs.id AND t.flag_buy_sell=5) amount_reserve



					FROM company c, a_cities cities, slov_categories sc, slov_urgency su, slov_status_buy_sell sbs, slov_unit sunit, slov_currency scurrency, buy_sell bs
					LEFT JOIN slov_form_payment sfp ON sfp.id=bs.form_payment_id
					LEFT JOIN company c2 ON c2.id=bs.company_id2
					LEFT JOIN slov_unit su1 ON su1.id=bs.unit_id1
					LEFT JOIN slov_unit su2 ON su2.id=bs.unit_id2
					LEFT JOIN stock ON stock.id=bs.stock_id

					WHERE bs.company_id=c.id AND cities.id=bs.cities_id AND bs.categories_id=sc.id AND bs.urgency_id=su.id
							AND sbs.id=bs.status_buy_sell_id AND sc.unit_id=sunit.id AND bs.currency_id=scurrency.id
							AND bs.flag_buy_sell=5
							".$sql_company_id1." ".$sql_status_buy_sell_id." ".$sql_stock_id1."
					GROUP BY CASE WHEN bs.nomenclature_id=0 THEN bs.id ELSE bs.nomenclature_id end
					ORDER BY bs.data_insert  DESC LIMIT ".$start_limit." , 10 ";
			*/
		/*
	if(!$in['id']){
	vecho($sql.'*'.$in['company_id'].'*'.$in['status_buy_sell_id'].'*'.$in['stock_id']);
	exit;
	}
	*/

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}


	// Autocomplete - Активы
	function reqAutocompleteAssets($p=array()){
		$sql = '';
		//$in = fieldIn($p, array('value'));
		$arr = array();
		$one = false;

		if(isset($p['value'])){//часть наименования
			$sql .= " 	AND bs.id IN (	SELECT bsa.buy_sell_id
											FROM buy_sell bs, categories_attribute ca, buy_sell_attribute bsa
											LEFT JOIN (	SELECT av.id, sav.attribute_value
													FROM attribute_value av, slov_attribute_value sav
													WHERE sav.id=av.attribute_value_id ) avs ON avs.id=bsa.attribute_value_id
											WHERE bsa.buy_sell_id=bs.id AND flag_buy_sell=4
												AND ca.assets=1 AND ca.categories_id=bs.categories_id AND bsa.attribute_id=ca.attribute_id
												AND (CASE WHEN bsa.attribute_value_id=0 THEN bsa.value ELSE avs.attribute_value END) LIKE ?
											GROUP BY bsa.buy_sell_id)";
			array_push($arr , '%'.$p['value'].'%');
		}

		if(isset($p['buy_sell_id'])){//
			$sql .= " 	AND bs.id=? ";
			array_push($arr , $p['buy_sell_id']);
			$one = true;
		}


		$sql = "	SELECT bsa.buy_sell_id, 
							GROUP_CONCAT(CASE WHEN bsa.attribute_value_id=0 THEN bsa.value ELSE avs.attribute_value END)  attribute_value 
					FROM buy_sell bs, categories_attribute ca, buy_sell_attribute bsa
					LEFT JOIN (	SELECT av.id, sav.attribute_value
								FROM attribute_value av, slov_attribute_value sav
								WHERE sav.id=av.attribute_value_id ) avs ON avs.id=bsa.attribute_value_id
					WHERE bsa.buy_sell_id=bs.id AND flag_buy_sell=4
							AND ca.assets=1 AND ca.categories_id=bs.categories_id AND bsa.attribute_id=ca.attribute_id
							".$sql."
					GROUP BY bsa.buy_sell_id ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Привязать един измер (из файла 1c в базу)
	function req1cSlovUnit($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('company_id','measure_id','flag'));

		$company_id = isset($in['company_id'])? $in['company_id'] : COMPANY_ID;

		if($in['measure_id']){
			$sql = 'AND su.measure_id=?';
			$arr = array($in['measure_id']);
			$one = true;
		}

		if($in['flag']=='data_1c'){
			$sql = " AND su.data_1c=(	SELECT MAX(t.data_1c)
											FROM 1c_slov_unit t
											WHERE t.company_id=".$company_id." ) ";
		}


		$sql = "	SELECT su.id, su.company_id, su.name, su.measure_id, su.data_1c
						FROM 1c_slov_unit su
						WHERE su.company_id=".$company_id." ".$sql." ";
	//vecho($sql);
		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Привязать единицы измерения (связка 1с и базы)
	function reqSlovUnitVBind1c($p=array()){
		$sql = '';
		//$in = fieldIn($p, array('value'));
		$arr = array();
		$one = false;

		$sql = "	SELECT 1 flag, t.name, t.measure_id, su.unit, su.okei
						FROM 1c_slov_unit t
						LEFT JOIN slov_unit su ON su.okei=t.measure_id AND t.measure_id<>0
						WHERE t.company_id=".COMPANY_ID."
						UNION ALL
						SELECT 2 flag, '', '', su.unit, su.okei
						FROM slov_unit su
						WHERE NOT su.id IN (	SELECT su.id
									FROM 1c_slov_unit t, slov_unit su
									WHERE t.measure_id=su.okei AND t.measure_id<>0 ) ";

		$row = PreExecSQL_all($sql,$arr);

		return $row;
	}


	// Привязать вид номенклатуры (из файла 1c в базу)
	function req1cTypenom($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id_1c','company_id','flag'));

		$company_id = isset($in['company_id'])? $in['company_id'] : COMPANY_ID;

		if($in['id_1c']){
			$sql = 'AND tn.id_1c=?';
			$arr = array($in['id_1c']);
			$one = true;
		}
		if($in['flag']=='data_1c'){
			$sql = " AND tn.data_1c=(	SELECT MAX(t.data_1c)
											FROM 1c_typenom t
											WHERE t.company_id=".$company_id." ) ";
		}

		$sql = "	SELECT tn.id, tn.company_id, tn.id_1c, tn.name, tn.data_1c
						FROM 1c_typenom tn
						WHERE 1=1 AND tn.company_id=".$company_id." ".$sql." ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Привязать - Вид номенклатуры и Категории
	function req1cTypenomCategoies($p=array()) {
		$sql = $sql_union = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('company_id','flag'));


		if($in['company_id']){
			$sql .= ' AND tc.company_id=? ';
			array_push($arr , $in['company_id']);
		}
		if($in['flag']=='bind_form'){
			$sql_union = ' 	UNION ALL
								SELECT 999999999999999999, 0, 0, 0 ';
		}


		$sql = "	SELECT tc.id, tc.company_id, tc.1c_typenom_id, tc.categories_id
					FROM 1c_typenom_categoies tc
					WHERE 1=1 ".$sql."
					".$sql_union."
					ORDER BY 1 ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Привязать Склад (из файла 1c в базу)
	function req1cStock($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id_1c','flag','company_id'));

		$company_id = isset($in['company_id'])? $in['company_id'] : COMPANY_ID;

		if($in['id_1c']){
			$sql = 'AND s.id_1c=?';
			$arr = array($in['id_1c']);
			$one = true;
		}
		if($in['flag']=='data_1c'){
			$sql = " AND s.data_1c=(	SELECT MAX(t.data_1c)
											FROM 1c_stock t
											WHERE t.company_id=".$company_id." ) ";
		}


		$sql = "	SELECT s.id, s.company_id, s.id_1c, s.name, s.data_1c
						FROM 1c_stock s
						WHERE 1=1 AND s.company_id=".$company_id." ".$sql." ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}


	// Привязать - Склады из 1с и наши Склады
	function req1cStockStock($p=array()) {
		$sql = $sql_union = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('company_id','flag'));


		if($in['company_id']){
			$sql .= ' AND ss.company_id=? ';
			array_push($arr , $in['company_id']);
		}
		if($in['flag']=='bind_form'){
			$sql_union = ' 	UNION ALL
								SELECT 999999999999999999, 0, 0 ';
		}


		$sql = "	SELECT ss.id, ss.company_id, ss.1c_stock_id
					FROM stock ss
					WHERE 1=1 ".$sql."
					".$sql_union."
					ORDER BY 1 ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}


	// Привязать Компании (из файла 1c в базу)
	function req1cCompany($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id_1c','flag','id','company_id'));

		$company_id = isset($in['company_id'])? $in['company_id'] : COMPANY_ID;

		if($in['id_1c']){
			$sql = 'AND c.id_1c=?';
			$arr = array($in['id_1c']);
			$one = true;
		}
		if($in['flag']=='bind'){
			$sql .= " AND NOT c.id IN (	SELECT t.1c_company_id 
											FROM 1c_company_company t 
											WHERE t.company_id=c.company_id 
													AND NOT t.company_id_to=? ) ";
			array_push($arr , $in['id']);
		}
		if($in['flag']=='data_1c'){
			$sql = " AND c.data_1c=(	SELECT MAX(t.data_1c)
											FROM 1c_company t
											WHERE t.company_id=".$company_id." ) ";
		}

		$sql = "	SELECT c.id, c.company_id, c.id_1c, c.name, c.data_1c
						FROM 1c_company c
						WHERE 1=1 AND c.company_id=".$company_id." ".$sql." ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}
	
	// получаем ID компании по идентификатору из 1c привязанная к нашей компании
	function req1cCompanyCompanyById1c($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id_1c','company_id'));

		$company_id = isset($in['company_id'])? $in['company_id'] : COMPANY_ID;


		$sql = "	SELECT cc.company_id_to
				FROM 1c_company c, 1c_company_company cc
				WHERE cc.1c_company_id=c.id AND c.id_1c=? AND cc.company_id=? ";

		$row = PreExecSQL_one($sql,array($in['id_1c'],$in['company_id']));

		return $row;
	}
	
	
	// получаем категорию по id_1c идентификатору
	function reqNomenclatureById1c($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id_1c','company_id'));

		$company_id = isset($in['company_id'])? $in['company_id'] : COMPANY_ID;


		$sql = "	SELECT n.categories_id, n.id nomenclature_id
				FROM nomenclature n, 1c_nomenclature nc
				WHERE n.1c_nomenclature_id=nc.id AND nc.id_1c=? AND n.company_id=? ";

		$row = PreExecSQL_one($sql,array($in['id_1c'],$in['company_id']));

		return $row;
	}	
	
	

	// Привязка Компании 1С и "Наших"
	function req1cCompanyCompany($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','company_id','company_id_to'));

		if($in['id']){
			$sql = 'AND cc.id=?';
			$arr = array($in['id']);
			$one = true;
		}
		if($in['company_id']){
			$sql .= ' AND cc.company_id=? ';
			array_push($arr , $in['company_id']);
		}
		if($in['company_id_to']){
			$sql .= ' AND cc.company_id_to=? ';
			array_push($arr , $in['company_id_to']);
			$one = true;
		}


		$sql = "	SELECT cc.id, cc.company_id, cc.1c_company_id, cc.company_id_to
					FROM 1c_company_company cc
					WHERE 1=1 ".$sql." ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}


	// Привязать Номенклатуру (из файла 1c в базу)
	function req1cNomenclature($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id_1c','flag','id','company_id','value'));

		$company_id = isset($in['company_id'])? $in['company_id'] : COMPANY_ID;


		if($in['id']){
			$sql = 'AND n.id=?';
			$arr = array($in['id']);
			$one = true;
		}
		if($in['id_1c']){
			$sql = 'AND n.id_1c=?';
			$arr = array($in['id_1c']);
			$one = true;
		}
		if($in['flag']=='bind'){
			$sql .= " AND NOT n.id IN (	SELECT t.1c_nomenclature_id 
											FROM nomenclature t
											WHERE t.company_id=n.company_id
													AND NOT t.1c_nomenclature_id=? ) ";
			array_push($arr , $in['id']);
		}
		if($in['flag']=='data_1c'){
			$sql = " AND n.data_1c=(	SELECT MAX(t.data_1c)
											FROM 1c_nomenclature t
											WHERE t.company_id=".$company_id." ) ";
		}
		if($in['value']){//часть наименования
			$sql .= " and ( LOWER(n.name) LIKE ? OR LOWER(n.article) LIKE ? OR LOWER(n.kod_tovar) LIKE ? ) ";
			array_push($arr , '%'.$in['value'].'%');
			array_push($arr , '%'.$in['value'].'%');
			array_push($arr , '%'.$in['value'].'%');
		}


		$sql = "	SELECT n.id, n.company_id, n.id_1c, n.article, n.name, n.measure_id, n.typenom_id_1c, n.kod_tovar,
							CONCAT(IFNULL(n.article,''),' ',n.name,' ',IFNULL(n.kod_tovar,'')) name_article
					FROM 1c_nomenclature n
					WHERE 1=1 AND n.company_id=".$company_id." ".$sql." ";
	//vecho($sql);
		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	/*
		// Удалить от 11-06-2022
		function reqAmoAccounts($p=array()) {
			$sql = '';
			$arr = array();
			$one = false;
			$in = fieldIn($p, array('id','company_id','vendorid','flag','accounts_id','qrq_id','parent_id'));

			if($in['id']){
				$sql = 'AND a.id=?';
				$arr = array($in['id']);
				$one = true;
			}
			if($in['company_id']){
				$sql .= " AND a.company_id=? ";
				array_push($arr , $in['company_id']);
			}
			if($in['vendorid']){
				$sql .= " AND a.vendorid=? ";
				array_push($arr , $in['vendorid']);
			}
			if($in['accounts_id']){
				$sql .= " AND a.accounts_id=? ";
				array_push($arr , $in['accounts_id']);
			}
			if($in['qrq_id']){
				$sql .= " AND sq.id=? ";
				array_push($arr , $in['qrq_id']);
				$one = true;
			}
			if($in['parent_id']){
				$sql .= " AND a.parent_id=? ";
				array_push($arr , $in['parent_id']);
			}

			if($in['flag']=='one'){
				$one = true;
			}



			$sql = "	SELECT a.id, a.company_id, a.vendorid, a.login, a.password, a.accounts_id, a.accounts_title,
							sq.id qrq_id, sq.qrq, c.login_id, sq.company_id company_id_qrq,
							c.company
					FROM amo_accounts a, slov_qrq sq, company c
					WHERE a.vendorid=sq.vendorid AND a.company_id=c.id ".$sql." ";


			$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

			return $row;
		}
		*/

	// лог всего amo
	function reqInsertAmoLogJson($p=array()) {

		$ins_id = '';

		$parent_id 	= (isset($p['parent_id']))? 	$p['parent_id'] : 0;
		$accounts_id 	= (isset($p['accounts_id']))? 	$p['accounts_id'] : 0;

		$json 		= json_encode($p['json']);
		$parameters 	= print_r($p['parameters'],true);

		$json2 = '';
		if($parent_id){
			$json2 	= print_r($p['json'],true);
		}

		$STH = PreExecSQL(" INSERT INTO amo_log_json (parent_id,token,json,json2,url,parameters,accounts_id) VALUES (?,?,?,?,?,?,?); " ,
			array( $parent_id,$p['token'],$json,$json2,$p['url'],$parameters,$accounts_id ));
		if($STH){
			$ins_id = $GLOBALS['db']->lastInsertId();
		}

		return $ins_id;
	}


	// Компании ЭТП
	function reqSlovQrq($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','company_id','one'));

		if($in['id']){
			$sql	= ' and sq.id=?';
			$arr = array($in['id']);
			$one = true;
		}
		if($in['company_id']){
			$sql	= ' and sq.company_id=?';
			$arr = array($in['company_id']);
		}

		if($in['one']==true){
			$one = true;
		}


		$sql = "	SELECT sq.id, sq.qrq, sq.company_id, sq.vendorid, sq.promo, sq.flag_autorize,
							(	SELECT t.id 
								FROM amo_accounts_etp t 
								WHERE t.company_id=sq.company_id AND t.qrq_id=sq.id ) flag_amo_accounts_etp
					FROM slov_qrq sq
					WHERE 1=1 ".$sql." ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}
	
	// пришли ли новые предложения от Etp
	function reqBuySell_PageSell_EtpNew($p=array()) {

		$in = fieldIn($p, array('id'));

		$sql = "	SELECT COUNT(be.buy_sell_id) kol
				FROM buy_sell_etp_sell be
				WHERE be.cookie_session='".COOKIE_SESSION."' AND be.company_id=".COMPANY_ID." 
						AND be.buy_sell_id>".$in['id']."
						/*исключаем сгруппированные*/
						AND NOT be.buy_sell_id IN (	SELECT t.buy_sell_id
													FROM view_grouping_id_val_page_sell t
													WHERE NOT t.buy_sell_id IN (SELECT tt.buy_sell_id FROM view_grouping_id_kol_page_sell tt) )
						
						/**/
				 ";

		$row = PreExecSQL_one($sql,array());
		
		return $row;
	}
	

	// Баланс компании
	function reqBalance($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','company_id','total'));
		$in['company_id'] = ($in['company_id'])? $in['company_id'] : COMPANY_ID;


		if($in['id']){
			$sql .= ' AND cb.id=? ';
			array_push($arr , $in['id']);
			$one = true;
		}
		if($in['company_id']){
			$sql .= ' AND cb.company_id=? ';
			array_push($arr , $in['company_id']);
		}


		$sql = "	SELECT cb.id, cb.company_id, sum(cb.total) as total
					FROM company_balance cb
					WHERE cb.company_id=".$in['company_id']." ".$sql."
					";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Баланс компании Общий
	function reqBalanceAll($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','company_id','total'));
		$in['company_id'] = ($in['company_id'])? $in['company_id'] : COMPANY_ID;


		if($in['id']){
			$sql .= ' AND cb.id=? ';
			array_push($arr , $in['id']);
			$one = true;
		}
		if($in['company_id']){
			$sql .= ' AND cb.company_id=? ';
			array_push($arr , $in['company_id']);
		}


		$sql = "	SELECT cb.id, cb.company_id, cb.total, cb.type, cb.data_insert
					FROM company_balance cb
					WHERE cb.company_id=".$in['company_id']." ".$sql."
					";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Баланс компании с группировкой для скидки 90 дней для PRO
	function reqBalancePRO90($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','company_id','type','total'));
		$in['company_id'] = ($in['company_id'])? $in['company_id'] : COMPANY_ID;

		$sql = "	SELECT cb.company_id, cb.total, cb.type, COUNT(cb.company_id) AS count3
					FROM company_balance cb
					WHERE cb.type = 1 AND cb.company_id=".$in['company_id']." ".$sql."
					GROUP BY cb.company_id, cb.total";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}


	// Аккаунт амо добавлен, но нет в справочники Slov_qrq и соответственно не создан в company
	function reqNotSlovQrq($p=array()) {
		$sql = '';
		$arr = array();

		$sql = "	SELECT qw.vendorid, qw.accounts_title, qw.accounts_ids
					FROM (
						SELECT aa.vendorid, aa.accounts_title, GROUP_CONCAT(aa.accounts_id) accounts_ids, sq.id
						FROM amo_accounts aa
						LEFT JOIN slov_qrq sq ON sq.vendorid=aa.vendorid
						GROUP BY aa.vendorid, aa.accounts_title
						) qw
					WHERE qw.id IS NULL
					";

		$row = PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Счета на оплату (Карта\Счет)
	function reqInvoices($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('paymentId'));
		if($in['paymentId']){
			$sql = 'AND pi.paymentId=?';
			$arr = array($in['paymentId']);
			$one = true;
		}

		$sql = "	SELECT pi.paymentId, pi.paid
					FROM pro_invoices pi
					WHERE 1=1 ".$sql." ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// вывод данных о сообщениях
	function reqChatMessages($p=array()) {
		$sql = $sql_fa = $sql_inner_join = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('need','ticket_exp','folder_id','t_date','t_time','t_date_full','data_insert','companies_id','status','company_id','attachments','value'));

		$start_limit 	= (isset($p['start_limit'])&&v_int($p['start_limit']))? 	$p['start_limit'] : 0;
		/*
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
	*/

		// поиск
		/* 				if($in['categories_id']){
						$sql .= ' AND c.id IN (	SELECT tc.category
												FROM tickets_category tc
												WHERE tc.id=? ) ';
						array_push($arr , $in['categories_id']);
					} */
		if($in['status']){
			$sql .= ' AND tf.status=? ';
			array_push($arr , $in['status']);
		}
		if($in['company_id']){
			$sql .= ' AND t.company_id=? ';
			array_push($arr , $in['company_id']);
		}
		if($in['folder_id']){
			$sql .= ' AND t.folder_id=? ';
			array_push($arr , $in['folder_id']);
		}
		/* 				if($in['companies']){
							$sql .= " AND LOWER(t.companies) LIKE ?";
							$companies =  "'%".$in['companies']."%'";
							array_push($arr, $companies);
					}	 */
		if($in['value']){
			$sql .= " AND LOWER(c.company) LIKE ?";
			array_push($arr , '%'.$in['value'].'%');
		}
		///
		/*
				(SELECT t.id FROM subscriptions t WHERE t.company_id_in='".COMPANY_ID."' AND t.company_id_out=c.id) flag_subscriptions,
				(SELECT t2.id FROM subscriptions t2 WHERE t2.company_id_out='".COMPANY_ID."' AND t2.company_id_in=c.id) flag_subscriptions2,
				( SELECT t.tid FROM notification t WHERE t.tid=c.id AND t.login_id=".LOGIN_ID." AND t.company_id=".COMPANY_ID." ) kol_notification
							 */


		$sql = "	SELECT t.id, t.folder_id, t.company_id, tf.companies_id, t.companies, t.ticket_exp, t.ticket_status, t.attachments, 
								t.data_insert, DATE_FORMAT(t.data_insert, '%d.%m.%Y %H:%i') as t_date_full, DATE_FORMAT(t.data_insert, '%H:%i') as t_time,
								c.company, c.avatar as ava_company, c.legal_entity_id,
								CONCAT(sle.legal_entity,' ',c.company) as name_rcmc,
								tf.folder_name, tf.status, tf.avatar as ava_folder, tf.need, t.chatId										
						FROM tickets t, company c, tickets_folder tf, slov_legal_entity sle
						".$sql_inner_join."
						WHERE c.id=t.company_id AND sle.id=c.legal_entity_id AND  tf.id=t.folder_id ".$sql."
						ORDER BY t.id ASC, t_date_full, t_time DESC LIMIT ".$start_limit." , 25
					";

	//vecho($sql);
		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// вывод данных о сообщениях
	function reqChatMessagesCompany($p=array()) {
		$sql = $sql_fa = $sql_inner_join = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('need','ticket_exp','folder_id','t_date','t_time','t_date_full','data_insert','companies','companies_id','status','company_id','attachments','value'));

		$start_limit 	= (isset($p['start_limit'])&&v_int($p['start_limit']))? 	$p['start_limit'] : 0;

		if($in['status']){
			$sql .= ' AND tf.status=? ';
			array_push($arr , $in['status']);
		}

		$sql = " SELECT t.id, t.folder_id, t.company_id, t.companies, tf.companies_id, t.ticket_exp, t.ticket_status, t.attachments,
							t.data_insert, DATE_FORMAT(t.data_insert, '%d.%m.%Y %H:%i') as t_date_full, DATE_FORMAT(t.data_insert, '%H:%i') as t_time,	
							c.avatar as ava_company, c.company, c.legal_entity_id,
							tf.folder_name, tf.avatar as ava_folder, tf.need, tf.status,
							CONCAT(sle.legal_entity,' ',c.company) as name_rcmc, t.chatId
					 FROM tickets t, company c, tickets_folder tf, slov_legal_entity sle
						".$sql_inner_join."
					 WHERE c.id=t.company_id AND tf.id=t.folder_id AND sle.id=c.legal_entity_id AND LOWER(t.companies) LIKE '%".COMPANY_ID."%'  ".$sql."
					 ORDER BY t.data_insert DESC LIMIT ".$start_limit." , 25
					";
	//vecho($sql);
		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// вывод данных о всех сообщених (без LIMIT) для подчета вхождений и для распределеня прав
	function reqAllChatMessagesCompany($p=array()) {
		$sql = $sql_fa = $sql_inner_join = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('need','ticket_exp','folder_id','t_date','t_time','t_date_full','data_insert','companies','companies_id','status','company_id','attachments','value'));

		$sql = " SELECT t.id, t.folder_id, t.company_id, t.companies, tf.companies_id, t.ticket_exp, t.ticket_status, t.attachments,
							t.data_insert, DATE_FORMAT(t.data_insert, '%d.%m.%Y %H:%i') as t_date_full, DATE_FORMAT(t.data_insert, '%H:%i') as t_time,	
							c.avatar as ava_company, c.company, c.legal_entity_id,
							tf.folder_name, tf.avatar as ava_folder, tf.need, tf.status,
							CONCAT(sle.legal_entity,' ',c.company) as name_rcmc
					 FROM tickets t, company c, tickets_folder tf, slov_legal_entity sle
					 WHERE c.id=t.company_id AND tf.id=t.folder_id AND sle.id=c.legal_entity_id AND LOWER(t.companies) LIKE '%".COMPANY_ID."%'  ".$sql."
					 ORDER BY t.data_insert ASC
					";
		//vecho($sql);
		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// вывод данных о папках сообщений
	function reqChatFolders($p=array()) {
		$sql = $sql_fa = $sql_inner_join = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','folder_name','owner_id','avatar','needs_id','status','companies_id'));

		$start_limit 	= (isset($p['start_limit'])&&v_int($p['start_limit']))? 	$p['start_limit'] : 0;

		// if($in['status']){
		// 	$sql .= ' AND tf.status=? ';
		// 	array_push($arr , $in['status']);
		// }
		if($in['id']){
			$sql .= ' AND tf.id=? ';
			array_push($arr , $in['id']);
		}

		if(!empty($p['folderReq'])){
            $sql .= ' AND tf.folder_name != "" ';
        }
        if(!empty($p['archiveTrue'])){
            $sql .= " AND (tf.status = 2 OR "." tf.companies_id LIKE '%\"-" . COMPANY_ID . "\"%')"; // FIXME
        } else if(!empty($p['archive'])){
            $sql .= " AND tf.status != 2 AND "." tf.companies_id LIKE '%\"" . COMPANY_ID . "\"%'";
        }
        
        $sql .= " AND (tf.companies_id LIKE '%" . COMPANY_ID . "%') ";


		$sql = "	SELECT tf.id, tf.folder_name, tf.owner_id, tf.avatar, tf.need as needs_id, tf.status, tf.companies_id			
						FROM tickets_folder tf
						".$sql_inner_join."
						WHERE 1=1 ".$sql."
						ORDER BY tf.data_insert DESC LIMIT ".$start_limit." , 25
					";
		//


		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);
//        vecho(count($row));
        
		return $row;
	}

	// вывод Email для рассылки одним запросом
	function reqCompanyEmails($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('ids','email'));

		if($in['ids']){
			$sql .= ' AND c.id IN ('.$in['ids'].') ';
		}


		$sql = "	SELECT c.id, c.login_id, c.flag_account, c.company, c.email
					FROM company c
					WHERE 1=1 ".$sql." ";
	//vecho($sql);
		$row = PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Словарь Ссылка на потребности (убрать, если не понадоб-ся)
	function reqSlovUnitGroupPotreb($p=array()) {
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


	// ЭКСПОРТ - Передаем в 1с купленные заявки (Купленное)
	function reqOut1cBuy11($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('company_id'));

		if($in['company_id']){
			$sql .= 'AND bs.company_id=?';
			array_push($arr , $in['company_id']);
		}

		$sql = "	SELECT 
					cc2.id_1c contractorid,
					bs.data_insert `date`,
					nc.id_1c `nomid`,
					bs.cost,
					CASE WHEN bs.form_payment_id=1 THEN 20 ELSE 0 END `nds`,
					bs.amount `quantity`,
					bsa3.attribute_value brend,
					s1.id_1c stock_id_1c,
					bs.id buy_sell_id
				FROM 1c_company_company cc, 1c_company cc2, nomenclature n, 1c_nomenclature nc, buy_sell bs
				LEFT JOIN stock s ON s.id=bs.stock_id
				LEFT JOIN 1c_stock s1 ON s1.id=s.1c_stock_id
				LEFT JOIN ( 	SELECT bsa.buy_sell_id, sav.attribute_value
								FROM attribute_value av, slov_attribute_value sav, buy_sell_attribute bsa
								WHERE bsa.attribute_value_id=av.id 
										AND av.attribute_id=3 AND av.attribute_value_id=sav.id ) bsa3 ON bsa3.buy_sell_id=bs.id
				WHERE cc.1c_company_id=cc2.id AND cc.company_id=bs.company_id AND cc.company_id_to=bs.company_id2
					AND n.id=bs.nomenclature_id AND nc.id=n.1c_nomenclature_id 
					AND bs.flag_buy_sell=2 AND bs.status_buy_sell_id=11 
							AND NOT bs.id IN (SELECT t.buy_sell_id FROM 1c_outbuy11 t)/*исключаем ранее переданные, которые уже сели в 1с (берем из buy11.json)*/
							".$sql."
					ORDER BY bs.id ";

		$row = PreExecSQL_all($sql,$arr);

		return $row;
	}

	// ЭКСПОРТ - Передаем в 1с купленные объявления (Купленное)
	function reqOut1cSell11($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('company_id'));


		$sql = "	SELECT cc2.id_1c contractorid,
						bs.data_insert `date`,
						nc.id_1c `nomid`,
						bs.cost,
						CASE WHEN bs.form_payment_id=1 THEN 20 ELSE 0 END `nds`,
						bs.amount `quantity`,
						bsa3.attribute_value brend,
						s1.id_1c stock_id_1c,
						bs.id buy_sell_id
					FROM 1c_company_company cc, 1c_company cc2, nomenclature n, 1c_nomenclature nc, buy_sell bs
					LEFT JOIN stock s ON s.id=bs.stock_id
					LEFT JOIN 1c_stock s1 ON s1.id=s.1c_stock_id
					LEFT JOIN ( 	SELECT bsa.buy_sell_id, sav.attribute_value
									FROM attribute_value av, slov_attribute_value sav, buy_sell_attribute bsa
									WHERE bsa.attribute_value_id=av.id 
											AND av.attribute_id=3 AND av.attribute_value_id=sav.id ) bsa3 ON bsa3.buy_sell_id=bs.id
											
					WHERE cc.1c_company_id=cc2.id AND cc.company_id=bs.company_id2 AND cc.company_id_to=bs.company_id 
							AND n.id=bs.nomenclature_id AND nc.id=n.1c_nomenclature_id 
							AND bs.flag_buy_sell=2
							AND bs.status_buy_sell_id=11 AND ( (bs.flag_buy_sell=1 AND bs.company_id=".$in['company_id'].") 
												OR CASE WHEN bs.company_id2=".$in['company_id']." AND bs.company_id2>0 THEN bs.flag_buy_sell IN (1,2) ELSE bs.company_id2=".$in['company_id']."
												AND bs.flag_buy_sell IN (1) END ) 
					ORDER BY bs.id ";

		$row = PreExecSQL_all($sql,$arr);

		return $row;
	}


	// ЭКСПОРТ - Передаем в 1с исполненные заявки (которые заводили для "заказчика")
	function reqOut1cBuy12($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('company_id'));

		if($in['company_id']){
			$sql .= 'AND bs.company_id=?';
			array_push($arr , $in['company_id']);
		}

		$sql = "	SELECT cc2.id_1c contractorid,
						bs.data_insert `date`,
						nc.id_1c `nomid`,
						bs.cost,
						CASE WHEN bs.form_payment_id=1 THEN 20 ELSE 0 END `nds`,
						bs.amount `quantity`,
						bsa3.attribute_value brend,
						s1.id_1c stock_id_1c,
						bs.id buy_sell_id
					FROM 1c_company_company cc, 1c_company cc2, nomenclature n, 1c_nomenclature nc, buy_sell bs
					LEFT JOIN stock s ON s.id=bs.stock_id
					LEFT JOIN 1c_stock s1 ON s1.id=s.1c_stock_id
					LEFT JOIN ( 	SELECT bsa.buy_sell_id, sav.attribute_value
									FROM attribute_value av, slov_attribute_value sav, buy_sell_attribute bsa
									WHERE bsa.attribute_value_id=av.id 
											AND av.attribute_id=3 AND av.attribute_value_id=sav.id ) bsa3 ON bsa3.buy_sell_id=bs.id
					WHERE cc.1c_company_id=cc2.id AND cc.company_id=bs.company_id AND cc.company_id_to=bs.company_id3 
							AND n.id=bs.nomenclature_id AND nc.id=n.1c_nomenclature_id 
							AND bs.flag_buy_sell=2 AND bs.status_buy_sell_id=12 AND bs.company_id3>0
							AND NOT bs.id IN (SELECT t.buy_sell_id FROM 1c_outbuy11 t)/*исключаем ранее переданные, которые уже сели в 1с (берем из buy11.json)*/
							".$sql."
					ORDER BY bs.id ";

		$row = PreExecSQL_all($sql,$arr);

		return $row;
	}


	// Вывод закгруженный файлов для сообщений
	function reqChatMessagesFiles($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','message_id','name'));
		if($in['message_id']){
			$sql = 'AND tf.message_id=?';
			$arr = array($in['message_id']);
			$one = false;
		}

		$sql = "	SELECT tf.id, tf.name, tf.message_id
					FROM tickets_files tf
					WHERE 1=1 ".$sql." ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// вывод данных о тикетах
	function reqTicketMessages($p=array()) {
		$sql = $sql_fa = $sql_inner_join = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','ticket_exp','folder_id','t_date','t_time','t_date_full','vazh','status','data_insert','ticket_flag','owner_id','prava','start_limit'));

		$start_limit 	= (isset($p['start_limit'])&&v_int($p['start_limit']))? 	$p['start_limit'] : 0;

		if($in['id']){
			$sql .= ' AND t.id=? ';
			array_push($arr , $in['id']);
		}

		if($in['ticket_flag']){
			$sql .= ' AND t.ticket_flag IN ('.$in['ticket_flag'].') ';
		}

		/* 				if($in['ticket_flag']){
						$sql .= ' AND t.ticket_flag=? ';
						array_push($arr , $in['ticket_flag']);
					} */

		if($in['status']){
			$sql .= ' AND t.status=? ';
			array_push($arr , $in['status']);
		}

		if($in['prava']){
			$sql .= ' AND t2s.prava=? ';
			array_push($arr , $in['prava']);
		}

		if($in['owner_id']){
			$sql .= ' AND t.owner_id=? ';
			array_push($arr , $in['owner_id']);
		}

		//
		$sql_inner_join = "INNER JOIN company c ON c.id = t.owner_id";

		$sql = "	SELECT t.id,t.owner_id,t.ticket_exp,t.ticket_flag,t.status,t.vazh,t.inv, t.data_insert, DATE_FORMAT(t.data_insert, '%H:%i') as t_time, c.phone tel, DATE_FORMAT(t.data_insert, '%d.%m.%Y %H:%i') as t_date_full,
			   t2s.status_name,t2s.status_class, t2s.prava, c.company, l.email mail, c.email
		FROM tickets2_status as t2s, tickets2 as t
		
			
			
						
						".$sql_inner_join."
						INNER JOIN login l ON l.id = c.login_id
						WHERE t2s.id=t.ticket_flag ".$sql."
						GROUP BY t.id ORDER BY t.data_insert DESC LIMIT ".$start_limit." , 25
					";


		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		 return $row;
	}

	// Вывод кол-ва тикетов по флагам и статусам
	function reqCountTickets($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','ticket_flag','status','owner_id'));

		if($in['owner_id']){
			$sql .= ' AND owner_id=? ';
			array_push($arr , $in['owner_id']);
		}

		/* 		if($in['message_id']){
				$sql = 'AND tf.message_id=?';
				$arr = array($in['message_id']);
				$one = false; 	//status,
			} */

		$sql = "	SELECT ticket_flag, status, COUNT(*) as count_flag FROM tickets2 
					WHERE 1=1 ".$sql." GROUP BY ticket_flag";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// Картинки тикетов
	function reqTicketsFiles($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','file_name','ticket_id'));

		if($in['ticket_id']){
			$sql = 'AND tf.ticket_id=?';
			$arr = array($in['ticket_id']);
			$one = false;
		}

		$sql = "	SELECT file_name FROM tickets2_files tf
					WHERE 1=1 ".$sql." GROUP BY id";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// вывод данных о статусах в тикетах
	function reqTicketSlovStatus($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','status_name'));

		if($in['id']){
			$sql = 'AND t2s.id=?';
			$arr = array($in['id']);
			$one = true;
		}

		$sql = "	SELECT t2s.id,t2s.status_name,t2s.status_class
						FROM tickets2_status t2s
						WHERE 1=1  ".$sql."
						ORDER BY t2s.id ASC
					";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// вывод правил для регулированя смены статуса тикетов
	function reqTicketChangeRulesOptions($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','status_1','status_2','roles', 'user_id'));

		if($in['roles']){
			$sql = ' AND t2cor.roles=?';
			$arr = array($in['roles']);
			//array_push($arr , $in['roles']);
			$one = false;
		}

		if($in['status_1']){
			$sql .= ' AND t2cor.status_1=?';
			//$arr = array($in['status_1']);
			array_push($arr , $in['status_1']);
			$one = false;
		}

		if($in['user_id']){
			$sql .= ' AND lcp.prava_id=?';
			//$arr = array($in['user_id']);
			array_push($arr , $in['user_id']);
			$one = false;
		}
		$sql = "	SELECT DISTINCT t2cor.id,t2cor.status_1,t2cor.status_2,t2cor.roles, t2s.status_name, t2s.status_name_out, t2s.status_class, lcp.prava_id, lcp.login_id,
							CASE WHEN t2cor.roles = 7 THEN 1 WHEN t2cor.roles = 6 THEN 1 ELSE 0 END AS roles_active
						FROM tickets2_change_options_rules t2cor, tickets2_status t2s, login_company_prava lcp 
						WHERE t2s.active = 1 AND t2cor.status_2 = t2s.id AND t2cor.roles = lcp.prava_id AND lcp.login_id=".LOGIN_ID."   ".$sql."  
						ORDER BY t2cor.id ASC
					";

	//vecho($sql);
		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// вывод истроии тикетов
	function reqTicketHistory($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('ticket_id','flag')); //'status1','status2'

		/* 		if($in['status1']){
				$sql = 'AND t2h.status1=?';
				$arr = array($in['status1']);
				$one = false;
			} */

		if($in['ticket_id']){
			$sql = ' AND t2h.ticket_id=?';
			$arr = array($in['ticket_id']);
			//$one = false;
		}

		if($in['flag']){
			$sql .= ' AND t2h.flag=?';
			//$arr = array($in['flag']);
			array_push($arr , $in['flag']);
			//$one = false;
		}

		$sql = "	SELECT t2h.id,t2h.ticket_id,t2h.status1,t2h.status2,t2h.flag,t2h.user_id
						FROM tickets2_history t2h
						WHERE 1=1 " .$sql. "  
						ORDER BY t2h.id ASC
					";
	//vecho($sql);   //AND t2h.status2 = t2s.id , tickets2_status t2s
		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}


	// вывод админов к тикетам
	function reqTicketAdmins($p=array()) {
		$sql = '';
		$arr = array();
		$one = true;
		$in = fieldIn($p, array('id','admins'));

		/* 		if($in['id']){
				$sql = 'AND t2s.id=?';
				$arr = array($in['id']);
				$one = true;
			}  */
		$sql = "	SELECT GROUP_CONCAT(login_id) AS admins FROM login_company_prava WHERE prava_id IN (6,7)";


		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}



	// Права на функционал Pro
	function reqCompanyVipFunction($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('vip_function_id','company_id','one'));

		if($in['vip_function_id']){
			$sql = ' AND v.vip_function_id IN ('.$in['vip_function_id'].')';
		}

		if($in['company_id']){
			$sql .= ' AND v.company_id=?';
			array_push($arr , $in['company_id']);
		}

		if($in['one']){
			$one = true;
		}

		$sql = " 	SELECT v.id, v.company_id, v.vip_function_id 
						FROM company_vip_function v
						WHERE 1=1 ".$sql."
					";

	//vecho($sql);
		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}
	
	
	// Права на функционал Pro
	function reqCompanyVipFunctionByCompanyId($p=array()) {

		$in = fieldIn($p, array('company_id'));

		$sql = "	SELECT 
					(SELECT t.id FROM company_vip_function t WHERE t.company_id=".$in['company_id']." AND vip_function_id=1
					) flag_ispolnen,			/*включена Исполение на странице навыки*/
					(SELECT t.id FROM company_vip_function t WHERE t.company_id=".$in['company_id']." AND vip_function_id=2
					) flag_ostatki,				/*включена Остатки*/
					(SELECT t.id FROM company_vip_function t WHERE t.company_id=".$in['company_id']." AND vip_function_id=8
					) flag_unii_prodavec,		/*включена Юный продавец*/
					(SELECT t.id FROM company_vip_function t WHERE t.company_id=".$in['company_id']." AND vip_function_id=4
					) flag_vidacha_tovara		/*включена Выдача товара*/
					";

	//vecho($sql);
		$row = PreExecSQL_one($sql,array());

		return $row;
	}
	
	

	// Количество не привязанная номенклатура, контрагент, категория к 1С в купленных заявках
	function reqNo_SumLogoNotification($p=array()) {

		$sql = " SELECT SUM(qw.kol) kol
					FROM (
						SELECT COUNT(DISTINCT(n.id)) kol
						FROM buy_sell bs, nomenclature n
						WHERE bs.nomenclature_id=n.id AND bs.company_id=".COMPANY_ID." AND bs.status_buy_sell_id=11 AND bs.active=1
						AND bs.data_insert>'2022-03-27'
						AND n.1c_nomenclature_id=0
						AND NOT n.id IN (SELECT t.tid FROM notification_logo_propustit t WHERE t.flag=1)/*исключить пропущенные*/

						UNION ALL

						SELECT COUNT(t.id) 
						FROM (
							SELECT qw.id
							FROM (
								SELECT c.id, cc.company_id_to
								FROM buy_sell bs, company c
								LEFT JOIN 1c_company_company cc ON c.id=company_id_to
								WHERE bs.company_id2=c.id AND bs.company_id=".COMPANY_ID." AND bs.status_buy_sell_id=11 AND bs.active=1
									AND bs.data_insert>'2022-03-27'
									AND NOT c.id IN (SELECT t.tid FROM notification_logo_propustit t WHERE t.flag=2)/*исключить пропущенные*/
								) qw
						WHERE qw.company_id_to IS NULL 
						GROUP BY qw.id 
						)t

						UNION ALL 

						SELECT COUNT(sc.id)
						FROM slov_categories sc, nomenclature n
						LEFT JOIN 1c_typenom_categoies tc ON tc.company_id=n.company_id AND tc.categories_id=n.categories_id
						LEFT JOIN 1c_typenom t ON tc.1c_typenom_id=t.id
						WHERE n.categories_id=sc.id AND n.company_id=".COMPANY_ID." AND t.id IS NULL
								AND NOT sc.id IN (SELECT t.tid FROM notification_logo_propustit t WHERE t.flag=3)/*исключить пропущенные*/
					) qw
					";

		$row = PreExecSQL_one($sql,array());

		return $row;
	}


	// Количество ответы бренды с этп(qwep)
	function reqEtpKolLogoNotification($p=array()) {

		$sql = " SELECT COUNT(qq.id) kol
					FROM amo_html_searchbrend qq, buy_sell bs
					WHERE qq.buy_sell_id=bs.id AND bs.company_id=".COMPANY_ID."
					";

		$row = PreExecSQL_one($sql,array());

		return $row;
	}


	// не привязанные номенклатуры, компании(поставщики), категории к 1с (только купленные)
	function reqNo_1c_NomenclatureCompanyCategories($p=array()) {

		$sql = " SELECT DISTINCT 1 flag, n.id, n.name, n.data_insert,
							(SELECT t.id FROM 1c_nomenclature_out t WHERE t.nomenclature_id=n.id) 1c_nomenclature_out
					FROM buy_sell bs, nomenclature n
					WHERE bs.nomenclature_id=n.id AND bs.company_id=".COMPANY_ID." AND bs.status_buy_sell_id=11 AND bs.active=1
							AND bs.data_insert>'2022-03-27'
							AND n.1c_nomenclature_id=0
							AND NOT n.id IN (SELECT t.tid FROM notification_logo_propustit t WHERE t.flag=1)/*исключить пропущенные*/

					UNION ALL

					SELECT 2 flag, qw.id, qw.company, qw.data_insert, ''
					FROM (
						SELECT c.id, cc.company_id_to, c.company, bs.data_insert
						FROM buy_sell bs, company c
						LEFT JOIN 1c_company_company cc ON c.id=company_id_to
						WHERE bs.company_id2=c.id AND bs.company_id=".COMPANY_ID." AND bs.status_buy_sell_id=11 AND bs.active=1
							AND bs.data_insert>'2022-03-27'
							AND NOT c.id IN (SELECT t.tid FROM notification_logo_propustit t WHERE t.flag=2)/*исключить пропущенные*/
						) qw
					WHERE qw.company_id_to IS NULL 
					GROUP BY qw.company

					UNION ALL

					SELECT DISTINCT 3 flag, sc.id, sc.categories, UNIX_TIMESTAMP(n.data_insert) data_insert, ''
					FROM slov_categories sc, nomenclature n
					LEFT JOIN 1c_typenom_categoies tc ON tc.company_id=n.company_id AND tc.categories_id=n.categories_id
					LEFT JOIN 1c_typenom t ON tc.1c_typenom_id=t.id
					WHERE n.categories_id=sc.id AND n.company_id=".COMPANY_ID." AND t.id IS NULL
							AND NOT sc.id IN (SELECT t.tid FROM notification_logo_propustit t WHERE t.flag=3)/*исключить пропущенные*/
					
					UNION ALL

					SELECT 4 flag, bs.id, '', bs.data_insert, ''
					FROM amo_html_searchbrend qq, buy_sell bs
					WHERE qq.buy_sell_id=bs.id AND bs.company_id=".COMPANY_ID."
					
					ORDER BY 4 DESC
					
					";

		$row = PreExecSQL_all($sql,array());

		return $row;
	}


	// сохраняем buy_sell_id переданные купленные в 1с (Out1cBuy11 -> questrequest.ru/cron/cron_1c_buy12)
	function req1cOutbuy11($p=array()) {

		$sql = " 	SELECT t.buy_sell_id
						FROM 1c_outbuy11 t
						WHERE t.buy_sell_id=?
					";

		$row = PreExecSQL_one($sql,array($p['buy_sell_id']));

		return $row;
	}


	// сохраняем buy_sell_id переданные  исполненные для заказчика в 1с (Out1cBuy12 -> questrequest.ru/cron/cron_1c_buy12)
	function req1cOutbuy12($p=array()) {

		$sql = " 	SELECT t.buy_sell_id
						FROM 1c_outbuy12 t
						WHERE t.buy_sell_id=?
					";

		$row = PreExecSQL_one($sql,array($p['buy_sell_id']));

		return $row;
	}


	// Передаем в 1с признак обновить все файлы
	function req1cRefreshAll($p=array()) {

		$sql = " 	SELECT t.company_id
						FROM 1c_refresh_all t
						WHERE t.company_id=?
					";

		$row = PreExecSQL_one($sql,array($p['company_id']));

		return $row;
	}


	// 1C - Проверяем есть ли в базе (только для привязанной номенклатура , склад)
	function reqProverka1cNomenclatureStock($p=array()) {

		$sql = " 
					SELECT (
						SELECT n.id 
						FROM nomenclature n, 1c_nomenclature nc
						WHERE n.1c_nomenclature_id=nc.id AND nc.id_1c=?
						) nomenclature_id,
						(
						SELECT s.id
						FROM stock s, 1c_stock sc
						WHERE s.1c_stock_id=sc.id AND sc.id_1c=?
						) stock_id
									";

		$row = PreExecSQL_one($sql,array($p['nomenclature_id_1c'],$p['stock_id_1c']));

		return $row;
	}


	// Привязать остатки за номенклатурой (из файла 1c в базу)
	function req1cNomost($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('flag','company_id','nomenclature_id','stock_id','one'));

		$company_id = isset($in['company_id'])? $in['company_id'] : COMPANY_ID;


		if($in['flag']=='data_1c'){
			$sql = " AND o.data_1c=(	SELECT MAX(t.data_1c)
										FROM 1c_nomost t
										WHERE t.company_id=".$company_id." ) ";
		}

		if($in['nomenclature_id']){
			$sql .= ' AND o.nomenclature_id=?';
			array_push($arr , $in['nomenclature_id']);
		}

		if($in['stock_id']){
			$sql .= ' AND o.stock_id=?';
			array_push($arr , $in['stock_id']);
		}

		if($in['one']){
			$one = true;
		}

		$sql = "	SELECT o.id, o.nomenclature_id, o.ostatok, o.id_1c_nomid
					FROM 1c_nomost o
					WHERE o.company_id=".$company_id." ".$sql." ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}


	// не привязанные компании(поставщики) к 1с (только купленные)
	function req1cNomenclatureOut($p=array()) {

		$sql = " SELECT c.id_1c, 
							n.name, 
							na33.value articul,
							su.okei measureid,
							t.id_1c typenomid,
							nn.nomenclature_id
					FROM 1c_nomenclature_out nn, company c, slov_categories sc, slov_unit su,  1c_typenom_categoies tc, 1c_typenom t, nomenclature n
					LEFT JOIN ( 	SELECT na.nomenclature_id, na.value
									FROM nomenclature_attribute na
									WHERE na.attribute_id=33) na33 ON na33.nomenclature_id=n.id
					WHERE nn.nomenclature_id=n.id AND n.company_id=c.id AND n.categories_id=sc.id AND sc.unit_id=su.id 
							AND tc.company_id=c.id AND tc.1c_typenom_id=t.id AND tc.categories_id=sc.id AND c.id=?
					";

		$row = PreExecSQL_all($sql,array($p['company_id']));

		return $row;
	}


	// флаг, чтобы обновилось предложения не перегружая страницу
	function reqBuySellRefreshAmoSearch($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('company_id'));

		if($in['company_id']){
			$sql = 'AND br.company_id=?';
			$arr = array($in['company_id']);
			$one = true;
			$sql_order = " ORDER BY br.id DESC LIMIT 1 ";
		}

		$sql = "	SELECT br.id, br.company_id, br.buy_sell_id
					FROM buy_sell_refresh_amo_search br
					WHERE 1=1 ".$sql."
					".$sql_order."				";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}



	// не привязанные компании(поставщики) к 1с (только купленные)
	function reqDeleteBuysellRefreshAmoSearch($p=array()) {

		$STH = PreExecSQL(" DELETE FROM buy_sell_refresh_amo_search WHERE company_id=?; " ,
			array( COMPANY_ID ));

		return $STH;
	}


	// бренды с ЭТП qwep закрепленные за номенклатурой
	function reqNomenclatureAmoSearchbrend($p=array()) {

		$sql = " SELECT nb.id, nb.nomenclature_id, nb.brand
					FROM nomenclature_amo_searchbrend nb
					WHERE nb.nomenclature_id=?
					";

		$row = PreExecSQL_all($sql,array($p['nomenclature_id']));

		return $row;
	}

	// Компании которые принимают участие в ЭТП
	function reqAdminEtp($p=array()) {

		$sql = " SELECT c.id, c.company,
							'/image/profile-logo.png' avatar,
							sle.legal_entity,
							ac.name cities_name,
							cq.company_id, cq.login, cq.pass
					FROM slov_legal_entity sle, a_cities ac, company c, company_qrq cq
					WHERE cq.company_id=c.id AND c.cities_id=ac.id AND c.legal_entity_id=sle.id
					ORDER BY c.company 
					";

		$row = PreExecSQL_all($sql,array());

		return $row;
	}


	// ошибки через сервис "ошибок Этп"
	function reqAmoNameErrorEtp($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;

		$in = fieldIn($p, array('id'));

		if($in['id']){
			$sql = 'AND e.id=?';
			$arr = array($in['id']);
			$one = true;
		}


		$sql = "	SELECT e.id, e.name_error, e.name_error_qrq, e.name_error_etp, e.next_etp
					FROM amo_name_error_etp e
					WHERE 1=1 ".$sql."
					ORDER BY e.data_insert DESC ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;

	}


	// Связка компании с Этп (логин и пароль)
	function reqCompanyQrq($p=array()) {

		$sql = " SELECT cq.id, cq.company_id, cq.login, cq.pass
					FROM company_qrq cq
					WHERE cq.company_id=?
					
					";

		$row = PreExecSQL_one($sql,array($p['company_id']));

		return $row;
	}



	// флаг, чтобы обновилось предложения не перегружая страницу
	function reqAmoAccountsEtp($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('company_id','qrq_id','company_id_qrq','accounts_id','flag'));

		if($in['company_id']){
			$sql = ' AND ae.company_id=? ';
			$arr = array($in['company_id']);
		}
		
		if($in['company_id_qrq']){
			$sql = ' AND sq.company_id=? ';
			$arr = array($in['company_id_qrq']);
		}

		if($in['company_id']&&$in['qrq_id']){
			$sql = 'AND ae.company_id=? AND ae.qrq_id=?';
			$arr = array($in['company_id'],$in['qrq_id']);
			$one = true;
		}

		if($in['company_id']&&$in['company_id_qrq']){// ajax->action_subscriptions
			$sql = ' AND ae.company_id=? AND sq.company_id=? ';
			$arr = array($in['company_id'],$in['company_id_qrq']);
			$one = true;
		}

		if($in['accounts_id']){
			$sql = 'AND ae.accounts_id=?';
			$arr = array($in['accounts_id']);
			$one = true;
		}
		
		if($in['flag']=='flag_proverka_connect_3'){
			$sql = ' AND sq.id=? AND ae.flag_autorize=3 ';
			$arr = array($in['qrq_id']);
			$one = true;
		}


		$sql = "	SELECT ae.id, ae.company_id, ae.qrq_id, ae.flag_autorize, ae.login, ae.pass, ae.accounts_id, ae.account_title,
						(SELECT t.login_id FROM company t WHERE t.id=sq.company_id LIMIT 1) login_id_etp,
						sq.company_id company_id_etp,
						c.company
				FROM amo_accounts_etp ae, slov_qrq sq, company c
				WHERE ae.qrq_id=sq.id AND ae.company_id=c.id ".$sql."		";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}


	// получить accounts_id для получения объявлений(предложений) закрепленных за пользователем + промо accounts_id
	function reqAmoAccountsEtp_AccountsidByCompanyid($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('company_id','qrq_id'));

		$in['company_id'] = ($in['company_id'])? $in['company_id'] : 0;

		if($in['qrq_id']){
			$sql = ' AND qw.qrq_id=? ';
			$arr = array($in['qrq_id']);
			$one = true;
		}


		$sql = "	SELECT qw.login_id, qw.company_id, qw.qrq_id, MAX(qw.accounts_id) accounts_id FROM (

								SELECT (SELECT t.login_id FROM company t WHERE t.id=ae.company_id LIMIT 1) login_id,
										ae.company_id, ae.qrq_id, ae.accounts_id
								FROM slov_qrq sq, amo_accounts_etp ae
								WHERE sq.company_id=ae.company_id AND ae.qrq_id=sq.id AND ae.accounts_id>0 AND sq.promo=1 
								UNION ALL 
								SELECT (SELECT t.login_id FROM company t WHERE t.id=(SELECT t.company_id FROM slov_qrq t WHERE t.id=ae.qrq_id LIMIT 1) LIMIT 1) login_id,
										(SELECT t.company_id FROM slov_qrq t WHERE t.id=ae.qrq_id LIMIT 1) company_id,
										ae.qrq_id,
										CASE WHEN ae.flag_autorize=1 THEN (SELECT t.accounts_id FROM amo_accounts_etp t WHERE t.qrq_id=ae.qrq_id AND t.flag_autorize=3) 
													ELSE ae.accounts_id END accounts_id
								FROM amo_accounts_etp ae
								WHERE ae.company_id='".$in['company_id']."'
									) qw
					WHERE qw.accounts_id>0	".$sql."
					GROUP BY qw.login_id, qw.company_id, qw.qrq_id /*limit 3*/ ";


		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}
	
	
	// получить accounts_id, Если пользователь авторизовался со своим логин/пароль
	function reqAmoAccountsEtp_AccountsidByCompanyid3($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('company_id','qrq_id'));


		$sql = "	SELECT (SELECT t.login_id FROM company t WHERE t.id=(SELECT t.company_id FROM slov_qrq t WHERE t.id=ae.qrq_id LIMIT 1) LIMIT 1) login_id,
						(SELECT t.company_id FROM slov_qrq t WHERE t.id=ae.qrq_id LIMIT 1) company_id,
						ae.qrq_id,
						CASE WHEN ae.flag_autorize=1 THEN (SELECT t.accounts_id 
										FROM amo_accounts_etp t, slov_qrq sq
										WHERE t.qrq_id=sq.id AND sq.flag_autorize=1 AND t.qrq_id=ae.qrq_id AND t.flag_autorize=3) 
									ELSE ae.accounts_id END accounts_id
				FROM amo_accounts_etp ae
				WHERE ae.company_id=".$in['company_id']." AND ae.qrq_id=".$in['qrq_id']." ";


		$row = PreExecSQL_one($sql,$arr);

		return $row;
	}
	
	// получить accounts_id, Если подключено "Промо"
	function reqAmoAccountsEtp_AccountsidByCompanyid_Promo($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('qrq_id'));


		$sql = "	SELECT (SELECT t.login_id FROM company t WHERE t.id=ae.company_id LIMIT 1) login_id,
						ae.company_id, ae.qrq_id, ae.accounts_id
				FROM slov_qrq sq, amo_accounts_etp ae
				WHERE sq.company_id=ae.company_id AND ae.qrq_id=sq.id AND ae.accounts_id>0 AND sq.promo=1 
						AND ae.qrq_id=".$in['qrq_id']." ";

		$row = PreExecSQL_one($sql,$arr);

		return $row;
	}	


	// Связь полученных данных с ЭТП с таблицей buy_sell
	function reqBuySellEtpSell($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('company_id','cookie_session'));

		$in['company_id'] = ($in['company_id'])? $in['company_id'] : 0;

		$sql = "	SELECT buy_sell_id
					FROM buy_sell_etp_sell be
					WHERE be.cookie_session=? /*AND be.company_id=?*/ ";

		$row = PreExecSQL_all($sql,array($in['cookie_session']/*,$in['company_id']*/));

		return $row;
	}


	// Праметры передаваемые для покупки используются в basket.php
	function reqAmoAccountsBasketParam($p=array()) {

		$sql = "	SELECT id, accounts_id, param
					FROM amo_accounts_basket_param
					WHERE accounts_id=? ";

		$row = PreExecSQL_one($sql,array($p['accounts_id']));

		return $row;
	}


	// Наименование ошибок Етп за определенным кодом (текст ошибки разный)
	function reqAdminEtpErrorsLog($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('errors_code'));


		$sql = "	SELECT a.errors_code, a.errors_message, MAX(a.data_insert) data_insert, COUNT(a.errors_code) kol
					FROM amo_log_json a
					WHERE a.errors_code>0
					GROUP BY a.errors_code, a.errors_message
					ORDER BY 3 DESC  ";

		$row = PreExecSQL_all($sql,array());

		return $row;
	}


	// Наименование городов Етп
	function reqAmoCities($p=array()) {

		$sql = "	SELECT ac.id, ac.rid, ac.title
				FROM amo_cities ac
				WHERE 1=1
				ORDER BY ac.title ";

		$row = PreExecSQL_all($sql,array());

		return $row;
	}


	// Связь городов наших с Етп
	function reqAmoCitiesCitiesId($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id','amo_cities_id'));

		if($in['id']){
			$sql = 'AND acc.id=?';
			$arr = array($in['id']);
			$one = true;
		}
		if($in['amo_cities_id']){
			$sql = 'AND acc.amo_cities_id=?';
			$arr = array($in['amo_cities_id']);
			$one = true;
		}

		$sql = "	SELECT acc.id, acc.cities_id, acc.amo_cities_id, 
						ac.title, c.name cities_name
				FROM amo_cities_cities_id acc, amo_cities ac, a_cities c
				WHERE acc.amo_cities_id=ac.id AND acc.cities_id=c.id
						".$sql."
				ORDER BY ac.title  ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}
	
	
	// проверяем , если про аккаунт ЭТП и нет своей авторизации , то кнопку "купить" не показываем
	function reqProverkaEtpPromoAccountsBySell($p=array()) {
		
		$sql = "	SELECT (
						SELECT sq.promo
						FROM slov_qrq sq
						WHERE sq.id=".$p['qrq_id']." AND sq.promo=1
						) promo,
						(
						SELECT ae.id
						FROM amo_accounts_etp ae
						WHERE ae.qrq_id=".$p['qrq_id']." AND ae.company_id=".COMPANY_ID." AND ae.flag_autorize=2
						) flag_autorize  ";

		$row = PreExecSQL_one($sql,array());

		return $row;
	}
	
	
	// получаем accountsid для рользователя (с учетом промо)
	function reqAmoAccountsEtp_AccountsidByCompanyid2($p=array()) {
		
		$p['company_id'] = isset($p['company_id'])? $p['company_id'] : COMPANY_ID;
		
		$sql = "	SELECT GROUP_CONCAT(DISTINCT qw.accounts_id) accounts_ids
				FROM (
							SELECT (SELECT t.login_id FROM company t WHERE t.id=ae.company_id LIMIT 1) login_id,
									ae.company_id, ae.qrq_id, ae.accounts_id
							FROM slov_qrq sq, amo_accounts_etp ae
							WHERE sq.company_id=ae.company_id AND ae.qrq_id=sq.id AND ae.accounts_id>0 AND sq.promo=1 
									/*исключаем, что закреплено за компанию этп если подписан со своим логин/пароль*/
									AND NOT ae.qrq_id IN (	SELECT ttt.id FROM slov_qrq ttt
															WHERE ttt.company_id IN (
																SELECT tt.company_id FROM slov_qrq tt
																WHERE tt.id IN (SELECT t.qrq_id FROM amo_accounts_etp t WHERE t.company_id=".$p['company_id']." AND flag_autorize=2)
																		)
															)
							UNION ALL 
							SELECT (SELECT t.login_id FROM company t WHERE t.id=(SELECT t.company_id FROM slov_qrq t WHERE t.id=ae.qrq_id LIMIT 1) LIMIT 1) login_id,
									(SELECT t.company_id FROM slov_qrq t WHERE t.id=ae.qrq_id LIMIT 1) company_id,
									ae.qrq_id,
									CASE WHEN ae.flag_autorize=1 THEN (SELECT t.accounts_id 
													FROM amo_accounts_etp t, slov_qrq sq
													WHERE t.qrq_id=sq.id AND sq.flag_autorize=1 AND t.qrq_id=ae.qrq_id AND t.flag_autorize=3) 
												ELSE ae.accounts_id END accounts_id
							FROM amo_accounts_etp ae
							WHERE ae.company_id=".$p['company_id']."
						) qw
				WHERE qw.accounts_id>0  ";

		$row = PreExecSQL_one($sql,array());

		return $row;
	}
	

	// Insert - Добавить в cron searchid для дальнейшего использования в cron->cron_amo_buy_sell_searchupdate
	function reqInsertCronAmoBuysellSearchUpdate($p=array()) {


		$STH = PreExecSQL(" INSERT INTO cron_amo_buy_sell_searchupdate (buy_sell_id,token,searchid) VALUES (?,?,?); " ,
			array( $p['buy_sell_id'],$p['token'],$p['searchid'] ));
		if($STH){
			$ok = true;
		}

		return array('STH'=>$STH);
	}
	
	
	// получаем accountsid для рользователя (с учетом промо)
	function reqCronAmoBuySellSearchInfopart($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('cookie_session'));

		if($in['cookie_session']){
			$sql = ' AND ci.cookie_session=? ';
			$arr = array($in['cookie_session']);
			$one = true;
		}

		$sql = "	SELECT ci.id, ci.token, ci.searchid, ci.categories_id, ci.company_id_out, ci.cookie_session
				FROM cron_amo_buy_sell_search_infopart ci
				WHERE 1=1 ".$sql." ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}
	
	
	// активы с 1с (для дальнейшей привязки с нашими активами)
	function req1cTransport($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('id_1c','value','company_id'));
	
		$in['company_id'] = isset($in['company_id'])? $in['company_id'] : COMPANY_ID;

		if($in['id_1c']){
			$sql = ' AND t.id_1c=? ';
			$arr = array($in['id_1c']);
			$one = true;
		}
		if($in['value']){//часть наименования
			$sql .= " and ( LOWER(t.modelname) LIKE ? OR LOWER(t.regnumber) LIKE ? OR LOWER(t.lastdriver) LIKE ? ) ";
			array_push($arr , '%'.$in['value'].'%');
			array_push($arr , '%'.$in['value'].'%');
			array_push($arr , '%'.$in['value'].'%');
		}

		$sql = "	SELECT t.id, t.company_id, t.id_1c, t.modelname, t.regnumber, t.lastdriver, t.data1c,
						CONCAT(t.modelname,' (',t.regnumber,' ', t.lastdriver,')') modelname_regnumber
				FROM 1c_transport t
				WHERE t.company_id=".$in['company_id']." ".$sql." ";
	//vecho($sql);
		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// активы с 1с связанные с нашими активами
	function req1cTransportBuySell($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('buy_sell_id','id_1c'));

		if($in['buy_sell_id']){
			$sql = ' AND tbs.buy_sell_id=? ';
			$arr = array($in['buy_sell_id']);
			$one = true;
		}
		if($in['id_1c']){
			$sql = ' AND t.id_1c=? ';
			$arr = array($in['id_1c']);
			$one = true;
		}
		

		$sql = "	SELECT tbs.id, tbs.buy_sell_id, tbs.1c_transport_id,
						CONCAT(t.modelname,' (',t.regnumber,' ', t.lastdriver,')') modelname_regnumber
				FROM 1c_transport_buy_sell tbs, 1c_transport t
				WHERE tbs.1c_transport_id=t.id ".$sql." ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}

	// 
	function reqNosendEmail($p=array()) {
		$sql = '';
		$arr = array();
		$one = false;
		$in = fieldIn($p, array('email'));

		if($in['email']){
			$sql = ' AND t.email=? ';
			$arr = array($in['email']);
			$one = true;
		}

		$sql = "	SELECT t.id, t.email
				FROM nosend_email t
				WHERE 1=1 ".$sql."
				ORDER BY t.email ";

		$row = ($one)? PreExecSQL_one($sql,$arr) : PreExecSQL_all($sql,$arr);

		return $row;
	}
	
	
	
	
	
	/*  VIEWS

	***** view_grouping_id_kol_page_sell ******
	----- используется для reqBuySell_PageSell в качестве inner join

	SELECT
		qw.val, COUNT(qw.buy_sell_id) kol, qw.buy_sell_id, MIN(qw.cost) min_cost

	FROM (
			SELECT  bsa.buy_sell_id ,
				GROUP_CONCAT( IFNULL(bsa.value,bsa.attribute_value_id) ) val,
				bs.cost
			FROM buy_sell bs, buy_sell_attribute bsa
			WHERE bsa.buy_sell_id=bs.id
				AND bs.parent_id=0
				AND bsa.attribute_id IN (	SELECT ca.attribute_id
								FROM categories_attribute ca
								WHERE ca.categories_id=bs.categories_id AND ca.grouping_sell=1
							)
				AND bs.flag_buy_sell=1
				AND bs.status_buy_sell_id IN (2,3)
			GROUP BY bsa.buy_sell_id
			ORDER BY 2, bs.data_status_buy_sell_23 DESC
	) qw
	GROUP BY qw.val
	*************************************







	***** views_grouping_id_kol ******
	SELECT
		qw.val, COUNT(qw.buy_sell_id) kol, qw.buy_sell_id
	FROM (
			SELECT  bsa.buy_sell_id , GROUP_CONCAT( bsa.attribute_id ) attribute_ids,
				GROUP_CONCAT( IFNULL(bsa.value,bsa.attribute_value_id) ) val
			FROM buy_sell bs, buy_sell_attribute bsa
			WHERE bsa.buy_sell_id=bs.id AND bs.categories_id=41
				AND bs.parent_id=0
				AND bsa.attribute_id IN (	SELECT ca.attribute_id
								FROM categories_attribute ca
								WHERE ca.categories_id=bs.categories_id AND ca.grouping_sell=1
							)

			GROUP BY bsa.buy_sell_id
			ORDER BY 3, bs.cost
	) qw
	GROUP BY qw.val
	*************************************


	***** views_grouping_id_val ******
	SELECT  bsa.buy_sell_id ,
		GROUP_CONCAT( IFNULL(bsa.value,bsa.attribute_value_id) ) val
	FROM buy_sell bs, buy_sell_attribute bsa
	WHERE bsa.buy_sell_id=bs.id AND bs.categories_id=41
		AND bs.parent_id=0
		AND bsa.attribute_id IN (	SELECT ca.attribute_id
						FROM categories_attribute ca
						WHERE ca.categories_id=bs.categories_id AND ca.grouping_sell=1
					)

	GROUP BY bsa.buy_sell_id
	ORDER BY 2, bs.cost
	*************************************


	// для себя
	SELECT * FROM buy_sell
	WHERE login_id=565
	ORDER BY id DESC

	//

	Наименование всех заявок + артикул + вренд
	SELECT bs.id,
		CASE WHEN bs.name='' THEN (SELECT t.name FROM buy_sell t WHERE t.id=bs.copy_id) ELSE bs.name END `name` ,
		sb.status_buy, sc.categories,
		bsa3.attribute_value brend, bsa33.value articul
	FROM slov_categories sc, slov_status_buy_sell sb, buy_sell bs
	LEFT JOIN ( 	SELECT bsa.buy_sell_id, sav.attribute_value
			FROM attribute_value av, slov_attribute_value sav, buy_sell_attribute bsa
			WHERE bsa.attribute_value_id=av.id
				AND av.attribute_id=3 AND av.attribute_value_id=sav.id ) bsa3 ON bsa3.buy_sell_id=bs.id

	LEFT JOIN ( 	SELECT bsa.buy_sell_id, bsa.value
			FROM buy_sell_attribute bsa
			WHERE bsa.attribute_id=33) bsa33 ON bsa33.buy_sell_id=bs.id

	WHERE bs.categories_id=sc.id AND bs.status_buy_sell_id=sb.id AND		bs.company_id=1052


	ORDER BY bs.id DESC

	*/








?>
