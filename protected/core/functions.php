<?php
/**
 * Обработка url
 */
function argsRoute()
{
	if(empty($_GET['route'])) $GLOBALS['args']['0'] = 'mainpage';
	else foreach( explode('/', trim($_GET['route'], '/\\')) as $i=>$part) $GLOBALS['args']["$i"] = $part;

	return '';
}

/**
 * Инициализация системы
 */
function application()
{
	
	$ok = false;
	// ЧПУ Объявление/Предложение
		$args2 = getArgs(2);
		if($args2){
				$row_buysellone = reqBuySell_buysellone(array('url'=>$args2));
				if(!empty($row_buysellone)){
					$GLOBALS['row_buysellone'] = $row_buysellone;
					$class 	= 'buysellone';
					$ok		= true;
				}
		}
	///
		
	$class = ($ok)? $class : reqRoute($GLOBALS['args']['0']);

	if($class){
		$class = str_replace('-', '', 'controllers_'.$class);
		$file_exists = file_exists('protected/'.str_replace('_', '/', $class).'.php');
		if(!$file_exists) {
			//header("HTTP/1.0 404 Not Found"); //страница не найдена
			$class = 'controllers_404';
		}		
	}else{
		//header("HTTP/1.0 404 Not Found");
		$class = 'controllers_404';
	}
	
	$contr = new $class;

	return $contr->member;
}


/**
 * Автоподгрузка файлов классов (php 5.6)
 */
/*function __autoload($class_name)
{
	$path = str_replace('_', '/', $class_name.'.php');
	$pathProtected = 'protected/'.$path;

	if(file_exists($pathProtected)) require $pathProtected;
//echo($pathProtected.'</br>');
}*/

/**
 * Автоподгрузка файлов классов (php 7.3)
 */
spl_autoload_register(function ($class_name) {
	$path = str_replace('_', '/', $class_name.'.php');
	$pathProtected = 'protected/'.$path;

	if(file_exists($pathProtected)) require $pathProtected;
});

/**
 * Преобразование контента полей для приёма с клиента
 *
 * @author Ivan
 * @param array $arr входные данные
 * @param array $in необходимые данные
 * @return array
 */
function fieldIn($arr, $in)
{
	$res = array();
	foreach($in as $v => $type){
		if(gettype($v) == 'integer') $v = $type;				//если без типа
		elseif(isset($arr["$v"])) settype($arr["$v"], $type);	//преобразование типа

		if(isset($arr["$v"])) $res["$v"] = htmlspecialchars_decode(str_replace('\\"', '"', $arr["$v"]));	//декодирование
		else $res["$v"] = null;																				//
	}
	return $res;
}


//вернуть $_GET параметр между слешем
function getArgs($i=false)
{
	return ( isset($GLOBALS['args'][$i]) && !empty($GLOBALS['args'][$i]) ) ? $GLOBALS['args'][$i] : '';
}

//вернуть $_GET параметр после ?
function getGets($s=false)
{
	return ( isset($_GET[$s]) && !empty($_GET[$s]) ) ? $_GET[$s] : '';
}

//проверка на число
function v_int($value=false)
{
	return (preg_match('/^\+?\d+$/', $value))? true : false;
}


//редирект
function redirect($url)
{
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/'.$url);
}

//вывод результата
function vecho($v)
{
	$p = print_r($v,true);
	echo '<div id="php-error" class="php-error">
				'.$p.'
			</div>';
}

//форматирование цен
function format_price($value)
{
	return number_format($value, 2, ',', ' ');
}
 
//сумма прописью
function str_price($value)
{
	$value = explode('.', number_format($value, 2, '.', ''));
 
	$f = new NumberFormatter('ru', NumberFormatter::SPELLOUT);
	$str = $f->format($value[0]); //'';
 
	// Первую букву в верхний регистр.
	$str = mb_strtoupper(mb_substr($str, 0, 1)) . mb_substr($str, 1, mb_strlen($str));
 
	// Склонение слова "рубль".
	$num = $value[0] % 100;
	if ($num > 19) { 
		$num = $num % 10; 
	}	
	switch ($num) {
		case 1: $rub = 'рубль'; break;
		case 2: 
		case 3: 
		case 4: $rub = 'рубля'; break;
		default: $rub = 'рублей';
	}	
	
	return $str . ' ' . $rub . ' ' . $value[1] . ' копеек.';
}
//генерация уникального значения для yookassa
function gen_uuid() {
	return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
		mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
		mt_rand( 0, 0xffff ),
		mt_rand( 0, 0x0fff ) | 0x4000,
		mt_rand( 0, 0x3fff ) | 0x8000,
		mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
	);
}

//форматирование вводимых телефонных номеров
function normPhone($phone) {
	$resPhone = preg_replace("/[^0-9]/", "", $phone);
	if (strlen($resPhone) === 11) {
	$resPhone = preg_replace("/^8/", "7", $resPhone);
	}
	return $resPhone;
}
//Удаление дубликатов по одному ключу
function array_unique_key($array, $key) { 
	$tmp = $key_array = array(); 
	$i = 0; 
 
	foreach($array as $val) { 
		if (!in_array($val[$key], $key_array)) { 
			$key_array[$i] = $val[$key]; 
			$tmp[$i] = $val; 
		} 
		$i++; 
	} 
	return $tmp; 
}
//сравнение массивов
function array_values_equal($a, $b) {
    sort($a);
    sort($b);
    return $a === $b;
}
//различия массивов
function val_compare_func($a, $b)
{
    if(is_array($a) && is_array($b)) { 
        if(count($a) != count($b))
            return -1;
 
        foreach($a as $aKey => $aVal){ 
            if($aVal === $b[$aKey])
                continue;
            else
                return -1;
        }
 
        return 0;
    }
 
    if ($a === $b) {
        return 0;
    }
 
    return ($a > $b)? 1:-1;
}
//in array() в многомерном массиве
function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}

//поиск по ключу в многомерном массиве
function search($array, $key, $value)
{
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, search($subarray, $key, $value));
        }
    }

    return $results;
}
function phone_format($phone) 
{
	$phone = trim($phone);
 
	$res = preg_replace(
		array(
			'/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{3})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
			'/[\+]?([7|8])[-|\s]?(\d{3})[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
			'/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
			'/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',	
			'/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{3})/',
			'/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{3})[-|\s]?(\d{3})/',					
		), 
		array(
			'$2$3$4$5', 
			'$2$3$4$5', 
			'$2$3$4$5', 
			'$2$3$4$5', 	
			'$2$3$4', 
			'$2$3$4', 
		), 
		$phone
	);
 
	return $res;
}
?>