<?php
	/*
	 *  вспомогательные функции
	 */
	 
class HtmlServive extends HtmlElement 
{
	//Авторизация пользователя (ajax "change_account_company" не забыть)
	function AutorizeUser($p=array()){
		$_SESSION['login_id'] 		= $p['login_id'];
		
		// компания, под которой был последний раз авторизованный пользователь
		$rcl = reqCompanyLastSession(array('login_id'=>$p['login_id']));

		if($rcl['company_id']){
			$r = reqCompany(array('id'=>$rcl['company_id']));
		}else{
			// компания, под которой авторизован (или профиль)
			$r = reqCompany(array('login_id'=>$p['login_id'],'flag_account'=>1,'one'=>true));
		}
			
		$company_id 		= $r['id'];
		$company_id_1c 	= $r['id_1c'];
			
			
		$_SESSION['company_id'] 	= $company_id;
		
		$_SESSION['pro_mode']		= $r['pro_mode'];

		$_SESSION['flag_account'] 	= $r['flag_account'];
		// flag_account =  1-профиль (аккаунт зарегистрированного пользователя), 2 - компания, 3-несущест.поставщик
		
		$_SESSION['company_id_1c'] 	= $company_id_1c;
		
		
		$r = reqLoginCompanyPrava(array('login_id'=>$p['login_id'],'company_id'=>$company_id,'one'=>true));
		$_SESSION['prava'][ $r['prava_id'] ] = true;// не забудь отметить в config.php
		
		// авторизация со стороннем ресуром
			//$qrq		= new ClassQrq();
			//$token 	= $qrq->AuthorizationAmo();
			//$_SESSION['AMO_TOKEN'] 	= $token;
			$_SESSION['AMO_TOKEN'] 	= 'bd219dd9eb0f64d6e152d179dae9ba3dda6b4619';
		///
		
		// закрепление заявок/объявл за пользователем после авторизации/регистрации
		self::FixBuySellCompanyByCookieSession(array('company_id'=>$company_id,'login_id'=>$p['login_id']));
		
		// подписка на пользователя после регистрации
		self::SubscriptionsByCookieSession(array('company_id'=>$company_id));
		
		// очищаем дату последней отправки (чтобы приходили письма)
			$STH = PreExecSQL(" UPDATE company_page_visited_send SET data_last_send_email=NULL WHERE company_id=?; " ,
											array( $company_id ));
		///
		
		// Очищаем старые полученные данные ЭТП
			self::ClearBuySellEtpSell();
		///
		
		
		return '';
	}
	
	// MD5
	function vmd5($str){

		$rez = md5(MD5.$str);
		
		return $rez;
	}
	
	//создаем cookie с идентификатором сессии
	function CookieSession(){
		//создаем cookie на 5 лет
		if (!isset($_COOKIE['user_session'])&&empty($_COOKIE['user_session'])){
			setcookie("user_session",session_id(),time()+(1825*24*3600),"/");
			$cookie = session_id();
		}else{
			$cookie = $_COOKIE['user_session'];
		}
		
		define('COOKIE_SESSION', $cookie);// кук в переменную
		
		return '';
	}
	

	//возвращает дату формата отображения на странице
	//входящая формата "yyyy-mm-dd"
	function ReverceDate($date=array()){
		if(!empty($date)){
			$arr=explode('.',$date);
			$date = $arr[2].'-'.$arr[1].'-'.$arr[0];
		}
		return $date;
	}
	//возвращает сумму заменяя "," на "."
	function ReaplaceZap($value=false){
		$value = str_replace(' ','',$value);
		$value = str_replace(',','.',$value);
		return $value;
	}
	//телефон только цифры
	function ReaplacePhone($value=false){
		$value = str_replace('-','',$value);
		return $value;
	}
	//возвращает сумму заменяя "," на "."
	function nf($value=false){
				// Если 100,09, то показывает 100,09
				// Если 100,90, то показывает 100,9
				// Если 109,00, то показывает 100
		if($value){
			$arr = explode('.',$value);
			$arr1 = isset($arr[1])? $arr[1] : '';
			if($arr1=='00'){
				$value = number_format($arr[0], 0, ',', ' ');
			}elseif(substr($arr1,-1)==0){
				$value = number_format($value, 1, ',', ' ');
			}else{
				$value = number_format($value, 2, ',', ' ');
			}
		}
		
		return $value;
	}
	//возвращает телефон в формате
	function phone_number($n){
		$rez = '+7 ('.substr($n, 0,3).') '.substr($n,3,3).'-'.substr($n,6,2).'-'.substr($n,8,2);
		return $rez;
	}

	
	//возвращает JSON из базы
	function getJsonRow( $row=array() , $p=array() ){
		$q=$jsd=array();
		foreach($row as $i => $m){
				$a = array();
				foreach($p as $k=>$n){
					$a = array($k => $m[ $n ]);
					$q = array_merge($q,$a);
				}
				$jsd[] = $q;
		}
		return json_encode($jsd);
	}
	
	//склонение примитивных слов   'день', 'дня', 'дней'
	function format_by_count($count, $form1, $form2, $form3){
		$count = abs($count) % 100;
		$lcount = $count % 10;
		if ($count >= 11 && $count <= 19) return($form3);
		if ($lcount >= 2 && $lcount <= 4) return($form2);
		if ($lcount == 1) return($form1);
		return $form3;
	}
	//создаем папку
	function jmkDir($path){
		if(!is_dir($path)){
			mkdir($path, 0700);
		}
		return $path;
	}
	//удалить файл 
	function deleteFile($file=false){
		$file = $_SERVER['DOCUMENT_ROOT'].$file;
		@unlink($file);
		$rez = (file_exists($file))? false:true;
		return $rez;
	}
	//проверяем есть с таким именем файл в папке
	function FileExists($path=false,$file_name=false,$raz=false){
		if(file_exists($path.'/'.$file_name.'.'.$raz.'.vdo')){
				$file_name = $file_name.'_'.time();
		}
		
		return $file_name;
	}	
	
	
	//получаем позицию последнего пробела и обрезаем до нее строку
	function cropStr($str, $size){
		$len = strlen($str);
		if ($len>$size) {
			$str = substr($str,0, $size);
			$pos = strrpos($str, ' ' );
			$ttt = ($len>$pos)? ' ...':'';
			$str = substr($str, 0, $pos).$ttt;
		}
		return $str;
	}
	
	// день недели
	function NameDayofweek($dayofweek){
		if($dayofweek==2){
			$str = 'понед.';
		}elseif($dayofweek==3){
			$str = 'вторник';
		}elseif($dayofweek==4){
			$str = 'среда';
		}elseif($dayofweek==5){
			$str = 'четверг';
		}elseif($dayofweek==6){
			$str = 'пятница';
		}elseif($dayofweek==7){
			$str = 'суббота';
		}elseif($dayofweek==1){
			$str = 'воскр.';
		}
		
		return $str;
	}
	
	// генерация пароля
	function getPassword(){
		$chars = "qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
		$max = 8;
		$size = StrLen($chars)-1;
		$pass2 = '';
		while($max--)
			$pass2 .= $chars[rand(0,$size)];
		$pass = md5(MD5.$pass2);
		
		return array('pass'=>$pass2,'md5'=>$pass);
	}	
	
	//пагинация по страничная
	//пример ссылки - '/news.php?page={#}&id=1
	function pagination($all,$x,$prev,$curr_link,$link){//в ссылки заменяем {#} на номер страницы
		//осуществляем проверку, чтобы выводимые перваЯ и последняя страницы
		// не вышли за границы нумерации
		$str_page='';
		$first=$curr_link-$prev;
		if($first<1) $first=1;
		$last=$curr_link+$prev;
		if($last>ceil($all/$x))$last=ceil($all/$x);
		//начало вывода нумерации
		//выводим первую страницу
		$y=1;
		$link_y=str_replace('{#}',$y,$link);
		if($first>1) $str_page=$str_page.'<li class="page-item"><a href="/'.$link_y.'" class="page-link">1</a></li>';
		//если текущаЯ страница далеко от 1-й, то часть предыдущих страниц 
		//скрываем троеточием
		$y=$first-1;
		$link_y=str_replace('{#}',$y,$link);
		if($first>6) {
		   $str_page=$str_page.'<li class="page-item"><a href="/'.$link_y.'" class="page-link">...</a></li>';
		}
		//если текущаЯ страница имеет номер до 10, то выводим все номера 
		//перед заданным диапазоном без скрытиЯ 
		else {
		for($i=2;$i<$first;$i++){
			$link_i=str_replace('{#}',$i,$link);
			$str_page=$str_page.'<li class="page-item"><a href="/'.$link_i.'" class="page-link">$i</a></li>';	
		}
		}
		//отображаем заданный диапазон: текущаЯ страница +-$prev
		for($i=$first;$i<$last+1;$i++){
		//если выводитсЯ текущаЯ страница, то ей назначаетсЯ особый стиль css
			if($i==$curr_link){
				$str_page=$str_page.'	<li class="page-item active" aria-current="page">
										<span class="page-link">
											'.$i.'
											<span class="sr-only">(current)</span>
										</span>
									</li>';
			}else{
				$link_i=str_replace('{#}',$i,$link);
				$str_page=$str_page.'<li class="page-item"><a href="/'.$link_i.'" class="page-link">'.$i.'</a></li>';
			}
				
		}
		$y=$last+1;
		$link_y=str_replace('{#}',$y,$link);
		//часть страниц скрываем троеточием
		if($last<ceil($all/$x) and ceil($all/$x)-$last>0) $str_page=$str_page.'<li class="page-item"><a href="/'.$link_y.'" class="page-link">...</a></li>';
		//выводим последнюю страницу
		$e=ceil($all/$x);
		$link_e=str_replace('{#}',$e,$link);
		if($last<ceil($all/$x)) $str_page=$str_page.'<li class="page-item"><a href="/'.$link_e.'" class="page-link">$e</a></li>';

		$pcl = $ncl = '';
		$iprev = 'href="/'.str_replace('{#}',$curr_link-1,$link).'"';
		$inext = 'href="/'.str_replace('{#}',$curr_link+1,$link).'"';
		if($curr_link==1){
			//$pcl = ' class="disabled"';
			$pcl = 'disabled';
			$iprev = '';
		}
		if($curr_link==$e){
			//$ncl = ' class="disabled"';
			$ncl = 'disabled';
			$inext = '';
		}
		
		$code='';
		$code = '<nav aria-label="Page navigation">
					<ul class="pagination">
						<li class="page-item '.$pcl.'">
							<a class="page-link" '.$iprev.' aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
						'.$str_page.'
						<li class="page-item '.$ncl.'">
							<a class="page-link" '.$inext.' aria-label="Next">
								<span aria-hidden="true">&raquo;</span>
							</a>
						</li>
					</ul>
				</nav>
				';		
		
		//if(ceil($all/$x)>1){
		/*
			$code = '<ul class="pagination">
						<li'.$pcl.'><a '.$iprev.'>&laquo;</a></li>
						'.$str_page.'
						<li'.$ncl.'><a '.$inext.'>&raquo;</a></li>
					</ul>';
		*/
		//}
		/*
		<nav aria-label="Page navigation example">
		  <ul class="pagination">
			<li class="page-item">
			  <a class="page-link" href="#" aria-label="Previous">
				<span aria-hidden="true">&laquo;</span>
			  </a>
			</li>
			<li class="page-item"><a class="page-link" href="#">1</a></li>
			<li class="page-item"><a class="page-link" href="#">2</a></li>
			<li class="page-item"><a class="page-link" href="#">3</a></li>
			<li class="page-item">
			  <a class="page-link" href="#" aria-label="Next">
				<span aria-hidden="true">&raquo;</span>
			  </a>
			</li>
		  </ul>
		</nav>
		
		*/
		
		return $code;
		
	}

	// Транслитерация строк.
	function rus2translit($string) {
		$converter = array(
			'а' => 'a',   'б' => 'b',   'в' => 'v',
			'г' => 'g',   'д' => 'd',   'е' => 'e',
			'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
			'и' => 'i',   'й' => 'y',   'к' => 'k',
			'л' => 'l',   'м' => 'm',   'н' => 'n',
			'о' => 'o',   'п' => 'p',   'р' => 'r',
			'с' => 's',   'т' => 't',   'у' => 'u',
			'ф' => 'f',   'х' => 'h',   'ц' => 'c',
			'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
			'ь' => '',    'ы' => 'y',   'ъ' => '',
			'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
			
			'А' => 'A',   'Б' => 'B',   'В' => 'V',
			'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
			'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
			'И' => 'I',   'Й' => 'Y',   'К' => 'K',
			'Л' => 'L',   'М' => 'M',   'Н' => 'N',
			'О' => 'O',   'П' => 'P',   'Р' => 'R',
			'С' => 'S',   'Т' => 'T',   'У' => 'U',
			'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
			'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
			'Ь' => '',    'Ы' => 'Y',   'Ъ' => '',
			'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
		);

		// переводим в транслит
		$str = strtr($string, $converter);
		// в нижний регистр
		$str = strtolower($str);
		// заменям все ненужное нам на "-"
		$str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
		// удаляем начальные и конечные '-'
		$str = trim($str, "-");
		
		return $str;
	}
	
	//выделение текста
	function SearchTextSelect($search=false,$text=false){
		//setlocale(LC_ALL, 'ru_RU.CP1251');
		//if($search){
				$search = preg_quote($search,'/');
				//$text = preg_quote($text,'/');
				//$regime = 0;// Режим поиска (1 - точный поиск, 0 - вхождение)
				/* Точный поиск. (Найдёт: "...не [B]про[/B] меня", 
				Не найдёт "Этот ком[U]про[/U]мат не..." - ) отдельное слово */
				//if($regime == 1){
				//	$patterns = "/(\b".$search."\b)+/i";// Регулярное выражение
				//}else{
					$patterns = "/($search)/iu";// Регулярное выражение
				//}
				$replace = "<span class='search_text'>$1</span>";// На что заменить
				
				$text = preg_replace($patterns,$replace,$text);// Замена
		//}

		return $text;
	}

	// Транслитерация строк для поиска с 
	function EngRusFlipReplace($string) {
		$arr = array(
			'q'=>'й', 'w'=>'ц', 'e'=>'у', 'r'=>'к', 't'=>'е', 'y'=>'н', 
			'u'=>'г', 'i'=>'ш', 'o'=>'щ', 'p'=>'з', '['=>'х', ']'=>'ъ', 
			'a'=>'ф', 's'=>'ы', 'd'=>'в', 'f'=>'а', 'g'=>'п', 'h'=>'р', 
			'j'=>'о', 'k'=>'л', 'l'=>'д', ';'=>'ж', "'"=>'э', 'z'=>'я',
			'x'=>'ч', 'c'=>'с', 'v'=>'м', 'b'=>'и', 'n'=>'т', 'm'=>'ь', 
			','=>'б', '.'=>'ю', '/'=>'.', '`'=>'ё', 'Q'=>'Й', 'W'=>'Ц',
			'E'=>'У', 'R'=>'К', 'T'=>'Е', 'Y'=>'Н', 'U'=>'Г', 'I'=>'Ш', 
			'O'=>'Щ', 'P'=>'З', '{'=>'Х', '}'=>'Ъ', 'A'=>'Ф', 'S'=>'Ы', 
			'D'=>'В', 'F'=>'А', 'G'=>'П', 'H'=>'Р', 'J'=>'О', 'K'=>'Л',
			'L'=>'Д', ':'=>'Ж', '"'=>'Э', '|'=>'/', 'Z'=>'Я', 'X'=>'Ч', 
			'C'=>'С', 'V'=>'М', 'B'=>'И', 'N'=>'Т', 'M'=>'Ь', '<'=>'Б',
			'>'=>'Ю', '?'=>',', '~'=>'Ё', '@'=>'"', '#'=>'№', '$'=>';',
			'^'=>':', '&'=>'?');

		// переводим в транслит (на русское, что пришло)
		$rus = strtr($string, $arr);
		// переводим в транслит (на английское, что пришло)
		$arr = array_flip($arr);
		$eng = strtr($string, $arr);
		
		return array('rus'=>$rus , 'eng'=>$eng);
	}
	
	//отправка через phpMailer по SMTP
	//	$rez = $g->sendMail(array(	'email'=>'filler98@yandex.ru' , 'name'=>'98Filler98' , 
	//								'subject'=>'Тестовое' , 'body'=>'<h1>Главная</h1>' , 
	//								'files' => array(IMG_ROOT_PATH.'13/avatar.jpg'=>'jpg' , IMG_ROOT_PATH.'13/191/1465503406.png'=>'png') ));
	function sendMail( $p=array() ){
		$p['altbody']	= (isset($p['altbody'])&&!empty($p['altbody']))? 	$p['altbody'] : strip_tags($p['body']);
		$p['files'] 	= (isset($p['files'])&&!empty($p['files']))? 		$p['files'] : '';
		
		$rez = false;
		
		$arr = array('admin@qw.qw','armtek_SAM@armtek.ru','autopiter_SAM@autopiter.ru'); // не отправлять на email
		if (!in_array($p['email'], $arr)) {	

				$username = 'info@qrq.ru';
				$password = 'E0e%OpuJ';
			
				$mail = new PHPMailer;
				
				$mail->isSMTP();
				
				//$mail->SMTPDebug  = 2;
 				$mail->Host 		= 'smtp.beget.com';
				$mail->Port 		= 465;
				$mail->Username 	= $username; 			// логин от вашей почты
				$mail->Password 	= $password; 			// пароль от почтового ящика
				$mail->From 		= $username; 			// адрес почты, с которой идет отправка	
				$mail->FromName 	= "QuestRequest"; 		// имя отправителя
				$mail->SMTPSecure	= 'ssl';
				$mail->SMTPAuth 	= true; 


				$mail->CharSet = "UTF-8";
				$mail->isHTML(true);
				//$mail->Encoding = '8bit';

				$mail->addAddress($p['email'], $p['name']);

				$mail->Subject 	= $p['subject'];
				$mail->Body 		= $p['body'];
				$mail->AltBody 	= $p['altbody'];
				//привязка файлов
				if($p['files']){
					foreach($p['files'] as $k=>$v){
						$mail->addAttachment($k, $v);
					}
				}
				// $mail->SMTPDebug = 1;
				if( $mail->send() ){
					$rez = true;
				}else{
					$rez = false;
					echo 'Ошибка: ' . $mail->ErrorInfo;
				}
				
			
		}
		
		return $rez;
	}
	
	
	function get_cities_id_by_ip($ip){
		/*$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://ipgeobase.ru:7020/geo?ip='.$ip);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$data = curl_exec($ch);
		$ip_answer = simplexml_load_string($data);

		$city = ($ip_answer -> ip[0] -> city);
		curl_close($ch);
		
		$city = ($city)? $city : 'Москва';
		*/
		// не работает ipgeobase , временно все Уфа
		$city = 'Уфа';
		
		$r = reqCities(array('name' => $city));

		return array('cities_id'=>$r['id'],'cities_name'=>$r['name']);
	}
	
	
	// Можно показывать телефон Объявления/Предложения
	function ProverkaViewPhone( $p=array() ){
		$in = fieldIn($p, array('buy_sell_id'));
		$ok = false;
		
		$row = reqBuySell_SaveBuyOffer(array('id'=>$in['buy_sell_id']));
		if( $row['parent_id']==0 &&( $row['status_buy_sell_id']==2||$row['status_buy_sell_id']==3||$row['company_id']==COMPANY_ID) ){
			$ok 	= true;
		}elseif($row['parent_id']){// Предложение - проверяем доступность, могут смотреть от кого заявка или кто дал предложение
			$r = reqBuySell_SaveBuyOffer(array('id'=>$row['parent_id']));
			if($r['company_id']==COMPANY_ID||$row['company_id']==COMPANY_ID){
				$ok 			= true;
			}
		}
		

		return array('ok'=>$ok,'row_buy_sell'=>$row);
	}
	
	// SQL доп запрос, "Интересы" (лучше сгенерить в момент сохранения интереса в профиле и хранить в table->company)
	function SqlCompanyInterests( $p=array() ){
		
		$p['company_id'] 	= isset($p['company_id'])&&(!empty($p['company_id']))? 			$p['company_id'] 	: COMPANY_ID;
		$p['login_id'] 		= isset($p['login_id'])&&(!empty($p['login_id']))? 				$p['login_id'] 		: '';
		$p['interests_id'] 	= isset($p['interests_id'])&&(!empty($p['interests_id']))? 		$p['interests_id'] 	: '';
		
		$sql = $code = $sql_login_id = '';
		$arr_sql = array();
		
		if($p['login_id']){
			$sql_login_id = " AND t.login_id=".$p['login_id']." ";
		}
		
		$row = reqInterestsCompanyParamGroupInterestsId(array(	'login_id'		=> $p['login_id'],
																'company_id'	=> $p['company_id'],
																'flag'			=> $p['flag'],
																'interests_id'	=> $p['interests_id'] ));

		foreach($row as $i => $m){
				
				$arr = array();
				$r = reqInterestsCompanyParamGroupInterestsParamId(array('login_id'=>$p['login_id'],'company_id'=>$p['company_id'],'company_id'=>$p['company_id'],'interests_id'=>$m['interests_id']));
				foreach($r as $ii => $mm){
						
						$code = str_replace('{AS}',				'bs',					$mm['sql_value']);
						$code = str_replace('{INTEREST_ID}',		$m['interests_id'],		$code);
						$code = str_replace('{COMPANY_ID}',		$p['company_id'],		$code);
						$code = str_replace('{LOGIN_ID}',		$sql_login_id,				$code);
						
						$arr[] = $code;
						
				}
				
				$arr_sql[] = ' ( '.implode(' AND ',$arr).' ) ';
		}

		$sql = ($arr_sql)? ' AND ( '.implode(' OR ',$arr_sql).' ) ' : '';

		return $sql;
	}
	
	// закрепление заявок/объявл за пользователем после регистрации
	function FixBuySellCompanyByCookieSession( $p=array() ){
		$bs	 = new HtmlBuySell();
		$STH = false;
		
		$p['company_id'] = isset($p['company_id'])&&(!empty($p['company_id']))? $p['company_id'] : '';

		if($p['company_id']){
			$STH = PreExecSQL(" UPDATE buy_sell t SET t.company_id=? , t.login_id=?
																WHERE t.id IN (
																				SELECT c.buy_sell_id 
																				FROM buy_sell_cookie c 
																				WHERE c.cookie_session=?
																				) AND t.company_id=0 " ,
							array( $p['company_id'],$p['login_id'],COOKIE_SESSION ));
			if($STH){// очищаем свои куки привязку
					$STH = PreExecSQL(" DELETE FROM buy_sell_cookie WHERE cookie_session=? " ,
									array( COOKIE_SESSION ));
					$contents = file_get_contents('https://qrq.ru/cron/cron_cache_buy_sell');
			}
			
						
			
		}
								
		return $STH;
	}
	
	// подписка на пользователя после авторизации/регистрации
	function SubscriptionsByCookieSession( $p=array() ){
		$STH = false;
		
		$p['company_id'] = isset($p['company_id'])&&(!empty($p['company_id']))? $p['company_id'] : '';

		if($p['company_id']){
			
			$r = reqSubscriptionsNoAutorize(array('cookie_session'=>COOKIE_SESSION));
			
			if(!empty($r)){
			
				$STH = PreExecSQL(" INSERT INTO subscriptions (company_id_in,company_id_out) VALUES (?,?); " ,
											array( $p['company_id'],$r['company_id_from'] ));
								
			}
			
			if($STH){// очищаем свои куки привязку
					$STH = PreExecSQL(" DELETE FROM subscriptions_no_autorize WHERE cookie_session=? " ,
							array( COOKIE_SESSION ));
			}
		}
								
		return $STH;
	}
	
	
	// Формируем Url для - Поделиться отправка email/копия
	function getShareBuySellUrl( $p=array() ){
		$db = &$GLOBALS['db'];
		//$in = fieldIn($p, array('ids','flag_buy_sell','email','share_url','name','comments'));
		$p['ids'] = (isset($p['ids'])&&!empty($p['ids']))? $p['ids'] : '0';
		
		$url = '';
		$arr_error = array();
		$validate_email = true;// по умолчанию
		
		if($p['flag']==1){// отправка на email
			$validate_email = (filter_var($p['email'], FILTER_VALIDATE_EMAIL));
		}
		
		$share_url = self::vmd5(time());
		
		$row = reqBuySellRowShare($p['ids']);
		
		if(!empty($row)&&$validate_email){
			$STH = PreExecSQL(" INSERT INTO buy_sell_share (company_id_to,email,share_url,name,comments,company_id_from)VALUES(?,?,?,?,?,?); " ,
										array( $p['company_id'],$p['email'],$share_url,$p['name'],$p['comments'],COMPANY_ID ));
			if($STH){
				$i = 0;
				$buy_sell_share_id = $db->lastInsertId();
				foreach($row as $i => $m){
						$STH = PreExecSQL(" INSERT INTO buy_sell_share_ids (buy_sell_share_id,buy_sell_id) VALUES (?,?); " ,
												array( $buy_sell_share_id,$m['id'] ));
						$i++;
				}				
			}
			
			if($i>0){
				if($p['flag_buy_sell']==1){
					$page = 'sell';
				}else{
					$page = 'buy';
				}
				$url = 'https://'.$_SERVER['SERVER_NAME'].'/'.$page.'?share='.$share_url;
			}			
			
		}elseif(empty($row)&&($p['flag']==1)){
			$arr_error[] = 'не выбрано';
		}elseif(!$validate_email){
			$arr_error[] = 'не корректный email';
		}
		
		if($p['flag_buy_sell']==1&&!v_int($p['company_id'])&&($p['flag']==1)){
			$arr_error[] = 'не выбрана компания';
		}
		
		$code_error = implode(', ',$arr_error);
		
						
		return array('error'=>$code_error,'url'=>$url);
	}
	
	
	// cities_id из Компании или IP
	function CitiesIdByCompanyOrIp( $p=array() ){

		if(COMPANY_ID){
			$company 	= reqCompany(array('id'=>COMPANY_ID));
			$cities_id		= $company['cities_id'];
			$cities_name	= $company['cities_name'];
		}else{
			$arr_cities = $this->get_cities_id_by_ip($_SERVER['REMOTE_ADDR']);
			$cities_id		= $arr_cities['cities_id'];
			$cities_name	= $arr_cities['cities_name'];
		}

			
		return array('cities_id'=>$cities_id,'cities_name'=>$cities_name);
	}
	
	
	
	// Проверяем сотрудника и пришлашаем , добавляем
	function AddInviteWorkers( $in=array() ){
		$db = &$GLOBALS['db'];
		$t	= new HtmlTemplate();
		$tes	= new HtmlTemplateEmailSms();
		
		$ok = false;
		$code = '';
		
		$arr_prava = array(2,3,4,5,6,7);// id прав из slov_prava
		if (in_array($in['prava_id'], $arr_prava)) {
			
			$login = reqLogin(array('email'=>$in['email']));
			// Аккаунт есть в системе, сразу добавляем
			if($login['id']&&$login['id']<>LOGIN_ID){
					
					// Права и Роль пользователя на компанию
					$STH = reqInsertLoginCompanyPrava(array(	'login_id'		=> $login['id'],
																'position'		=> $in['position'],
																'company_id'	=> COMPANY_ID,
																'prava_id'		=> $in['prava_id'] ));
					if($STH){
						$id = $db->lastInsertId();
						$ok = true;
						$profile = reqCompany(array('login_id'=>$login['id'],'flag_account'=>1,'one'=>true));
						
						// чтобы авторизация была под этой компанией
						$STH = PreExecSQL(" INSERT INTO company_last_session (login_id,company_id) VALUES (?,?); " ,
												array( $login['id'] , COMPANY_ID ));
						
						// Отправляем письмо с приглашением
						$tes->LetterSendInviteWorkers(array(	'email'		=> $profile['email_login'],
															'name'		=> $in['name']));
						// html сотрудника 
						$code = $t->HtmlInviteWorkers(array(	'id' 		=> $id,
															'flag' 		=> 1,
															'prava_id' 	=> $in['prava_id'],
															'avatar' 	=> $profile['avatar'],
															'name' 		=> $profile['company'],
															'position' 	=> $in['position'],
															'phone' 	=> $profile['phone'],
															'email' 	=> $profile['email_login'] ));
					}
					
			}else{// сохраняем email и добавляем сотрудника при регистрации этого email в системе
				
					$STH = PreExecSQL(" INSERT INTO invite_workers(company_id,email,name,position,prava_id) VALUES (?,?,?,?,?); " ,
																	array( COMPANY_ID,$in['email'],$in['name'],$in['position'],$in['prava_id'] ));
					if($STH){
						$id = $db->lastInsertId();
						$ok = true;
						// Отправляем письмо с приглашением
						$tes->LetterSendInviteWorkers(array(	'email'		=> $in['email'],
															'name'		=> $in['name']));
						// html сотрудника 
						$code = $t->HtmlInviteWorkers(array(	'id' 		=> $id,
															'flag' 		=> 2,
															'prava_id' 	=> $in['prava_id'],
															'avatar' 	=> '/image/profile-icon.png',
															'name' 		=> $in['name'],
															'position' 	=> $in['position'],
															'phone' 	=> '',
															'email' 	=> $in['email'] ));
					}
			}
			
		}else{
			$code = 'Такой роли нет';
		}

			
		return array('ok'=>$ok,'code'=>$code);
	}

	
	// 
	function ProverkaAndInsertSlovAttributeValue( $p=array() ){
		$db = &$GLOBALS['db'];
		
		$in = fieldIn($p, array('categories_id','attribute_id','attribute_value','flag'));
		
		$attribute_value_id = $id = $flag_insert = false;
		
		$company_id = $r['id'] = 0;
		
		$attribute_value = $in['attribute_value'];

		if($in['flag']=='buy_sell'&&COMPANY_ID){// пользователь добавляет атрибут
			$r 			= reqAttributeValue(array('id'=>$attribute_value));
			$flag_insert 	= 3;
			$company_id	= COMPANY_ID;
			$flag_insert	= true;
		}elseif($in['flag']=='qrq'){
			$r['id'] 	= 0;
			$flag_insert 	= 2;
			$flag_insert	= true;
		}

		if( !$r['id'] && $flag_insert ){
			// 1 шаг, добавляем в словарь атрибутов
				$STH = PreExecSQL(" INSERT INTO slov_attribute_value(attribute_id,attribute_value,flag_insert,company_id) VALUES (?,?,?,?); " ,
																		array( $in['attribute_id'],$attribute_value,$flag_insert,$company_id ));
				//vecho(array( $in['attribute_id'],$attribute_value,$flag_insert ));
				if($STH){
					$id = $db->lastInsertId();
					
					// 2 шаг, добавляем в связь категорий и атрибутов
						$STH = PreExecSQL(" INSERT INTO attribute_value(categories_id,attribute_id,attribute_value_id) VALUES (?,?,?); " ,
																		array( $in['categories_id'],$in['attribute_id'],$id ));
						if($STH){
							$attribute_value_id = $db->lastInsertId();
						}

				}
		}else{
			$attribute_value_id = $r['id'];
		}

			
		return array('attribute_value_id'=>$attribute_value_id , 'slov_attribute_value_id'=>$id);
	}
	
	
	// возвращет для страницы подписки данные из базы
	function rowCompanySubscriptions( $p=array() ){
		$row = array();
		$in = fieldIn($p, array('views','categories_id','cities_id','value','start_limit'));
		// страница - Все пользователи
		if($in['views']=='profile'){
				$row = reqCompanySubscriptions(array('start_limit' 		=> $in['start_limit'],
													'categories_id' 	=> $in['categories_id'],
													'cities_id' 		=> $in['cities_id'],
													'value' 			=> $in['value'] ));
		}
		// страница - Покупатели
		elseif($in['views']=='profile-buy'){
				$row = reqCompanySubscriptions(array('start_limit' 		=> $in['start_limit'],
													'who2'				=> 1 ));
		}
		// страница - Продавцы
		elseif($in['views']=='profile-sell'){
				$row = reqCompanySubscriptions(array('start_limit' 		=> $in['start_limit'],
													'who1'				=> 1 ));
		}// страница - Подписки
		elseif($in['views']=='my'){
				$row = reqCompanySubscriptions(array('start_limit' 		=> $in['start_limit'],
													'flag'				=> 'subscriptions-my' ));
		}// страница - Подписчики
		elseif($in['views']=='me'){
				$row = reqCompanySubscriptions(array('start_limit' 		=> $in['start_limit'],
													'flag'				=> 'subscriptions-me' ));
				
		}
	
		return $row;
	}
	
	
	// формируем ссылку для отключения оповещения
	function HrefStopEmail( $p=array() ){

		$in = fieldIn($p, array('login_id','company_id','notification_id'));

		$vlogin_id = self::vmd5($in['login_id']);
		$vcompany_id = self::vmd5($in['company_id']);
		
		$href_notification_id = ($in['notification_id'])? '/'.$in['notification_id'] : '';

		$href = 'https://'.$_SERVER['SERVER_NAME'].'/stop-notification/'.$vlogin_id.'/'.$vcompany_id.$href_notification_id;

		return $href;
	}
	
	// возвращет для страницы сообщения данные из базы
	function rowChatMessages( $p=array() ){
		$row = array();
		$in = fieldIn($p, array('views','company_id','companies_id','status','value','folder_id','start_limit'));
	
		// страница - Все сообщения
		if($in['views']=='messages'){
				$row = reqChatFolders(array(	'start_limit' 	=> $in['start_limit'],
                                                'archive'       => 'false'
												));

		}
		// страница - Открытая тема
		elseif($in['views']=='open-chats'){
				$row = reqChatFolders(array(	'start_limit' 	=> $in['start_limit'],
												'status'		=> 1 ));
													
													
		}
		// страница - Архив
		elseif($in['views']=='arhive-chats'){
				$row = reqChatFolders(array(	'start_limit' 	=> $in['start_limit'],
												'status'		=> 2,
                                                'archiveTrue'   => 'true'));
                // vecho($row);
		}
		// страница - Без темы
		elseif($in['views']=='wt-chats'){
				$row = reqChatFolders(array(	'start_limit' 	=> $in['start_limit'],
												'status'		=> 1,
												'archive'       => 'false',
                                                'folderReq' => true));
                // vecho($row);
		}	
		return $row;
	}
	
	
	// Очищаем старые полученные данные ЭТП
	function ClearBuySellEtpSell( $p=array() ){

			$row = reqBuySellEtpSell(array( 'cookie_session'=>COOKIE_SESSION ));

			foreach($row as $i => $m){
				$sql = "	DELETE FROM buy_sell WHERE id=? ";

				$STH = PreExecSQL($sql,array($m['buy_sell_id']));
			}

		return '';
	}
	
}
?>
