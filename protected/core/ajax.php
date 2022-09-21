<?php
/**
 * Ajax запросы
 */
$db = &$GLOBALS['db'];
$jsd = array();
$code = '';
$row=$r=array();

//POST данные по типу
$in = array('email', 'pass', 'pass_again', 'id'=>'integer', 'value', 'flag', 'parent_id', 'categories', 'level',
    'login_id','phone_email_code','phone_email','new_pass','new_pass_again',
    'attribute', 'active',
    'mclass', 'views',
    'categories_id', 'unit_id', 'unit_group_id', 'attribute_id', 'table' , 'limit_sell' , 'limit_buy', 'desc_sell', 'desc_buy', 'keywords_buy', 'keywords_sell','description_buy','description_sell',
    'no_empty_name','no_empty_file','assets',
    'who1', 'who2', 'name', 'phone', 'phone2', 'legal_entity_id', 'company', 'position', 'tax_system_id', 'cities_id',
    'flag_buy_sell', 'status', 'urgency_id', 'delivery_id', 'currency_id', 'comments', 'cost', 'form_payment_id', 'amount' ,
    'note' , 'buy_sell_id' , 'articul', 'comments_company', 'responsible', 'responsible_id', 'availability',
    'multiplicity','min_party','cost1', 'companyName',
    'company_id','notification_id','interests_id','interests_param_id','share_url','prava_id',
    'start_limit','flag_limit','where','nomenclature_id','id_1c','qrq_id','flag_search','flag_interests',
    'amount1','unit_id1','amount2','unit_id2',
    'search_categories_id', 'address', 'stock', 'stock_id', 'company_id2','assets_id',
    '1c_nomenclature_id',
    'login','token','accounts_id',
    'inn','kpp','rschet','bik','korr_schet','ur_adr','type_skills','total','balance',
    'subject','messagetext','companies','potrbs','mid','fid','cid','url','media','ticket_text','vaznost','ticket_flag','ticket_id','user_id',
    'group','group_id','sort_12','sort_who','flag_search',
    'status_buy_sell_id','promo','vendorid','enter13',
    'errors_code','name_error','name_error_qrq','name_error_etp','next_etp','company_id3',
    'amo_cities_id', 'text', 'type'
);

$in = fieldIn($_POST, $in);


/*
*** 	BEGIN  -  НЕ АВТОРИЗОВАННОМУ ПОЛЬЗОВАТЕЛЮ
 */

//авторизация
if($_GET['route'] == 'authorization'){
    $ok=false;// *bls6yNZ   // rs0%5NZ*
    if(!empty($in['email'])&&!empty($in['pass'])){
        $pass = $g->vmd5($in['pass']);
        $row = reqLogin(array('email'=>$in['email'],'pass'=>$pass));
        //$row['id'] = 634;
        if(!empty($row['id'])&&$row['active']==1){
            $g->AutorizeUser(array( 'login_id'=>$row['id'] ));//авторизация пользователя
            $ok = true;
        }elseif(!empty($row['id'])&&$row['active']<>1){
            $code = 'Нет доступа';
        }else{
            $code = 'Неверный логин или пароль!';
        }
    }else{
        $code = 'Неверно введен логин или пароль!';
    }

    $jsd['ok']          = $ok;
    $jsd['code']        = $code;
}

if($_GET['route'] == 'searchOnMessages'){
   
   $ok = true;
   if(strlen($in['text']) > 0){
   $sql = 'SELECT t.*, tf.folder_name, tf.id folder_id_links FROM tickets t  LEFT JOIN tickets_folder tf ON tf.id = t.folder_id WHERE t.ticket_exp LIKE "%' . $in['text'] . '%" AND t.company_id=' . COMPANY_ID . ' AND t.ticket_status=0 ORDER BY id DESC';
    $STH = PreExecSQL_all($sql, []);  
    $sql2 = "SELECT * FROM tickets_folder tf WHERE tf.owner_id = " . COMPANY_ID . " GROUP BY tf.companies_id" ;
    // vecho($STH);
    $STH2 = PreExecSQL_all($sql2, []);  
    $sql3 = "SELECT * FROM tickets_folder WHERE folder_name LIKE '%" . $in['text'] . "%'";
    $STH3 = PreExecSQL_all($sql3, []);  
    // vecho($STH);  
    $arr = [];
    $tr = $tr1 = $tr2 = '';
    foreach($STH as $k){
        $company = array_diff(json_decode($k['companies']), [COMPANY_ID]);
        $sql = "SELECT * FROM company WHERE id=?";
        // vecho($company[1]);
        $com = PreExecSQL_one($sql,[$company[1]]);

        $folderName = (!empty($k['folder_name'])) ? $k['folder_name']: $com['company'];
        // vecho($k);
        $tr .= " <div class='subs-item row'>
                        <div class='subs-icon col-1'>

                        </div>
                        <div class='subs-info col-11 row'>
                          
                            <div class='subs-cat col-7'>
                                <a href='/chat/messages/" . $k['folder_id'] . "#" . $k['id'] ."'>" . $folderName ."</a><br />
                                <span>" . $k['ticket_exp'] . "</span> 
                            </div>
                            
                            <div class='subs-place col-2'>
                               
                            
                                  
                                <small class='_status-bar__time'>". $k['data_insert'] ."</small>
                            </div>                          
                        </div>
                    </div>
            ";
    }
    // foreach($STH2 as $k){
        
    //     $company = array_diff(json_decode($k['companies_id']), [COMPANY_ID]);
    //     foreach ($company as $k) {
          
        
    //     $sql = "SELECT * FROM company WHERE id=?" . " AND company LIKE '%" . $in['text'] . "%'";

    //     // vecho($company[1]);
    //     $com = PreExecSQL_one($sql,[$k]);

    //     // $folderName = (!empty($k['folder_name'])) ? $k['folder_name']: $com['company'];
    //     if(!empty($com))
    //         $tr1 .= " <div class='subs-item row'>
    //                     <div class='subs-icon col-1'>

    //                     </div>
    //                     <div class='subs-info col-11 row'>
                          
    //                         <div class='subs-cat col-7'>
    //                             <a href='/chat/messages/'>" . $com['company'] ."</a><br />

    //                         </div>
                            
    //                         <div class='subs-place col-2'>
                               
                            
                                  

    //                         </div>                          
    //                     </div>
    //                 </div>
    //         ";
    //         }
    // }
    foreach($STH3 as $k){
        
        $tr2 .= " <div class='subs-item row'>
                        <div class='subs-icon col-1'>

                        </div>
                        <div class='subs-info col-11 row'>
                          
                            <div class='subs-cat col-7'>
                                <a href='/chat/messages/" . $k['id'] ."'>" . $k['folder_name'] ."</a><br />
                                
                            </div>
                            
                            <div class='subs-place col-2'>
                               
                            
                            </div>                          
                        </div>
                    </div>
            ";
    }
    $row = $t->rowChatMessages(array(    'start_limit'   => 0,
                                                    'views'         => 'messages' ));
    $STH3 = '';
    $arrayOn = [];
    foreach ($row as $v) {
         $company = json_decode($v['companies_id']);
         if(!empty($company)){
         foreach ($company as $k) {
              $sql = "SELECT t.*, c.company company_name, tf.avatar FROM tickets t LEFT JOIN company c ON c.id = t.company_id LEFT JOIN tickets_folder tf ON tf.id = t.folder_id WHERE t.folder_id=" . $v['id'] . " AND t.company_id=" . $k . " AND c.company LIKE '%" . $in['text'] . "%'" ;
             $STH3 = PreExecSQL_all($sql, []);  
             if(!empty($STH3))
                    array_push($arrayOn, $STH3);

         }
     }
    }
    foreach($arrayOn as $k){
        foreach($k as $v){
             $folderName = (!empty($v['folder_name'])) ? $v['folder_name']: $v['company_name'];
                $tr1 .= " <div class='subs-item row'>
                        <div class='subs-icon col-1'>
                            " . $v['avatar'] . "
                        </div>
                        <div class='subs-info col-11 row'>
                          
                            <div class='subs-cat col-7'>
                                <a href='/chat/messages/" . $v['folder_id'] . "#" . $v['id'] ."'>" . $folderName ."</a><br />
                                <span><span id='name'>" . $v['company_name'] . '</span> : ' .$v['ticket_exp'] . "</span> 
                            </div>
                            
                            <div class='subs-place col-2'>
                               
                            
                                  
                                <small class='_status-bar__time'>". $v['data_insert'] ."</small>
                            </div>                          
                        </div>
                    </div>
            ";
        }
    }
    
    array_push($arr, $tr1);
    array_push($arr, $tr);
    array_push($arr, $tr2);
    $code = $arr;
}else{
    $row = $t->rowChatMessages(array(    'start_limit'   => 0,
                                                    'views'         => $in['views'] ));

       
        $tr = '';
        foreach($row as $i => $m){

                $tr .= $t->TrPageMessagesFolders(array( 'm'=>$m , 'views'=>$in['views'] ));
                
        }
        $code = $tr;

}
    $jsd['ok']          = $ok;
    $jsd['code']        = $code;
}


//sms авторизация
elseif($_GET['route'] == 'authorization_sms'){


    $login_id='';
    $row_login=array();
    $ok=false;

    if(!empty($in['email'])&&!empty($in['pass'])){

        $pass = $g->vmd5($in['pass']);
        $row = reqLogin(array('email'=>$in['email'],'pass'=>$pass));
        //$login_id = $row['id'];
        $row['id'] = 378;
        //$row['active'] = 1;
        //	if($login_id){
        //		$row_login = reqCompany(array('login_id'=>$login_id,'flag_account'=>1));	//для получения телефонного номера
        //	}

        if(!empty($row['id'])&&$row['active']==1){

            //АВТОРИЗАЦИЯ
            $g->AutorizeUser(array(	'login_id'=>$row['id'] ));//авторизация пользователя
            $ok = true;

        }elseif(!empty($row['id'])&&$row['active']<>1){
            $code = 'Нет доступа';
        }else{
            $code = 'Неверный логин или пароль!';
        }
    }else{
        $code = 'Неверно введен логин или пароль!';
    }

    $jsd['ok'] 			= $ok;
    $jsd['code'] 		= $code;

}
//получение кода в sms/email и заведение нового пользователя
elseif($_GET['route'] == 'get_sms_email'){

    $_SESSION['tmp_login'] = false;// очищаем временый логин для дальнейшего шага

    $ok = $recaptcha = false;
    $code = '';
    $arr_code = $flag = array();
    $new = 1;

    if(!empty($_SESSION["department_code"])){ //если сессия кода подтверждения не пуста, очищаем связанные сессии
        unset($_SESSION["department_code"]);
        unset($_SESSION["type_login"]);
        unset($_SESSION['n_login']);
    }

    if(!empty($in['phone_email'])){ //проврека поля на пустоту
        if(preg_match('/^([A-Za-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/', $in['phone_email'])){ //проврека на email

            $ok = false;
            $rand4 = '';
            $email = $in['phone_email'];
            $rand4 = rand(1001,9999); // рандомно формируем 4-х значное число
            $_SESSION['department_code'] = $rand4; //записываем в сессию
            $_SESSION['type_login'] = 'email'; //тип регистрации (через email)
            $_SESSION['n_login'] = $email;

            /* процессы регистрации пользоватлея по email*/

            $validate_email = (filter_var($email, FILTER_VALIDATE_EMAIL)); //Проверяет, что значение является корректным e-mail.
            if($validate_email){

                //проверка наличия в бд email
                $r=reqLogin(array('email'=>$email));
                if($r['id']){
                    $arr_code[] = 'Email используется другим пользователем';
                    $flag[] 	= 'email';
                    $new = 0;
                    $login_id = $r['id'];

                    if ($r['active']==1){  //проверка активации пользователя, если он не активен был, то переходим в авториегистрацию компании
                        $new = 0;
                    } else {
                        $new = 1;
                    }
                }else{

                    $arr_pass = $g->getPassword();// создаем пароль
                    $STH = PreExecSQL(" INSERT INTO login (email,pass,active) VALUES (?,?,?); " ,
                        array( $email,$arr_pass['md5'],2));
                    $new = 1;
                    $login_id = $db->lastInsertId();
                    if($login_id){
                        // Город
                        $arr_cities = $g->get_cities_id_by_ip($_SERVER['REMOTE_ADDR']);
                        $cities_id = $arr_cities['cities_id'];
                        $company = $login_id.'_'.$cities_id; //временное название клиента набор логин_ид+город
                        //  flag_account=1 - флаг , что это пользователь владелец аккаунта
                        $STH = PreExecSQL(" INSERT INTO company (login_id, flag_account, legal_entity_id, company, email, cities_id) VALUES (?,?,?,?,?,?); " ,
                            array( $login_id,1,1,$company,$email,$cities_id ));
                        $company_id = $db->lastInsertId();
                        if($STH){
                            // Права и Роль пользователя на компанию(аккаунт)
                            $STH = reqInsertLoginCompanyPrava(array(	'login_id'		=> $login_id,
                                'company_id'	=> $company_id,
                                'prava_id'		=> 2 ));
                            // Проверяем не добавлен ли как сотрудника
                            $row_iw = reqInviteWorkers(array('email'	=> $email));
                            if(!empty($row_iw)){
                                foreach($row_iw as $i => $m){
                                    $STH = reqInsertLoginCompanyPrava(array(	'login_id'		=> $login_id,
                                        'company_id'	=> $m['company_id'],
                                        'prava_id'		=> $m['prava_id'],
                                        'position' 		=> $m['position'] ));
                                    if($STH){
                                        // удаляем
                                        $STH = PreExecSQL(" DELETE FROM invite_workers WHERE id=? " ,
                                            array($m['id']));

                                        // чтобы авторизация была под этой компанией
                                        $STH = PreExecSQL(" INSERT INTO company_last_session (login_id,company_id) VALUES (?,?); " ,
                                            array( $login_id , $m['company_id'] ));


                                    }
                                }
                            }
                            //$loginID = $login_id;
                            $ok = true;
                        }
                    }
                }

            }else{
                $code = 'Не верный email';
                $ok = false;
                //die;
            }

            /**/



            // отправляем письмо на почту
            $rez = $tes->LetterSendCode(array('email'			 => $email,
                'phone_email_code' => $rand4 ));
            //вызываем новое окошко с кодом подтверждени
            if($rez){
                $_SESSION['tmp_login'] = $login_id;// используется в следующем шаге ajax->save_password
                $arr = $f->GetCodeForm(array('id'=>$login_id,'phone_email_code'=>$in['phone_email_code'],'phone_email'=>$email,'flag'=>1));
                $code = $t->getModal(	array('class_dialog'=>'getcode-dialog', 'class_content'=>'getcode','content'=>$arr['content']),
                    array('id'=>'getcode-form','class'=>''));
                $ok = true;
            }else{
                $code = 'Возникли проблемы при отправке сообщения!';
                $ok = false;
            }


        } elseif (preg_match('/((8|\+7)-?)?\(?\d{3,5}\)?-?\d{1}-?\d{1}-?\d{1}-?\d{1}-?\d{1}((-?\d{1})?-?\d{1})?/', $in['phone_email'])){ //проврека на телефонный номер



            require_once './protected/source/sms_ru/sms.ru.php';  // класс для отправки смс
            $smsru = new SMSRU(SMSRU_API_ID);
            $sms_ru = new stdClass();

            //$ok = $recaptcha = false;
            $arr_code = $flag = array();

            $rand4 = '';
            $phone = $in['phone_email'];
            $rand4 = rand(1001,9999); // рандомно формируем 4-х значное число
            $_SESSION['department_code'] = $rand4; //записываем в сессию	код
            $_SESSION['type_login'] = 'phone'; //тип регистрации (через телефон)
            $_SESSION['n_login'] = $phone;
            //сюда поставить проверку наличия в бд телефона



            /* процессы регистрации пользоватлея по телефону */
            $valid_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT); //Удаляет все символы, кроме цифр и знаков плюса и минуса.
            $valid_number = str_replace("-", "", $valid_number); //удаляем тире
            $valid_number = phone_format($valid_number); //форматируем тел номер

            if($valid_number){

                //проверка наличия в бд телефона
                $r = reqLogin(array('email'=>$valid_number));
                //$r=reqCompany(array('phone'=>$phone));

                //var_dump($r);
                //die;

                if(!empty($r)){
                    //$ok = true;
                    $arr_code 	= 'Пользователь с таким номером телефона уже зарегистрирован';
                    $flag[] 	= 'phone';
                    $new = 0;
                    $login_id = $r['id'];
                    //var_dump($ok);


                    if ($r['active']==1){  //проверка активации пользователя
                        $new = 0;
                    } else {
                        $new = 1;
                    }



                }else{



                    $arr_pass = $g->getPassword();// создаем пароль
                    $STH = PreExecSQL(" INSERT INTO login (email,pass,active) VALUES (?,?,?); " ,
                        array( $valid_number,$arr_pass['md5'],2));
                    $new = 1;
                    $login_id = $db->lastInsertId();
                    if($login_id){

                        $_SESSION['tmp_login'] = $login_id;// используется в следующем шаге ajax->save_password
                        // Город
                        $arr_cities = $g->get_cities_id_by_ip($_SERVER['REMOTE_ADDR']);
                        $cities_id = $arr_cities['cities_id'];
                        $company = $login_id.'_'.$cities_id; //временное название клиента набор логин_ид+город
                        //  flag_account=1 - флаг , что это пользователь владелец аккаунта
                        $STH = PreExecSQL(" INSERT INTO company (login_id, flag_account, legal_entity_id, company, iti_phone, phone, cities_id) VALUES (?,?,?,?,?,?,?); " ,
                            array( $login_id,1,1,$company,'ru',$valid_number,$cities_id ));
                        $company_id = $db->lastInsertId();
                        if($STH){
                            // Права и Роль пользователя на компанию(аккаунт)
                            $STH = reqInsertLoginCompanyPrava(array(	'login_id'		=> $login_id,
                                'company_id'	=> $company_id,
                                'prava_id'		=> 2 ));
                            // Проверка на не добавлен ли как сотрудник не выполнти при регистрации с телефона


                            $ok = true;
                        }
                    }
                }





                //здесь отправка смс
                $sms_ru->to = $valid_number;
                $sms_ru->text = 'Ваш код: '.$rand4; // Текст сообщения: случайный набор 4х значного числа

                // $sms_ru->from = ''; // Если у вас уже одобрен буквенный отправитель, его можно указать здесь, в противном случае будет использоваться ваш отправитель по умолчанию
                // $sms_ru->time = time() + 7*60*60; // Отложить отправку на 7 часов
                // $sms_ru->translit = 1; // Перевести все русские символы в латиницу (позволяет сэкономить на длине СМС)
                if(SMSRU_TEST){
                    $sms_ru->test = 1; // Позволяет выполнить запрос в тестовом режиме без реальной отправки сообщения
                }
                //$sms_ru->partner_id = '1'; // Можно указать ваш ID партнера, если вы интегрируете код в чужую систему
                $sms = $smsru->send_one($sms_ru); // Отправка сообщения и возврат данных в переменную

                //echo $valid_number;


                if ($sms->status == "OK") { // Запрос выполнен успешно
                    //сделать добавление в БД данные об отправке смс
                    //  $sms->sms_id - ID сообщения
                    // $sms->status_code - Код ошибки
                    // $sms->status_text - Текст ошибки

                    $_SESSION['tmp_login'] = $login_id;// используется в следующем шаге ajax->save_password

                    $arr = $f->GetCodeForm(array('id'=>$login_id,'phone_email_code'=>$in['phone_email_code'],'phone_email'=>$valid_number,'flag'=>2));
                    $code = $t->getModal(	array('class_dialog'=>'getcode-dialog', 'class_content'=>'getcode','content'=>$arr['content']),
                        array('id'=>'getcode-form','class'=>''));
                    $ok = true;

                } else {

                    $code = 'Возникли проблемы при отправке сообщения! '. $sms->status_code. ' '.$sms->status_text;
                    $ok = false;

                }


            }else{
                $code = 'Не верный формат телефона';
                $ok = false;
                //die;
            }






        } else {
            $code = 'Не верно введены входные данные!';
            $ok = false;
        }



    }

    //var_dump($valid_number);
    //var_dump($arr_code);
    //die;

    $jsd['ok'] 			= $ok;
    $jsd['code'] 		= $code;
    $jsd['new_login']	= $new;
    //$jsd['4code']		= $rand4; // от 07-06-2022

}
//повторная отправка кода подтверждения
elseif($_GET['route'] == 'resending_code'){
    $ok = false;
    $code = '';
    $rand4 = '';

    if(!empty($_SESSION["department_code"])){ //если сессия кода подтверждения не пуста, очищаем связанные сессии
        unset($_SESSION["department_code"]);
    }

    $type_login = $_SESSION["type_login"]; //тип авторизации
    $n_login = $_SESSION['n_login'];
    $rand4 = rand(1001,9999); // рандомно формируем 4-х значное число
    $_SESSION['department_code'] = $rand4; //записываем в сессию

    if ($type_login ==='email' ){
        //$code = 'email';

        // отправляем письмо на почту
        $rez = $tes->LetterSendCode(array('email'			 => $n_login,
            'phone_email_code' => $rand4 ));

        if($rez){
            $code = 'письмо ушло еще раз c новым кодом';//.$rand4;
            $ok = true;

        }else{
            $code = 'Возникли проблемы при отправке сообщения!';
            $ok = false;
        }
    }else{
        require_once './protected/source/sms_ru/sms.ru.php';  // класс для отправки смс

        $smsru = new SMSRU(SMSRU_API_ID);
        $sms_ru = new stdClass();

        //здесь отправка смс
        $sms_ru->to = $n_login;
        $sms_ru->text = 'Ваш код: '.$rand4; // Текст сообщения: случайный набор 4х значного числа

        // $sms_ru->from = ''; // Если у вас уже одобрен буквенный отправитель, его можно указать здесь, в противном случае будет использоваться ваш отправитель по умолчанию
        // $sms_ru->time = time() + 7*60*60; // Отложить отправку на 7 часов
        // $sms_ru->translit = 1; // Перевести все русские символы в латиницу (позволяет сэкономить на длине СМС)
        if(SMSRU_TEST){
            $sms_ru->test = 1; // Позволяет выполнить запрос в тестовом режиме без реальной отправки сообщения
        }
        $sms = $smsru->send_one($sms_ru); // Отправка сообщения и возврат данных в переменную

        if ($sms->status == "OK") { // Запрос выполнен успешно
            //сделать добавление в БД данные об отправке смс
            //  $sms->sms_id - ID сообщения
            $code = 'письмо ушло еще раз c новым кодом '; //.$rand4;
            $ok = true;

        } else {
            //сделать повторную отправку сообщения при нажатии на кнопку по просьбе
            //сделать добавление в БД данные об ошибке при отправке смс
            //сделать повторную отправку
            // $sms->status_code - Код ошибки
            // $sms->status_text - Текст ошибки
            $code = 'Возникли проблемы при отправке сообщения! '. $sms->status_code. ' '.$sms->status_text;
            $ok = false;
        }


    }



    $ok = true;

    $jsd['ok'] 			= $ok;
    $jsd['code'] 		= $code;
    //$jsd['4code']		= $rand4; // от 07-06-2022
}
//проверка кода
elseif($_GET['route'] == 'check_code'){
    $ok = false;
    $code = '';
    $login_id = '';

    if(!empty($in['phone_email_code']) && mb_strlen($in['phone_email_code'], 'utf-8')==4){ //проверка кол-ва введенных символов (код состоит из 4х чисел)

        if ($_SESSION['department_code'] == $in['phone_email_code'] ) {  //проверяем совпадение поля и кода из сессии

            $code = 'Код подтверждения правильный';
            $ok = true;

            $login_id = $_SESSION['tmp_login'];

            //$login_id = $in['id'];

            //активируем учетку после подтверждения
            //$STH = PreExecSQL("UPDATE login SET active=1 WHERE id=?;" ,
            //						array($login_id));

            if(!empty($_SESSION["type_login"]) && !empty($_SESSION["n_login"])){
                unset($_SESSION["type_login"]);
                unset($_SESSION["n_login"]);
            }

        } else {
            $code = 'Неверный код подтверждения';
            $ok = false;
        }

    } else {
        $code = '';//'Ошибка ввода кода подтверждения';
        $ok = false;

    }

    $jsd['ok'] 			= $ok;
    $jsd['code'] 		= $code;
    $jsd['login_id'] 	= $login_id;

}
//вывод формы сохранение пароля
elseif($_GET['route'] == 'save_password_form'){
    $code = '';

    $arr = $f->SetNewPasswordForm(array('id'=>$in['id'],'new_pass'=>$in['new_pass'],'new_pass_again'=>$in['new_pass_again']));
    $code = $t->getModal(	array('class_dialog'=>'newpass-dialog', 'class_content'=>'newpass','content'=>$arr['content']),
        array('id'=>'newpass-form','class'=>'form-wrapper2'));

    $jsd['code'] 		= $code;
}
// модальное окно Получить сченить пароль
elseif($_GET['route'] == 'modal_save_pass'){

    $arr = $f->SetNewPasswordForm(array('id'=>$in['id'],'flag'=>'profile'));
    $code = $t->getModal(	array('top'=>$arr['top'],'content'=>$arr['content'],'bottom'=>$arr['bottom']),
        array('id'=>'newpass-form','class'=>'') );
    $jsd['code'] = $code;

}
//Cохранение пароля
elseif($_GET['route'] == 'save_password'){
    $ok = $flag = false;
    $code 	= '';
    if(empty($in['new_pass'])||($in['new_pass']!=$in['new_pass_again'])){
        $code 	= 'Не совпадает пароль';
        $flag 	= true;
    }
    //vecho('*'.$in['new_pass'].'*'.$in['new_pass_again'].'*');
    //если все впорядке
    if(!$flag){
        /*
			if($in['value']&&!LOGIN_ID){
				$login_id = $in['value'];
			}
			*/
        //vecho( '*'.$_SESSION['tmp_login'] );
        $login_id = (isset($_SESSION['tmp_login'])&&!empty($_SESSION['tmp_login']))? $_SESSION['tmp_login'] : '';
        if($login_id){
            //echo '***'.$_SESSION['tmp_login'];
            $pass = $g->vmd5($in['new_pass']);
            $STH = PreExecSQL("UPDATE login SET active=1,pass=? WHERE id=?;" ,
                array($pass,$login_id));
            if($STH){
                $g->AutorizeUser(array(	'login_id'=>$login_id ));//авторизация пользователя
                $ok		= true;
            }
        }
    }

    $jsd['code'] = $code;
    $jsd['ok'] 	= $ok;
}

//выход
elseif($_GET['route'] == 'exit'){
    session_destroy();
}
// модальное окно Получить пароль
elseif($_GET['route'] == 'modal_getpassword'){

    $arr = $f->GetPasswordForm(array('id'=>$in['id'],'phone_email'=>$in['phone_email']));

    $code = $t->getModal(	array('class_dialog'=>'getpassword-dialog', 'class_content'=>'getpassword','content'=>$arr['content']),
        array('id'=>'getpassword-form','class'=>'form-wrapper2'));

    $jsd['code'] = $code;
}
// модальное окно Ввод кода (email/sms)
elseif($_GET['route'] == 'modal_getcode'){

    $arr = $f->GetCodeForm(array('id'=>$in['id'],'phone_email_code'=>$in['phone_email_code']));

    $code = $t->getModal(	array('class_dialog'=>'getpassword-dialog', 'class_content'=>'getcode','content'=>$arr['content']),
        array('id'=>'getcode-form','class'=>'form-wrapper2'));

    $jsd['code'] = $code;
}
// модальное окно Регитсрация PRO Шаг 1
elseif($_GET['route'] == 'modal_registration_pro'){

    $arr = $f->FormModalProStep1();
    //$arr = $f->FormMyCompany(array('id'=>$in['id']));

    $code = $t->getModal(	array('top'=>$arr['top'],'content'=>$arr['content'],'bottom'=>$arr['bottom']),
        array('id'=>'admin_categories-form','class'=>'') );

    $jsd['code'] = $code;
}
// Изменение ссылки на оплату при переключении типов оплат в модальном окне
elseif($_GET['route'] == 'change_pay'){
    $ok = false;
    $code = '';

    $rbp = reqBalancePRO90();
    $count3 = ($rbp) ? (int) $rbp[0]['count3'] : 0; //скидка 90% до 3-х раз включительно;
    $skidka = ($count3 < 3) ? '(скидка 90%)' : '';
    $price_pro = ($count3 < 3) ? 399 : PRICE_PRO;


    $type_skills = $in['type_skills'];
    if($type_skills == 1){
        $name_servies = 'Pro '.$skidka;
        $sum_to_pay = $price_pro;
    } elseif($type_skills == 2) {
        $name_servies = 'Vip';
        $sum_to_pay = PRICE_VIP;
    }

    if ($sum_to_pay>0){
        /* формирование ссылки для оплаты картой - yookassa */
        if(!empty($_SESSION["paymentId"]))
        {
            unset($_SESSION["paymentId"]); //если сессия paymentId не пуста, читим его
        }

        require_once './protected/source/yookassa-sdk/lib/autoload.php';
        //$client = new Client();
        $client = new \YooKassa\Client();
        $client->setAuth(YOOKASSA_SHOPID, YOOKASSA_API);

        $idempotenceKey = gen_uuid();

        $response = $client->createPayment(
            array(
                'amount' => array(
                    'value' => $sum_to_pay,
                    'currency' => 'RUB',
                ),
                'confirmation' => array(
                    'type' => 'redirect',
                    'return_url' => DOMEN.'/pro/return_payment',
                ),
                'capture' => true,
                'description' => 'Услуга “Пакет '.$name_servies.'. Для упрощения закупок и снижения цен на товары”',
                'metadata' => array(
                    'order_id' => '0000',
                )
            ),
            $idempotenceKey
        );

        $paymentId = $response['id'];
        $_SESSION['paymentId'] = $paymentId;
        //get confirmation url
        $confirmationUrl = $response->getConfirmation()->getConfirmationUrl();

        //Добавление информации об оплате
        $STH = PreExecSQL(" INSERT INTO pro_invoices (company_id,summ,type_s,paymentId) VALUES (?,?,?,?); " ,
            array( COMPANY_ID,$sum_to_pay,$type_skills,$paymentId));

    }

    $ok = true;
    $code = $confirmationUrl;

    $jsd['ok'] 	= $ok;
    $jsd['code']	= $code;
}
// модальное окно Регистрация
elseif($_GET['route'] == 'modal_registration'){

    $arr = $f->FormRegistration(array('id'=>$in['id'],'email'=>$in['email'],'name'=>$in['name'],'phone'=>$in['phone2']));

    $code = $t->getModal(	array('class_dialog'=>'register-dialog', 'class_content'=>'register','content'=>$arr['content']),
        array('id'=>'registration-form','class'=>''));

    $jsd['code'] = $code;
}
// модальное окно Получить пароль
elseif($_GET['route'] == 'modal_getPassword'){

    $arr = $f->GetPasswordForm(array('id'=>$in['id'],'email_phone'=>$in['email_phone']));

    //$code = $t->getModal(	array('class_dialog'=>'register-dialog', 'class_content'=>'register','content'=>$arr['content']),
    //					array('id'=>'registration-form','class'=>''));

    $jsd['code'] = $code;
}
// модальное окно Регистрация
elseif($_GET['route'] == 'modal_registration'){

    $arr = $f->FormRegistration(array('id'=>$in['id'],'email'=>$in['email'],'name'=>$in['name'],'phone'=>$in['phone2']));

    $code = $t->getModal(	array('class_dialog'=>'register-dialog', 'class_content'=>'register','content'=>$arr['content']),
        array('id'=>'registration-form','class'=>''));

    $jsd['code'] = $code;
}
// сохранить Регистрация
elseif($_GET['route'] == 'registration'){
    $ok = $recaptcha = false;
    $arr_code = $flag = array();

    $_POST['g-recaptcha-response'] = isset($_POST['g-recaptcha-response'])? $_POST['g-recaptcha-response'] : '';
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".reCAPTCHA_SECRETKEY."&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);
    $googleobj = json_decode($response);
    $verified = $googleobj->success;

    if($verified === true){
        $recaptcha = true;
        $validate_email = (filter_var($in['email'], FILTER_VALIDATE_EMAIL));
        if($validate_email){
            //логин (email) занят
            $r=reqLogin(array('email'=>$in['email']));
            if($r['id']){
                $arr_code[] 	= 'Email занят';
                $flag[] 	= 'email';
            }
            // проверяем есть ли пользователь с таким телефоном
            $in['phone'] = preg_replace("/[^0-9]/", '', $in['phone']);
            $r=reqCompany(array('phone'=>$in['phone']));
            if(!empty($r)){
                $arr_code[] 	= 'Пользователь с таким номером телефона зарегистрирован';
                $flag[] 	= 'phone';
            }
            if(empty($flag)){

                $arr_pass = $g->getPassword();// создаем пароль
                $STH = PreExecSQL(" INSERT INTO login (email,pass) VALUES (?,?); " ,
                    array( $in['email'],$arr_pass['md5'] ));

                $login_id = $db->lastInsertId();
                if($login_id){
                    // Город
                    $arr_cities = $g->get_cities_id_by_ip($_SERVER['REMOTE_ADDR']);
                    $cities_id = $arr_cities['cities_id'];
                    //  flag_account=1 - флаг , что это пользователь владелец аккаунта
                    $STH = PreExecSQL(" INSERT INTO company (login_id, flag_account, legal_entity_id, company, iti_phone, phone, cities_id) VALUES (?,?,?,?,?,?,?); " ,
                        array( $login_id,1,1,$in['name'],$in['value'],$in['phone'],$cities_id ));
                    $company_id = $db->lastInsertId();
                    if($STH){
                        // Права и Роль пользователя на компанию(аккаунт)
                        $STH = reqInsertLoginCompanyPrava(array(	'login_id'		=> $login_id,
                            'company_id'	=> $company_id,
                            'prava_id'		=> 2 ));
                        // Проверяем не добавлен ли как сотрудника
                        $row_iw = reqInviteWorkers(array('email'	=> $in['email']));
                        if(!empty($row_iw)){
                            foreach($row_iw as $i => $m){
                                $STH = reqInsertLoginCompanyPrava(array(	'login_id'		=> $login_id,
                                    'company_id'	=> $m['company_id'],
                                    'prava_id'		=> $m['prava_id'],
                                    'position' 		=> $m['position'] ));
                                if($STH){
                                    // удаляем
                                    $STH = PreExecSQL(" DELETE FROM invite_workers WHERE id=? " ,
                                        array($m['id']));

                                    // чтобы авторизация была под этой компанией
                                    $STH = PreExecSQL(" INSERT INTO company_last_session (login_id,company_id) VALUES (?,?); " ,
                                        array( $login_id , $m['company_id'] ));


                                }
                            }
                        }


                        // отправляем письмо на почту
                        $rez = $tes->LetterSendRegistration(array('email'	=> $in['email'],
                            'name'	=> $in['name'],
                            'pass'	=> $arr_pass['pass'] ));
                        $ok = $rez;
                        if($ok){
                            $code = '<h4 class="register_data-send">Данные для входа в аккаунт отправлены к Вам на E-mail.</h4>
											<div class="btn btn-blue" data-dismiss="modal">Понятно</div>';
                        }
                    }
                }
            }
        }else{
            $code = 'Не верный email';
        }
    }else{
        $code = 'Выберите "Я не робот"';
    }


    $flag = implode(',',$flag);
    if($flag){
        $code = implode(',<br/>',$arr_code);
    }


    $jsd['ok'] 			= $ok;
    $jsd['code'] 		= $code;
    $jsd['recaptcha']	= $recaptcha;
    $jsd['flag']			= $flag;
}
//восстановление пароля
elseif($_GET['route'] == 'restore'){
    $ok		= false;
    $code 	= 'Нельзя восстановить пароль (';
    $row = reqLogin(array('email'=>$in['email']));
    if(!empty($row['id'])){
        $profile = reqCompany(array('login_id' => $row['id'],'flag_account'=>1,'one'=>true));

        //Шаблон отправка письма
        $rez = $tes->LetterSendRestorePassword(array('md5'=>$row['active_md5'],'email'=>$row['email'],'name'=>$profile['company']));

        if($rez){
            $ok 		= true;
            $code 	= 'На указанную электронную почту отправлено письмо. Перейдите по ссылке в письме, чтобы задать новый пароль от вашей учетной записи.';
            //$code 	=  $t->getAfterLetterSendRestorePassword(array('email'=>$row['email']));
        }
    }else{
        $code 	= 'Пользователь <b>'.$in['email'].'</b> не существует';
    }

    $jsd['ok'] 			= $ok;
    $jsd['code'] 		= $code;
}
// Сменить Пароль ("Восстановление")
elseif($_GET['route'] == 'change_pass'){
    $ok = $flag = false;
    $sql_where = '';
    $code 	= 'Не возможно сменить пароль';
    if(empty($in['pass'])||($in['pass']!=$in['pass_again'])){
        $code 	= 'Не совпадает пароль';
        $flag 	= true;
    }
    //если все впорядке
    if(!$flag){
        if($in['value']&&!LOGIN_ID){
            $r = reqLogin(array('active_md5'=>$in['value']));
            $login_id = $r['id'];
        }
        if(LOGIN_ID){
            $login_id = LOGIN_ID;
        }
        if($login_id){
            $pass = $g->vmd5($in['pass']);
            $STH = PreExecSQL("UPDATE login SET active=1,pass=? WHERE id=?;" ,
                array($pass,$login_id));
            if($STH){
                $ok		= true;
                $code = 'Пароль изменен';
                if($in['value']){
                    $row = reqLogin(array('email'=>$r['email'],'pass'=>$pass));
                    if(!empty($row['id'])&&$row['active']==1){
                        $g->AutorizeUser(array(	'login_id'=>$row['id'] ));//авторизация пользователя
                    }else{
                        $code = 'Пароль изменен, доступ заблокирован';
                    }
                }
            }
        }
    }

    $jsd['code'] = $code;
    $jsd['ok'] 	= $ok;
}
// модальное окно Поиск
elseif($_GET['route'] == 'modal_search'){

    $arr = $t->ModalSearch(array('flag_buy_sell'=>$in['flag_buy_sell'] , 'where'=>$in['where']));

    $code = $t->getModal(	array('class_dialog'=>$in['mclass'],'class_body'=>'search-hidden','content'=>$arr['content']),
        array('id'=>'','class'=>''));

    $jsd['code'] = $code;
}
// модальное окно Заявка/Объявление
elseif($_GET['route'] == 'modal_buy_sell'){

    $arr = $f->FormBuySell(array('id'=>$in['id'],'flag_buy_sell'=>$in['flag_buy_sell'],'share_url'=>$in['share_url'],
        'status'=>$in['status'],'flag'=>$in['flag'] ));

    $code = $t->getModal(	array('class_dialog'=>'search-dialog needs-dialog','content'=>$arr['content']),
        array('id'=>'buy_sell-form','class'=>'') );

    $jsd['code'] = $code;
}
// Заявка/Объявление - Атрибуты за категорией
elseif($_GET['route'] == 'change_categories_buy_sell'){
    $required_name = $required_file = '';
    if(v_int($in['id'])){
        $nomenclature = ($in['flag']=='nomenclature')? true : false;
        $arr = $t->CategoriesAttributeBuySell(array(	'flag_buy_sell'		=> $in['flag_buy_sell'],
            'status'			=> 1,
            'categories_id'		=> $in['id'],
            'nomenclature'		=> $nomenclature,
            'nomenclature_id'	=> $in['nomenclature_id'],
            'flag'				=> 'change_categories',
            'search_categories_id' => $in['search_categories_id'] ));
        $code 			= $arr['code'];
        $row_categories 	= $arr['row_categories'];
        if($row_categories['no_empty_name']){
            $required_name = 'required="required"';
        }
        if($row_categories['no_empty_file']){
            $required_file = 'required="required"';
        }
    }

    $jsd['code'] 			= $code;
    $jsd['required_name'] 	= $required_name;
    $jsd['required_file']	= $required_file;
    $jsd['categories']		= $row_categories['categories'];
}
// Заявка/Объявление - Сохранить
elseif($_GET['route'] == 'save_buy_sell'){
    $ok = $STH = $buy_sell_id = $categories_id = $noautorize = $flag_nomenclature = false;
    $code = 'Нельзя сохранить';
    $error_required = array();

    $copy_id	= $company_id2 = $parent_id = $login_id = 0;
    $login_id 		= LOGIN_ID;// по умолчанию
    $company_id 	= COMPANY_ID;// по умолчанию
    $flag_sam = $flag_reload = $flag_insert = false;


    // Проверка ПРАВ
    if( (PRAVA_4||PRAVA_5) && ($in['status']==2||$in['status']==3) ){

        $jsd['ok'] 			= $ok;
        $jsd['code'] 		= $code;
        echo json_encode($jsd);

        exit;

    }
    ///

    $in['amount1'] = $g->ReaplaceZap($in['amount1']);
    $in['amount2'] = $g->ReaplaceZap($in['amount2']);

    if($in['unit_id1']<>1){
        $in['amount2'] 	= 0;
        $in['unit_id2'] 	= 0;
    }


    $url 	= $g->rus2translit($in['name']);

    $in['cost'] 			= $g->ReaplaceZap($in['cost']);

    $in['cost1'] 		= ($in['cost1'])? 			$in['cost1'] 			: 0;

    $in['amount'] 		= ($in['amount'])? 			$in['amount'] 			: 0;

    $in['parent_id'] 	= ($in['parent_id'])? 		$in['parent_id'] 		: 0;

    $in['currency_id']	= ($in['currency_id'])? 		$in['currency_id'] 		: 1;// по умолчанию рубль

    $categories_id			= $in['categories_id'];


    // "Не существующая" категория для не опубликованных заявок
    if( !$categories_id && $in['status']==1 ){
        $categories_id = 1302; // "Не существующая"
    }


    if(!COMPANY_ID){// если не авторизованный создает
        $in['status'] 	= ($in['status']==10)? 10 : 2;
        $in['status'] 	= ($categories_id==1302)? 1 : $in['status'];
        $noautorize		= true;
    }

    // если поделиться (по ссылке перешел и дает предложение)
    if($in['share_url']){
        $row_share = reqBuySellShare(array('share_url'=>$in['share_url']));
        if($row_share['company_id_to']){
            $company_id = $row_share['company_id_to'];
            $rc = reqCompany(array( 'id' => $company_id ));
            $login_id 		= $rc['login_id'];
        }
    }
    ///

    if($in['status']==10||$in['status']==12||$in['status']==14||$in['status']==15){// Предложение или Исполнено или Возврат или Возвращено

        $in['flag_buy_sell'] = 2;

        $r_p 	= reqBuySell_SaveBuySell(array('id' => $in['parent_id']));
        $copy_id 			= $r_p['copy_id'];
        if($in['status']==10){
            $url	= 'offer';
            $in['form_payment_id'] = (FLAG_ACCOUNT==1)? 3 : $in['form_payment_id']; // Для не компаний по умолчанию - наличные
            $company_id = ($in['company_id'])? $in['company_id'] : $company_id;
        }elseif($in['status']==12){
            $url	= 'buried';
            if($r_p['unit_group_id']){
                // пересчитываем, если надо, количество при фасовке или отличной от ед.изм заявки
                $in['amount'] = $bs->BuyAmountByUnit(array(	'row_bs' => array(	'unit_group_id'	=> $r_p['unit_group_id'],
                    'unit_id2'		=> $r_p['unit_id2'],
                    'amount2'		=> $r_p['amount2'],
                    'unit_id'		=> $r_p['unit_id'],
                    'unit_id1'		=> $r_p['unit_id1'],	),
                    'amount' => $in['amount1']));
                $in['amount2'] 	= $r_p['amount2'];
                $in['unit_id2'] = $r_p['unit_id2'];
                ///
            }

        }elseif($in['status']==14){
            $url	= 'return';
        }elseif($in['status']==15){
            $url	= 'returned';
            $company_id = $r_p['company_id'];
        }
        $in['form_payment_id']	= ($in['form_payment_id'])? 	$in['form_payment_id'] 		: $r_p['form_payment_id'];
        $in['cities_id'] 		= ($in['cities_id'])? 		$in['cities_id'] 			: $r_p['cities_id'];
        $categories_id				= $r_p['categories_id'];
        $in['urgency_id'] 		= $r_p['urgency_id'];
        $company_id2 				= $r_p['company_id2'];

        if($in['company_id']>0){// существует ли компания
            $r 	= reqCompany(array( 'id' => $in['company_id'] ));
            if(!empty($r)){
                $company_id = $in['company_id'];
                $flag_sam = true;
            }
        }
    }elseif($in['flag_buy_sell']==5){// на СКЛАДЕ поставщик
        if(v_int($in['company_id2'])){// существует ли компания
            $r 	= reqCompany(array( 'id' => $in['company_id2'] ));
            if(!empty($r)){
                $company_id2 = $in['company_id2'];
            }else{
                $jsd['ok'] 			= false;
                $jsd['code'] 		= 'Поставщик не существует';
                echo json_encode($jsd);

                exit;
            }
        }
    }


    // Проверка Категории
    if( !$categories_id ){

        $jsd['ok'] 			= false;
        $jsd['code'] 		= 'Выберите категорию';
        echo json_encode($jsd);

        exit;

    }
    if( !$company_id && COMPANY_ID ){

        $jsd['ok'] 			= false;
        $jsd['code'] 		= 'Выберите поставщика';
        echo json_encode($jsd);

        exit;
    }

    ///


    if(PRAVA_4||PRAVA_5){// с этими правами

        if(!$in['responsible_id']){// заказчик становиться "Ответственным"
            $cr = reqCompany(array('login_id' => $login_id,'flag_account'=>1,'one'=>true));
            $in['responsible_id'] = $cr['id'];
        }

    }

    if(!$in['id']){// СОЗДАНИЕ

        $flag_buy_sell	= $in['flag_buy_sell'];

        $flag_limit = true;

        // проверяем лимит на Активные объявления/заявки
        if($in['status']==3){
            $arr_p = $bs->ProverkaLimitBuySell(array('flag_buy_sell'=>$in['flag_buy_sell'],'categories_id'=>$categories_id));
            $flag_limit	= $arr_p['ok'];
            $code 	= $arr_p['code'];
        }
        ///

        if($flag_limit){

            //$in['amount'] = $in['amount1'];// amount при фасовке поле расчетное (по умолчанию равно amount1)
            $arr = reqInsertBuySell(array(	'login_id'			=> $login_id,
                'company_id'		=> $company_id,
                'company_id2'		=> $company_id2,
                'parent_id'			=> $in['parent_id'],
                'copy_id'			=> $copy_id,
                'flag_buy_sell'		=> $in['flag_buy_sell'],
                'status'			=> $in['status'],
                'name'				=> $in['name'],
                'url'				=> $url,
                'cities_id'			=> $in['cities_id'],
                'categories_id'		=> $categories_id,
                'urgency_id'		=> $in['urgency_id'],
                'currency_id'		=> $in['currency_id'],
                'cost'				=> $in['cost'],
                'cost1'				=> $in['cost1'],
                'form_payment_id'	=> $in['form_payment_id'],
                'amount'			=> $in['amount'],
                'amount1'			=> $in['amount1'],
                'unit_id1'			=> $in['unit_id1'],
                'amount2'			=> $in['amount2'],
                'unit_id2'			=> $in['unit_id2'],
                'comments'			=> $in['comments'],
                'comments_company'	=> $in['comments_company'],
                'responsible_id'	=> $in['responsible_id'],
                'availability'		=> $in['availability'],
                'nomenclature_id'	=> $in['nomenclature_id'],
                'multiplicity'		=> $in['multiplicity'],
                'min_party'			=> $in['min_party'],
                'delivery_id'		=> $in['delivery_id'],
                'stock_id'			=> $in['stock_id'],
                'assets_id'			=> $in['assets_id'],
                'id_1c'				=> $in['id_1c'],
                'company_id3'		=> $in['company_id3']

            ));


            if($arr['STH']){

                $flag_insert = true;

                if($in['status']<4){
                    $flag_reload = true;
                }

                // действия при "исполнено" и "возврат" в конце (после добавления параметров)
                $buy_sell_id = $arr['buy_sell_id'];
                $ok = true;
                $categories_id	= $categories_id;

                // Оповещение
                if($in['status']<>1&&COMPANY_ID){
                    $cn->StartNotification(array(	'flag'				=> 'buy_sell',
													'tid'				=> $buy_sell_id,
													'parent_id'			=> $in['parent_id'],
													'status_buy_sell_id'=> $in['status'],
													'company_id2'		=> $company_id2,
													'flag_sam'			=> $flag_sam	));
                }

                // Создаем Номенклатуру при новой заявке (если заявка не привязана к номенклатуре) // создает только авторизованный
                //						если номенклатура привязана, то обновляем в другом месте...
                if( $categories_id<>1302 && !$noautorize && !$in['nomenclature_id'] && ($in['flag_buy_sell']==2) && ($in['status']==2||$in['status']==3) ){
                    $arr = $bs->NomenclatureInsertUpdate(array( 	'buy_sell_id'	=> $buy_sell_id,
                        'id'			=> 0,
                        'name'			=> $in['name'],
                        'categories_id'	=> $categories_id,
                        'id_1c'			=> $in['id_1c'],
                        'post'			=> $_POST	));
                    //vecho('qw');
                    $flag_nomenclature = true;
                }elseif($in['nomenclature_id']){
                    $rn = reqNomenclature(array('id'=>$in['nomenclature_id']));
                    if($rn['name']==$in['name']){
                        //$flag_nomenclature = true;// не задавать вопрос по созданию номенклатуры
                    }
                }elseif($categories_id==1302){// "Не существующая" категория , номенкталура не участвует
                    $flag_nomenclature = true;
                }elseif(!$in['nomenclature_id'] && $in['flag_buy_sell']==2 && $in['status']==1){// "Не существующая" категория , номенкталура не участвует
                    $flag_nomenclature = true;
                }

                if(PRAVA_4||PRAVA_5){// с этими правами не корректирует номенклатуру (заказчик)
                    $flag_nomenclature = true;
                }

                ///

                // создаем идентификатор куки для закрепленнием заявок/объявл за пользователем после регистрации
                if(!COMPANY_ID){
                    $STH = PreExecSQL(" INSERT INTO buy_sell_cookie	(buy_sell_id, cookie_session) VALUES (?,?) " ,
                        array( $buy_sell_id,COOKIE_SESSION ));
                }


            }

        }
    }else{// РЕДАКТИРОВАНИЕ

        $r 	= reqBuySell_SaveBuySell(array('id' => $in['id']));
        $ra 	= reqBuySellAttribute(array('buy_sell_id' => $in['id'] , 'attribute_id' => 33 , 'one'=>true));

        $old_elem_33 	= isset($ra['value'])?	$ra['value']	: '';
        $old_name 	= isset($r['name'])? 	$r['name'] 	: '';

        if( ($r['company_id']==COMPANY_ID) || ($r['login_id']<>LOGIN_ID) ){// должна принадлежать пользователю или компании
            //
        }else{
            $jsd['ok'] 			= false;
            $jsd['code'] 		= 'Обратитесь к Администратору';
            echo json_encode($jsd);

            exit;
        }

        $categories_id	= ($in['categories_id'])? $in['categories_id'] : $r['categories_id'];
        $flag_buy_sell	= $r['flag_buy_sell'];
        $parent_id	= $r['parent_id'];
        $login_id		= $r['login_id_bs'];

        $flag_cron_new_buysell = false;
        $sql_data = '';
        if( (!$r['data_status_buy_sell_23']) && ($in['status']==2||$in['status']==3) ){// Опубликовываем||Активная, фиксируем дату при первой опубл или активации
            $sql_data = ' , data_status_buy_sell_23=NOW() ';
            $flag_cron_new_buysell = true;
        }

        $url = $url.'_'.$in['id'];


        $flag_limit = true;


        if($in['status']==3&&$r['status_buy_sell_id']<>3){// проверяем лимит на Активные объявления/заявки (если текущее не активное)
            $arr_p = $bs->ProverkaLimitBuySell(array('flag_buy_sell'=>$flag_buy_sell,'categories_id'=>$categories_id));
            $flag_limit	= $arr_p['ok'];
            $code 	= $arr_p['code'];
        }elseif( $in['status']==2&&($r['status_buy_sell_id']==3||$r['status_buy_sell_id']==1) ){// опубликовываем активированную/не опубл
            $flag_limit = true;
        }else{// редактируем уже опубликованную/активированную или предложение
            $flag_limit = true;
            $in['status'] = $r['status_buy_sell_id'];
        }
        if($flag_limit){

            // создаем копию если создатель заявки не лицо редактирующее и меняется статус
            //vecho($in['buy_sell_id'].'*'.$ra['login_id_bs'].'*'.LOGIN_ID.'*'.$ra['status_buy_sell_id'].'*'.$in['status']);
            if( ($login_id<>LOGIN_ID) && ( ($in['status']==2&&$r['status_buy_sell_id']<>2) || ($in['status']==3&&$r['status_buy_sell_id']<>3) ) ){
                $bs->CopyRowBuySell(array(	'buy_sell_id'	=> $in['id'],
                    'parent_id'		=> $in['id'],
                    'login_id'		=> $login_id,
                    'status'		=> 7 ));
            }
            ///

            $in['responsible_id'] = ($in['responsible'])? $in['responsible_id'] : 0;


            $STH = PreExecSQL(" UPDATE buy_sell SET login_id=?, company_id2=?, categories_id=?, status_buy_sell_id=?, name=?, url=?, cities_id=?, urgency_id=?, currency_id=?, cost=?, form_payment_id=?, amount=?, comments=?, comments_company=?, responsible_id=?, nomenclature_id=?, availability=?, multiplicity=?, min_party=?, delivery_id=?, stock_id=?, assets_id=?, company_id3=? ".$sql_data." WHERE id=?; " ,
                array( LOGIN_ID,$company_id2,$categories_id,$in['status'],$in['name'],$url,$in['cities_id'],$in['urgency_id'],$in['currency_id'],$in['cost'],$in['form_payment_id'],$in['amount'],$in['comments'],$in['comments_company'],$in['responsible_id'],$in['nomenclature_id'],$in['availability'],$in['multiplicity'],$in['min_party'],$in['delivery_id'],$in['stock_id'],$in['assets_id'],$in['company_id3'],$in['id'] ));

            if($STH){
                $buy_sell_id = $in['id'];
                $ok = true;
                if($flag_cron_new_buysell){// Добавляем - Id новой завки , чтобы через крон по ней отправить оповещение
                    reqInsertСronNewBuysell(array('buy_sell_id'=>$buy_sell_id));
                }


                $elem_33 = isset($_POST['elem_33'])? $_POST['elem_33'] : '';

                if( ($in['flag_buy_sell']==2) && ($old_name==$in['name']) && ( $old_elem_33==$elem_33 ) ){// не сохранять номенклатуру

                    //$flag_nomenclature = true;
                }

                if(PRAVA_4||PRAVA_5){// с этими правами не корректирует номенклатуру (заказчик)
                    $flag_nomenclature = true;
                }

            }
        }
    }


    // Сохранение динамических параметров
    if($buy_sell_id){

        // запрос на сторонии ресурсы
        $qrq->InsertCronAmoBuySell(array('buy_sell_id'=>$buy_sell_id));

        // Обновляем и пересчитываем количество "amount" если у категории указано фасовка
        $bs->UpdateBuySellByPacking(array(	'buy_sell_id'	=> $buy_sell_id,
            'categories_id'	=> $categories_id,
            'status'		=> $in['status'],
            'cost'			=> $in['cost'],
            'amount'		=> $in['amount'],
            'amount1'		=> $in['amount1'],
            'unit_id1'		=> $in['unit_id1'],
            'amount2'		=> $in['amount2'],
            'unit_id2'		=> $in['unit_id2'] ));
        ///



        $bsa_id = array();
        //$STH = PreExecSQL(" DELETE FROM buy_sell_attribute WHERE buy_sell_id=?; " ,
        //												array( $buy_sell_id ));



        if( $flag_buy_sell==1 || ( $flag_buy_sell==2&&$in['status']==10) ){
            $pole1 = 'sell_type_attribute_id';
            $pole2 = 'sell_flag_value';
            $pole3 = 'no_empty_sell';
        }else{
            $pole1 = 'buy_type_attribute_id';
            $pole2 = 'buy_flag_value';
            $pole3 = 'no_empty_buy';
        }


        $row = reqCategoriesAttribute(array('categories_id'=>$categories_id,'flag'=>'save'));
        foreach($row as $i=>$m){
            $elem = 'elem_'.$m['attribute_id'];
            $arr = isset($_POST[ $elem ])? $_POST[ $elem ] : array();
            $flag_value 	= $m[ $pole2 ];
            $no_empty	= $m[ $pole3 ];

            if($m[ $pole1 ]==2){// Цифровой период
                if(is_array($arr)){
                    $arr[0] = isset($arr[0])? $arr[0] : '';
                    $arr[1] = isset($arr[1])? $arr[1] : '';
                    if($arr[0]<>$arr[1]){
                        if($arr[0]<>''){
                            $arr[0] = 'от '.$arr[0];
                        }
                        if($arr[1]<>''){
                            $arr[1] = ' до '.$arr[1];
                        }
                        $arr = trim(implode('',$arr));
                    }else{
                        $arr = $arr[0];
                    }
                }
            }


            if(!empty($arr)){

                if($flag_value==1){// связь по id
                    $pole = 'attribute_value_id';
                }elseif($flag_value==2){// значение введенное пользователем
                    $pole = 'value';
                }
                if(is_array($arr)){
                    foreach($arr as $v){

                        // Проверяем не пользовательское ли значение и есть ли в базе.
                        // Если нет довабляем в slov_attribute_value -> attribute_value и возвращаем attribute_value_id
                        $arr_p = $g->ProverkaAndInsertSlovAttributeValue(array(	'flag'				=> 'buy_sell',
                            'categories_id'		=> $categories_id,
                            'attribute_id'		=> $m['attribute_id'],
                            'attribute_value'	=> $v ));
                        $attribute_value_id = $arr_p['attribute_value_id'];

                        if($attribute_value_id){
                            // проверяем есть ли значение (если нет добавляем, если есть изменяем)
                            $ra = reqBuySellAttribute(array('buy_sell_id'=>$buy_sell_id,'attribute_id'=>$m['attribute_id'],'attribute_value_id'=>$attribute_value_id,'one'=>true));
                            if(empty($ra)){
                                $STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, attribute_value_id) VALUES (?,?,?); " ,
                                    array( $buy_sell_id,$m['attribute_id'],$attribute_value_id ));
                                if($STH){
                                    //vecho(array( $buy_sell_id,$m['attribute_id'],$v ));
                                    $bsa_id[] = $db->lastInsertId();
                                    if( $in['flag_buy_sell']==2 && $in['id'] ){// сохранять номенклатуру
                                        $flag_nomenclature = false;
                                    }
                                }
                            }elseif($ra['id']){
                                $bsa_id[] = $ra['id'];
                            }
                        }
                    }
                }else{
                    if($flag_value==1){// связь по id
                        // Если нет довабляем в slov_attribute_value -> attribute_value и возвращаем attribute_value_id
                        $arr_p = $g->ProverkaAndInsertSlovAttributeValue(array(	'flag'				=> 'buy_sell',
                            'categories_id'		=> $categories_id,
                            'attribute_id'		=> $m['attribute_id'],
                            'attribute_value'	=> $arr ));
                        $arr = $arr_p['attribute_value_id'];
                    }


                    // проверяем есть ли значение (если нет добавляем, если есть изменяем)
                    $ra = reqBuySellAttribute(array('buy_sell_id'=>$buy_sell_id,'attribute_id'=>$m['attribute_id'],'one'=>true));
                    //$bsa_id[] = $ra['id'];
                    if(empty($ra)){
                        $STH = PreExecSQL(" INSERT INTO buy_sell_attribute (buy_sell_id, attribute_id, ".$pole.") VALUES (?,?,?); " ,
                            array( $buy_sell_id,$m['attribute_id'],trim($arr) ));
                        if($STH){
                            $bsa_id[] = $db->lastInsertId();
                        }
                    }elseif($ra[ $pole ]<>$arr){
                        $STH = PreExecSQL(" UPDATE buy_sell_attribute SET ".$pole."=? WHERE id=?; " ,
                            array( $arr,$ra['id'] ));
                        if($STH){
                            $bsa_id[] = $ra['id'];
                            if( $in['flag_buy_sell']==2 && $ra[ $pole ]==$arr ){// не сохранять номенклатуру
                                //$flag_nomenclature = true;
                            }
                        }
                    }else{
                        $bsa_id[] = $ra['id'];
                    }
                }
            }else{
                if($no_empty){
                    $error_required[] = $m['attribute'];
                }
            }

        }

        // удаляем значения из buy_sell_attribute если они остались
        $ids = implode(',',$bsa_id);
        if($ids){
            $STH = PreExecSQL(" DELETE FROM buy_sell_attribute WHERE buy_sell_id=? AND NOT id IN (".$ids."); " ,
                array( $buy_sell_id ));
        }

    }
    if(!empty($error_required)){
        $code = 'Заполните: '.implode(', ',$error_required);
        $ok = false;
        if($flag_insert){
            $STH = PreExecSQL(" DELETE FROM buy_sell WHERE id=?; " ,
                array( $buy_sell_id ));
        }
    }


    if($ok&&!$in['id']){
        // действия при "исполнено" , "возврат" , "возвращено"
        if($in['status']==12){// исполнено
            $bs->ChangeStatusBuy(array(	'row'			=> $r_p,
										'status'		=> 12 ));
			if($in['company_id3']){// если указано в заявке для кого завка, 
									// то при исполении создаем в разделе "Мои объявления"->"Купленое" покупку у "company_id3"
					$r = reqCompany(array('id'=>$in['company_id3']));
					$login_id = $r['login_id'];
					$arr2 = $bs->CopyRowBuySell(array(	'buy_sell_id'	=> $buy_sell_id,
														'parent_id'		=> $buy_sell_id,
														'copy_id'		=> 0,
														'login_id'		=> $login_id,
														'company_id'	=> $in['company_id3'],
														'company_id2'	=> COMPANY_ID,
														'flag_buy_sell'	=> 2,
														'status'		=> 11
					));
			}
            // добавляем товар на склад
            $bs->AddStock(array(	'buy_sell_id'	=> $buy_sell_id,
								'categories_id'	=> $categories_id,
								'flag'			=> 'status_buy_sell_id12' ));
        }elseif($in['status']==14){// возврат
            $bs->ChangeStatusBuy(array(	'row'			=> $r_p,
										'buy_sell_id'	=> $buy_sell_id,
										'parent_id'		=> 0,
										'status'		=> 14,
										'where_status'	=> 11,
										'amount'		=> $in['amount'] ));
        }elseif($in['status']==15){// возвращено
            $bs->ChangeStatusBuy(array(	'row'			=> $r_p,
										'status'		=> 15 ));
        }
        //
    }

    // формируем и сохраняем html представление "строки" "Мои заявки" (КРОМЕ предложения)
    //$tr = '';
    if( $ok && ($in['status']<>10) && COMPANY_ID ){
        $bs->SaveCacheBuySell(array('buy_sell_id'=>$buy_sell_id,'flag_buy_sell'=>$flag_buy_sell));
        //$tr = $t->TrMyBuySellCache(array('buy_sell_id'=>$buy_sell_id,'flag_buy_sell'=>$flag_buy_sell));
    }


    $jsd['ok'] 					= $ok;
    $jsd['code'] 				= $code;
    $jsd['noautorize'] 			= $noautorize;
    $jsd['id']		 			= $buy_sell_id;
    $jsd['parent_id']			= $parent_id;
    $jsd['flag_buy_sell']		= $flag_buy_sell;
    $jsd['flag_nomenclature'] 	= $flag_nomenclature;
    //$jsd['tr'] 					= $tr;
    $jsd['flag_reload'] 			= $flag_reload;
}
// сохранить и вернуть cache_buy_sell
elseif($_GET['route'] == 'get_cache_buy_sell'){
    $tr = '';
    if( $in['status']<>10 && COMPANY_ID ){
        $bs->SaveCacheBuySell(array('buy_sell_id'=>$in['buy_sell_id'],'flag_buy_sell'=>$in['flag_buy_sell']));
        $tr = $t->TrMyBuySellCache(array('buy_sell_id'=>$in['buy_sell_id'],'flag_buy_sell'=>$in['flag_buy_sell']));
    }
    $jsd['tr'] = $tr;
}
// форма заполнения атрибутов для действий (Предложение, Куплено, Исполнено, Возврат)
elseif($_GET['route'] == 'form_buy_sell'){

    $ok = false;
    $code2 = '';

    $r = reqBuySell_ajax_form_buy_sell(array('id'=>$in['id']));

    if( $r['status_buy_sell_id']==2 && ($r['company_id']<>COMPANY_ID) ){// подписан на компанию чья опубликованная заявка
        if($r['flag_subscriptions_company_in']){
            $ok = true;
        }else{
            $code = 'Чтоб дать предложение вам нужно подписаться на пользователя';
        }
    }else{
        $ok = true;
    }


    if( v_int($in['categories_id']) && $ok ){
        $code = $t->CategoriesAttributeAction(array(	'parent_id'			=> $in['id'],
            'categories_id'		=> $in['categories_id'],
            'flag'				=> $in['flag'],
            'flag_account'		=> $in['value'],
            'status'			=> $in['status'],
            'share_url'			=> $in['share_url'] ));

        if($in['status']==10){
            if($in['flag']=='buy'){
                reqInsertCounterBuysellone(array('buy_sell_id'=>$in['id']));// счетчик просмотров
            }
            // Есть ли ранее предложения этого пользователя
            $code2 = $t->TrOfferByBuySell(array( 'buy_sell_id'	=> $in['id'],
                'share_url'		=> $in['share_url'],
                'flag'			=> $in['flag'] ));
        }
    }



    $jsd['ok'] 	= $ok;
    $jsd['code']	= $code.$code2;
}
//Загрузка файлов
elseif($_GET['route'] == 'upload_files_buy_sell'){
    require_once './protected/core/class_upload.php';// класс загрузки файлов
    //sleep(1);
    $STH	= false;
    $code	= 'Нельзя загрузить файл';
    $name_dir = $name_file = '';// имя папки, файла
    $status 	= 'error';

    $name_dir = 'buy_sell/'.$in['id'];// имя папки

    if( $name_dir ){

        if(isset($_FILES['upload'])){
            $file = $_FILES['upload'];
            $tmp_name=$file['name'];
            $tmp_name_arr=explode(".",$tmp_name);
            $last_tmp_name_arr=count($tmp_name_arr)-1;
            $raz=$tmp_name_arr[$last_tmp_name_arr];
            $raz=strtolower($raz);

            //Проверяем тип файла
            $file_types = array('jpg', 'jpeg', 'gif', 'png', 'bmp');// изображения

            if(in_array($raz, $file_types)){//проверка по разрешению

                $handle = new \Verot\Upload\Upload($_FILES['upload'], 'ru_RU');
                //$handle = new upload($_FILES['upload'], 'ru_RU');
                if ($handle->uploaded) {

                    //переименовываем файл
                    $handle->file_new_name_body = $g->rus2translit($tmp_name_arr[0]);
                    //разрешаем изменять размер изображения
                    $handle->image_resize = true;
                    //ширина изображения будет 750px
                    $handle->image_x = 750;
                    $handle->image_y = 750;
                    //сохраняем соотношение сторон в зависимости от ширины
                    $handle->image_ratio = true;
                    //Запретить изменять размеры изображений меньше ... пикселей в ширину и длину
                    $handle->image_ratio_no_zoom_in = true;

                    //загружаем файл в папку
                    $handle->process( FILES_ROOT_PATH.$name_dir );
                    if ($handle->processed) {
                        $handle->clean();
                        $name_file		= $handle->file_dst_name;		// имя файла после обработки
                        $type_file			= $handle->file_dst_name_ext; // расширение после обработки
                        $root_path_file		= FILES_ROOT_PATH.$name_dir.'/'.$name_file;
                        $path_file 		= FILES_PATH.$name_dir.'/'.$name_file;
                        if(file_exists($root_path_file)){//файл загружен сохраняем путь в базу
                            // пишем в базу
                            $STH = PreExecSQL(" INSERT INTO buy_sell_files (buy_sell_id, path, name_file, type_file) VALUES (?,?,?,?) " ,
                                array( $in['id'],$path_file,$tmp_name,$type_file ));
                            if($STH){
                                $code	= 'Файл загружен';
                                $status 	= 'server';
                            }
                        }else{
                            $status = 'error';
                        }
                    } else {
                        $status = 'error';
                        //$code = 'Ошибка : ' . $handle->error;
                    }
                } else {
                    $status = 'error';
                }
            }else{
                $status = 'error';
            }
        }
    }else{
        $status 	= 'error';
    }

    $jsd['code'] 	= $code;
    $jsd['status'] 	= $status;
    $jsd['name'] 	= $name_file;
}
//удалить файл
elseif($_GET['route'] == 'delete_file_buy_sell'){
    $ok 		= false;
    $code 	= 'Нельзя удалить';
    $r 		= reqBuySellFiles(array('id_md5'=>$in['value']));

    $rez 	= $g->deleteFile($r['path']);
    if($rez){
        $STH = PreExecSQL(" DELETE FROM buy_sell_files WHERE id=? " ,
            array($r['id']));
        if($STH){
            $ok = true;
        }
    }


    $jsd['ok'] 	= $ok;
    $jsd['code'] = $code;
}
// autocomplete Поисковый запрос
elseif($_GET['route'] == 'autocomplete_search'){
    $categories_id = $cities_id = '';
    $flag_search = $in['flag_buy_sell'];// по умолчанию

    $in['value'] = trim($in['value']);

    // получаем данные поиска
    if($in['flag']=='modal'||$in['flag']=='top'||$in['flag']=='mainpage'){
        $rf = reqSearchFilterParamCompany(array('login_id'=>LOGIN_ID,'company_id'=>COMPANY_ID));
												$flag_search 	= $rf['flag_search'];
												$categories_id	= $rf['categories_id'];
												$cities_id 	= $rf['cities_id'];
    }

    //var_dump($in['where'].'<br>'.$cities_id.'<br>'.$categories_id.'<br>'.$in['value']);
    $r	= reqSearchRequestAutocomplete(array(	'value' 		=> $in['value'],
												'flag'			=> $in['flag'],
												'flag_buy_sell'	=> $flag_search,
												'categories_id'	=> $categories_id,
												'cities_id'		=> $cities_id,
												'where'			=> $in['where']	));

    foreach($r as $i => $m){
        $categories = ($m['categories'])? ' &larr; '.$m['categories'].' &larr; '.$m['categories_2'] : '';
        $jsd[] = array( 	'categories_id'	=> $m['categories_id'] ,
						'name' 			=> $m['value'].'<span class="text-muted"> &larr; '.$m['nflag_pole'].$categories.'</span>',
						'name2' 		=> $m['value'],
						'value' 		=> $m['value'],
						'nomenclature_id'=> $m['nomenclature_id'],// в случае номенклатуры
						'id_attribute'	=> $m['id_attribute'],
						'flag'			=> $m['flag'] );
    }
    if (empty($jsd)) $jsd[] = array('name' => '<span class="text-muted">не найдено</span>' , 'name2' =>'не найдено' );
}
// autocomplete Поисковый запрос ДЛЯ КИРИЛЛА
elseif($_GET['route'] == 'autocomplete_search_k'){
    $categories_id = $cities_id = '';
    $flag_search = $in['flag_buy_sell'];// по умолчанию

    $in['value'] = trim($in['value']);

    // получаем данные поиска
    if($in['flag']=='modal'||$in['flag']=='top'||$in['flag']=='mainpage'){
        $rf = reqSearchFilterParamCompany(array('login_id'=>LOGIN_ID,'company_id'=>COMPANY_ID));
        $flag_search 	= $rf['flag_search'];
        $categories_id	= $rf['categories_id'];
        $cities_id 	= $rf['cities_id'];
    }

    //var_dump($in['where'].'<br>'.$cities_id.'<br>'.$categories_id.'<br>'.$in['value']);
    $r	= reqSearchRequestAutocomplete(array(	'value' 		=> $in['value'],
        'flag'			=> $in['flag'],
        'flag_buy_sell'	=> $flag_search,
        'categories_id'	=> $categories_id,
        'cities_id'		=> $cities_id,
        'where'			=> $in['where']	));

    foreach($r as $i => $m){
        //$categories = ($m['categories'])? ' &larr; '.$m['categories'] : '';
        $jsd2[] = array( 'categories_id'	=> $m['categories_id'] ,
            'category_name' => $m['value'],
            'nflag_pole'	=> $m['nflag_pole'] ,
            //'cats2'			=> $m['categories'] ,//переделать в cats
            'cats'			=> array($m['categories'],$m['categories_2']) ,
            'value' 		=> $m['value'],
            'nomenclature_id'=> $m['nomenclature_id'],// в случае номенклатуры
            'id_attribute'	=> $m['id_attribute'],
        );
    }

    if (!empty($jsd2)){
        $jsd = array('code'	=> 1,
            'data'	=> $jsd2);
    }else{
        $jsd = array('code'	=> 0,
            'data'	=> array('name' => 'не найдено')
        );
    }
}
// autocomplete Город
elseif($_GET['route'] == 'autocomplete_cities'){
    $r	= reqCities(array('value' => $in['value'] , 'count_page'=>10));
    foreach($r as $i => $m){
        $jsd[] = array( 'id'=>$m['id'] , 	'name' 			=> $m['name'],
            'name2' 		=> $m['name'],
            'id' 			=> $m['id'],
            'value' 		=> $m['name'],
            'cities_id'		=> $m['id'] );
    }
    if (empty($jsd)) $jsd[] = array('name' => '<span class="text-muted">не найдено</span>' , 'name2' =>'не найдено' );
}
// подгрузка сгруппированых предложений
elseif($_GET['route'] == 'view_grouping'){

    if($in['flag']=='sell'){

        $code = $t->TrViewGrouping_Sell(array('val_grouping'=>$in['value']));

    }elseif($in['flag']=='offer'){

        $arr = $t->TrViewGrouping_Offer(array('parent_id'		=> $in['parent_id'],
            'val_grouping'	=> $in['value'],
            'flag_limit'	=> $in['flag_limit'],
            'start_limit'	=> $in['start_limit'] ));

        $code = $arr['code'];

        // удаляем оповещение(маркеры)
        if($arr['tid']){
            reqDeleteNotification(array('notification_id'=>2,'tid'=>$arr['tid']));
        }



    }

    $jsd['code'] = $code;
}
// подгрузка сгруппированых Мои предложений
elseif($_GET['route'] == 'view_group_mybuysell'){

    $rf = reqSearchFilterParamCompany(array('login_id'=>LOGIN_ID,'company_id'=>COMPANY_ID));

    $arr = explode('/',$in['where']);

    $status_buy_sell_id = isset($arr[3])?  $arr[3] : '';

    $code = $t->NextTrMyBuySell(array(	'start_limit'			=> $in['start_limit'],
        'flag_buy_sell'			=> $in['flag_buy_sell'],
        'status_buy_sell_id'	=> $status_buy_sell_id,
        'categories_id' 		=> $rf['categories_id'],
        'cities_id' 			=> $rf['cities_id'],
        'value' 				=> $in['value'],
        'group_id' 				=> $in['group_id'],
        'flag_group_id' 		=> true,
        'group' 				=> $in['group'] ));


    $jsd['code'] = $code;
}
// поиск
elseif($_GET['route'] == 'search_buy_sell'){

    $arr = array();
    $arr_cat = array();
    $arr_cities = array();
    $url_fbs40 = '';
    $enter13 = $in['enter13'];

    $rf = reqSearchFilterParamCompany(array('login_id'=>LOGIN_ID,'company_id'=>COMPANY_ID));

    if ($rf['categories_id']) {
        $sql = "SELECT url_categories FROM slov_categories WHERE id=?";
        $url_categories = PreExecSQL_one($sql,array($rf['categories_id']));
        $arr_cat[] = $url_categories["url_categories"];
    } else {
        $arr_cat[] = '';
    }

    if ($rf['cities_id']) {
        $sql = "SELECT url_cities FROM a_cities WHERE id=?";
        $url_cities = PreExecSQL_one($sql,array($rf['cities_id']));
        $arr_cities[] = $url_cities["url_cities"];
    } else {
        $arr_cities[] = '';
    }



    //$arr[] = ($rf['categories_id'])? 	'categories_id='.$rf['categories_id'] 	: '';
    //$arr[] = ($rf['cities_id'])? 		'cities_id='.$rf['cities_id'] 			: '';
    $arr[] = ($rf['flag_interest'])? 	'interests=true' 						: '';


    $arr_w = explode('/',$in['where']);
    if(isset($arr_w[1])&&$arr_w[1]=='buy-sell'){
        if(isset($arr_w[2])&&$arr_w[2]=='buy'){
            $url_fbs40 = 'buy';
        }else{
            $url_fbs40 = 'sell';
        }
    }


    if(($rf['flag']==1||$rf['flag']==0)&&COMPANY_ID){
        $url_fbs = 'buy-sell/buy/0';
    }elseif($rf['flag']==21){
        $url_fbs = ($rf['flag_buy_sell']==1)? 	'sell' 	: 'buy';
    }elseif($rf['flag']==22){
        $url_fbs = ($rf['flag_buy_sell']==1)? 	'sell' 	: 'buy';
        $arr[]	= 'flag=22';
    }elseif($rf['flag']==23){
        $url_fbs = ($rf['flag_buy_sell']==1)? 	'sell' 	: 'buy';
        $arr[]	= 'flag=23';
    }elseif($rf['flag']==5||$rf['flag']==6||$rf['flag']==7){
        $url_fbs = 'subscriptions';
        $arr = $arr_cat = $arr_cities = array();
    }elseif($rf['flag']==40){// мои заявки
        $url_fbs = 'buy-sell/'.$url_fbs40.'/0';
        $arr = $arr_cat = $arr_cities = array();
    }elseif($rf['flag']==41){// не опубликованные
        $url_fbs = 'buy-sell/'.$url_fbs40.'/1';
        $arr = $arr_cat = $arr_cities = array();
    }elseif($rf['flag']==42){// опубликованные
        $url_fbs = 'buy-sell/'.$url_fbs40.'/2';
        $arr = $arr_cat = $arr_cities = array();
    }elseif($rf['flag']==43){// активные
        $url_fbs = 'buy-sell/'.$url_fbs40.'/3';
        $arr = $arr_cat = $arr_cities = array();
    }elseif($rf['flag']==44){// архив
        $url_fbs = 'buy-sell/'.$url_fbs40.'/4';
        $arr = $arr_cat = $arr_cities = array();
    }elseif($rf['flag']==411){// купленные
        $url_fbs = 'buy-sell/'.$url_fbs40.'/11';
        $arr = $arr_cat = $arr_cities = array();
    }elseif($rf['flag']==412){// исполненные
        $url_fbs = 'buy-sell/'.$url_fbs40.'/12';
        $arr = $arr_cat = $arr_cities = array();
    }elseif($rf['flag']==414){// возврат
        $url_fbs = 'buy-sell/'.$url_fbs40.'/14';
        $arr = $arr_cat = $arr_cities = array();
    }elseif($rf['flag']==415){// возвращено
        $url_fbs = 'buy-sell/'.$url_fbs40.'/15';
        $arr = $arr_cat = $arr_cities = array();
    }elseif($rf['flag']==50){// номенклатура
        $url_fbs = 'nomenclature';
        $arr = $arr_cat = $arr_cities = array();
    }elseif($rf['flag']==60){// пользователи
        $url_fbs = 'subscriptions/profile';
        $arr = $arr_cat = $arr_cities = array();
    }else{
        $url_fbs = ($rf['flag_search']==1)? 	'sell' 	: 'buy';
    }

    // Etp
    if($in['flag']=='etp_sell'){
        $url_fbs 	= 'sell';
        $arr[] 	= 'etp=true';
    }
    ///


//		$row = array('buy-sell/buy'=>'Мои заявки','buy-sell/sell'=>'Мои объявления','buy'=>'Заявки','sell'=>'Объявления','subscript'=>'Пользователи');
    if($rf['flag_search']&&$rf['flag']<6){// выбор места поиска

        $arr_w = explode('/',$in['where']);
        //vecho($arr_w);

        $flag = 0;
        if($rf['flag_search']==2){
            $flag_search 	= 'buy-sell/buy';
            $flag			= ($arr_w[1]=='buy-sell')? 1 : 0;
        }elseif($rf['flag_search']==1){
            $flag_search 	= 'buy-sell/sell';
            $flag			= ($arr_w[1]=='buy-sell')? 1 : 0;
        }elseif($rf['flag_search']==4){
            $flag_search 	= 'buy';
        }elseif($rf['flag_search']==3){
            $flag_search = 'sell';
        }elseif($rf['flag_search']==5){
            $flag_search = 'subscriptions/profile';
        }

        //if(strpos($in['where'], $flag_search)){
        if($flag==1){
            $url_fbs = substr($in['where'], 1);
        }else{
            $url_fbs = $flag_search;
        }
        //vecho($in['where'].'*'.$flag_search.'*'.$url_fbs.'*'.$rf['flag_search']);
    }

    if($in['group']){// признак группировки выборки на странице "Мои заявки"
        $arr[] = 'group='.$in['group'];
    }

    $arr[] = ($in['value'])? 				'value='.trim($in['value']) 		: '';



    // Допустимые категории для запроса на стороннии ресурсы
    $rc = reqSlovCategories(array('id'=>$rf['categories_id']));
    if(isset($rc['parent_id'])){
        $at = array(386,389,388);// допустимые категории 3 уровнея
        if(in_array($rc['parent_id'], $at)){//
            $code_qrq = '';
            /*
					// Здесь должен быть Флаг разрешающий отправлять запрос в Autopiter
					$code_qrq .= $qrq->QrqHtmlQuestionSearch(array('artname'=>$in['value'],'qrq_id'=>1));

					// Здесь должен быть Флаг разрешающий отправлять запрос в Armtek
					$code_qrq .= $qrq->QrqHtmlQuestionSearch(array('artname'=>$in['value'],'qrq_id'=>2));
					*/
            $arr[] = ($code_qrq)? 	'modal=true' : '';
        }
    }
    ///


    $arr = array_diff($arr, array(''));
    $arr_cat = array_diff($arr_cat, array(''));
    $arr_cities = array_diff($arr_cities, array(''));


    //var_dump($arr);
    //die;

    $url = implode('&',$arr);
    $url_cat = implode('/',$arr_cat);
    $url_cities = (!empty($arr_cities)) ? '/'.implode('/',$arr_cities) : '';



    //$url = $url_fbs.'/?'.$url;
    $url = '/'.$url_fbs.$url_cities.'/'.$url_cat.'?'.$url;
    //$url = '/'.$url_fbs.'?'.$url;

    $jsd['url'] = $url;
}
// подгрузка
elseif($_GET['route'] == 'scroll_page'){

    $ok = false;

    if( $in['flag']=='buy_sell' && COMPANY_ID ){// Страница "Мои заявки/объявления"
        $code = $t->NextTrMyBuySell(array(	'start_limit'			=> $in['start_limit'],
            'flag_buy_sell'			=> $in['flag_buy_sell'],
            'status_buy_sell_id'	=> $in['status'],
            'categories_id' 		=> $in['categories_id'],
            'cities_id' 			=> $in['cities_id'],
            'value' 				=> $in['value'],
            'group' 				=> $in['group'] ));
    }elseif($in['flag']=='pagebuy'){// Страница "Чужие заявки"
        $flag_companyprofile = ($in['where']=='company_profile')? true : false;
        $code = $t->NextTrPageBuy(array(		'start_limit'			=> $in['start_limit'],
            'flag_interests' 		=> $in['flag_interests'],
            'share_url' 			=> $in['share_url'],
            'categories_id' 		=> $in['categories_id'],
            'cities_id' 			=> $in['cities_id'],
            'value'					=> $in['value'],
            'flag_search' 			=> $in['flag_search'],
            'company_id' 			=> $in['company_id'],
            'flag_companyprofile'	=> $flag_companyprofile
        ));
    }elseif($in['flag']=='subscr_profile'){// Страница "Подписки"

        $code = $t->NextTrPageSubscrProfile(array(	'start_limit' 	=> $in['start_limit'],
            'views' 		=> $in['views'],
            'value'			=> $in['value'] ));
    }elseif($in['flag']=='chat'){// Страница "Папки сообщений"

        $code = $t->NextTrPageMessagesFolders(array( 	'start_limit' 	=> $in['start_limit'],
            'views' 		=> $in['views'] ));
    }elseif($in['flag']=='nomenclature'){// Страница "Номенклатура"

        $code = $t->NextTrPageNomenclature(array(	'start_limit' 	=> $in['start_limit'] , 'value' 	=> $in['value'] ));

    }elseif($in['flag']=='search_categories'){// Страница "админка Поисковый запрос"

        $code = $t->NextTrPageSearchCategories(array(	'start_limit' 	=> $in['start_limit'] ));

    }elseif($in['flag']=='stock'){// Страница "Склад"

        $code = $t->NextTrPageStock(array(	'start_limit' 		=> $in['start_limit'],
            'stock_id' 			=> $in['stock_id'],
            'status_buy_sell_id'=> $in['status_buy_sell_id'],
            'value'				=> $in['value'] ));
    }


    $ok = ($code)? true : false;

    $jsd['ok'] 				= $ok;
    $jsd['code']				= $code;
}
// Подписаться не авторизованный
elseif($_GET['route'] == 'action_subscriptions_no_autorize'){
    $ok = false;
    $code = 'Нельзя сохранить';

    // создаем идентификатор куки для подписки на пользователя после регистрации
    $STH = PreExecSQL(" INSERT INTO subscriptions_no_autorize (company_id_from, cookie_session) VALUES (?,?); " ,
        array( $in['id'],COOKIE_SESSION ));

    if($STH){
        $ok 		= true;
        $code 	= 'Сохранено';
    }


    $jsd['ok'] 	= $ok;
    $jsd['code']	= $code;
}
// сохранение - параметров поиска
elseif($_GET['route'] == 'save_search_filter_param_company'){

    $ok = false;
    $code = 'Нельзя сохранить';
    $flag_search = ($in['flag_search'])? $in['flag_search'] : 0;



    $rf = reqSearchFilterParamCompany(array('login_id'=>LOGIN_ID,'company_id'=>COMPANY_ID));

    $categories_id	= ($in['categories_id'])? 	$in['categories_id'] 	: 0;
    $cities_id 	= ($in['cities_id'])? 		$in['cities_id'] 		: 0;
    /*
	if($in['where']=='modal'){
		$categories_id	= ($in['categories_id'])? 	$in['categories_id'] 	: 0;
		$cities_id 	= ($in['cities_id'])? 		$in['cities_id'] 		: 0;
	}elseif($in['where']=='mainpage'){
		$categories_id	= ($in['categories_id'])? 	$in['categories_id'] 	: 0;
		$cities_id 	= ($in['cities_id'])? 		$in['cities_id'] 		: 0;
	}elseif($in['where']=='top'){
		//$rf = reqSearchFilterParamCompany(array('login_id'=>LOGIN_ID,'company_id'=>COMPANY_ID));
		//$rf = !empty($rf)? $rf : array( 'where'=>0 , 'categories_id'=>0 , 'cities_id'=>0 );
		//$flag_search 	= $rf['flag_search'];
		$categories_id	= ($in['categories_id'])? 	$in['categories_id'] : 0;
		$categories_id	= ($categories_id)? 			$categories_id 		: 0;
		//$cities_id 	= $rf['cities_id'];
	}
	*/

    $in['flag'] 		= ($in['flag'])? 				$in['flag'] 		: 0;
    $flag_interest 		= ($in['interests_id'])? 		1 				: 0;
    $in['sort_12'] 	= ($in['sort_12'])? 				$in['sort_12'] 	: 0;
    $in['sort_who'] 	= ($in['sort_who'])? 			$in['sort_who'] 	: 'sort_date';


    //if($rf['cookie_session']){// проверяем заполнено ли (cookie_session)
    if(!COMPANY_ID){
        // очищаем раннее данные
        $STH = PreExecSQL(" DELETE FROM search_filter_param_company WHERE login_id=? AND company_id=? AND cookie_session=?; " ,
            array( LOGIN_ID , COMPANY_ID , COOKIE_SESSION ));
    }else{
        // очищаем раннее данные
        $STH = PreExecSQL(" DELETE FROM search_filter_param_company WHERE login_id=? AND company_id=?; " ,
            array( LOGIN_ID , COMPANY_ID ));
    }

    if($STH){
//vecho(array( LOGIN_ID,COMPANY_ID,COOKIE_SESSION,$flag_search,$categories_id,$cities_id,$in['flag'],$flag_interest ));
        $STH = PreExecSQL(" INSERT INTO search_filter_param_company (login_id,company_id,cookie_session,flag_search,categories_id,cities_id,flag,flag_interest,sort_12,sort_who) VALUES (?,?,?,?,?,?,?,?,?,?); " ,
            array( LOGIN_ID,COMPANY_ID,COOKIE_SESSION,$flag_search,$categories_id,$cities_id,$in['flag'],$flag_interest,$in['sort_12'],$in['sort_who'] ));
    }

    if($STH){
        $ok = true;
    }


    $jsd['ok'] 			= $ok;
    $jsd['code']			= $code;
}

// Модальное окно Написать тикет
elseif($_GET['route'] == 'modal_write_ticket'){

    $arr = $f->FormWriteTicket(array('id'=>$in['id']));

    $code = $t->getModal(
        array('class_dialog' => 'writeticket', 'top' => $arr['top'], 'content' => $arr['content'], 'bottom' => $arr['bottom']),
        array('id' => 'writeticket-form', 'class' => '')
    );

    $jsd['code'] = $code;
}
// Написать новый тикет
elseif($_GET['route'] == 'create_new_ticket'){

    $ok = false;
    $code = '';

    //входящие данные по папке
    $ticket_text 	= $in['ticket_text'];
    $vaznost	 	= $in['vaznost'] ?? 0; //1 - Важно, 2 - Средне, 3 - Не важно //  ?? - оператор объединения с NULL
    $ticket_flag 	= $in['ticket_flag'];  //1 - Ошибка, 2 - Предложение
    $status 		= 1;  //1 - Активные, 2 - Исполненные, 0 - Архив

    $folder = reqTicketSlovStatus(array('id'=>$ticket_flag));

    $inv 			= ''; // Страница с которой написали
    $mincount		= 10; //минимальное кол-во символов в тикете

    if(strlen($ticket_text) > $mincount){  //!empty($ticket_text) &&

        if (!$vaznost > 0){
            $ok = false;
            $code = 'Тикет должен иметь важность';
        } else {


            //Добавление тикетов
            $STH1 = PreExecSQL(" INSERT INTO tickets2 (owner_id,ticket_exp,ticket_flag,vazh,inv) VALUES (?,?,?,?,?); " ,
                array(COMPANY_ID,$ticket_text,$ticket_flag,$vaznost,$inv));

            $ticket_id = $db->lastInsertId();

            if(!empty($in['media'])){
                $media 	= explode(',',$in['media']); //прикрепленные медиа файлы
                foreach($media as $i => $val){
                    //Добавление информации о файлах
                    $STH4 = PreExecSQL(" INSERT INTO tickets2_files (file_name,ticket_id) VALUES (?,?); " ,
                        array($val,$ticket_id));
                }
            }



            if($STH1){
                $ok = true;
                $code = 'Тикет добавлен.';

                //История движения тикета
                $STH5 = PreExecSQL(" INSERT INTO tickets2_history (ticket_id,status1,status2,flag,user_id) VALUES (?,?,?,?,?); " ,
                    array($ticket_id,$ticket_flag,$ticket_flag,1,COMPANY_ID));

            }
        }
    } else {
        $ok = false;
        $code = 'Тикет должен иметь текст длиной не менее 500 символов';
    }


    $jsd['ok'] = $ok;
    $jsd['code'] = $code;
    $jsd['folder'] = !empty($folder)? $folder["status_class"]: '';
}
// Смена флага тикета
elseif($_GET['route'] == 'change_ticket'){

    $ok = false;
    $code = '';

    //входящие данные
    $ticket_id 	= $in['id'];
    $ticket_flag = $in['ticket_flag'];

    $folder = reqTicketSlovStatus(array('id'=>$ticket_flag));
    $ticketInfo = reqTicketMessages(array('id'=>$ticket_id));

    $ticket_curr_status = $ticketInfo[0]["ticket_flag"]; //текущий статус тикета


    //

    //var_dump('Тикет '.$ticket_id.' поменяется на '.$ticket_flag.$folder["status_class"]);
    //var_dump($ticket_curr_status);
    //var_dump($rth);
    //die;


    if(($ticket_flag != 10 )){

        //Изменение флага тикета
        $STH = PreExecSQL(" UPDATE tickets2 SET ticket_flag=? WHERE id=?; " ,
            array( $ticket_flag,$ticket_id ));

        if($STH){
            $ok = true;
            $code = 'Статус тикета изменен.';

            //История
            //изменяем флаг flag=0
            $STH4 = PreExecSQL(" UPDATE tickets2_history SET flag=? where ticket_id=?; " ,
                array(0,$ticket_id));
            $STH5 = PreExecSQL(" INSERT INTO tickets2_history (ticket_id,status1,status2,flag,user_id) VALUES (?,?,?,?,?); " ,
                array($ticket_id,$ticket_curr_status,$ticket_flag,1,COMPANY_ID));


        }

    } else {


        //описываем процесс отмены с поиском флага в истории и со сменой флага пред истории на 1

        $rth = reqTicketHistory(array('ticket_id'=>$ticket_id,'flag'=>1));
        $status1 = $rth[0]["status1"]; //возвращаем пред статус тикета при нажитии отмены

        //Изменение флага тикета
        $STH = PreExecSQL(" UPDATE tickets2 SET ticket_flag=? WHERE id=?; " ,
            array( $status1,$ticket_id ));

        if($STH){
            $ok = true;
            $code = 'Статус тикета изменен.';

            //История

            //изменяем флаг flag=0
            $STH4 = PreExecSQL(" UPDATE tickets2_history SET flag=? where ticket_id=?; " ,
                array(0,$ticket_id));

            $STH5 = PreExecSQL(" INSERT INTO tickets2_history (ticket_id,status1,status2,flag,user_id) VALUES (?,?,?,?,?); " ,
                array($ticket_id,$ticket_curr_status,$status1,1,COMPANY_ID));

        }

    }

    $jsd['ok'] = $ok;
    $jsd['code'] = $code;
    $jsd['folder'] = !empty($folder)? $folder["status_class"]: '';
}
//Загрузка медиафайлов для тикетов
elseif($_GET['route'] == 'upload_files_tickets'){

    //$ok = false;
    $code = $error = '';
    $mfiles = [];

    $folder_id = $in['id'];

    $input_name = 'file';

    if (!isset($_FILES[$input_name])) {
        exit;
    }

    // Разрешенные расширения файлов.
    $allow = array('jpg', 'jpeg', 'png', 'gif' );
    $allow_video = array( 'mp4' , '3gp' , 'avi' );

    // URL до директории хранения файлов.
    $url_path 		= '/files/tickets/'.COMPANY_ID.'/img/';
    $url_path_video = '/files/tickets/'.COMPANY_ID.'/video/';

    // Полный путь до до директории хранения файлов.
    $tmp_path 		= $_SERVER['DOCUMENT_ROOT'] . $url_path;
    $tmp_path_video = $_SERVER['DOCUMENT_ROOT'] . $url_path_video;

    if (!is_dir($tmp_path)) {
        mkdir($tmp_path, 0777, true);
    }
    if (!is_dir($tmp_path_video)) {
        mkdir($tmp_path_video, 0777, true);
    }

    // Преобразуем массив $_FILES в удобный вид для перебора в foreach.
    $files = array();
    $diff = count($_FILES[$input_name]) - count($_FILES[$input_name], COUNT_RECURSIVE);
    if ($diff == 0) {
        $files = array($_FILES[$input_name]);
    } else {
        foreach($_FILES[$input_name] as $k => $l) {
            foreach($l as $i => $v) {
                $files[$i][$k] = $v;
            }
        }
    }

    $response = array();
    foreach ($files as $file) {
        $error = $data  = '';

        //var_dump($file);

        // Проверим на ошибки загрузки.
        $ext = mb_strtolower(mb_substr(mb_strrchr(@$file['name'], '.'), 1));
        //var_dump($ext);
        if (!empty($ext) && in_array($ext, $allow_video) ) {
            //видео файлы

            //$error = 'видео файл '.$file['size'];
            if ($file['size'] > 125*200000 ) {
                $error = 'Недопустимый размер файла (не больше 25мб)';
            } else {

                /*
					require_once  './protected/source/FFMpeg/vendor/autoload.php';
					$sec = 10;
					$movie = './files/tickets/0/test.mp4';
					$thumbnail = './files/tickets/0/thumb.png';

					$ffmpeg = FFMpeg\FFMpeg::create();
					$video = $ffmpeg->open($movie);

					$frame = $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds($sec));
					$frame->save($thumbnail);
					echo '<img src="'.$thumbnail.'">';
				*/

                $thumbnail_video = '/image/thumbs-video.png';

                // Перемещаем файл в директорию с новым именем.
                $name  = 'video-'. time() . '-' . mt_rand(1, 9999999999);
                $src   = $tmp_path_video . $name . '.' . $ext;

                if (move_uploaded_file($file['tmp_name'], $src)) {

                    $mfiles[] = '
							<div class="img-item">
								<img src="' . $thumbnail_video . '">
								<a herf="#" onclick="remove_img(this); return false;"></a>
								<input type="hidden" name="images[]" value="' . $name . '.' . $ext . '">
							</div>';
                } else {
                    //$ok = false;
                    $code = 'Не удалось загрузить файл.';
                }

            }

        } else {
            //картинки
            if (!empty($file['error']) || empty($file['tmp_name']) || $file['tmp_name'] == 'none') {
                $error = 'Не удалось загрузить файл.';
            } elseif (empty($file['name']) || !is_uploaded_file($file['tmp_name'])) {
                $error = 'Не удалось загрузить файл.';
            } elseif (empty($ext) || !in_array($ext, $allow) ) {
                $error = 'Недопустимый тип файла';
            } else {
                $info = @getimagesize($file['tmp_name']);
                if (empty($info[0]) || empty($info[1]) || !in_array($info[2], array(1, 2, 3))) {
                    $error = 'Недопустимый тип файла';
                } else {
                    // Перемещаем файл в директорию с новым именем.
                    $name  = time() . '-' . mt_rand(1, 9999999999);
                    $src   = $tmp_path . $name . '.' . $ext;
                    $thumb = $tmp_path . $name . '-thumb.' . $ext;

                    if (move_uploaded_file($file['tmp_name'], $src)) {
                        // Создание миниатюры.
                        switch ($info[2]) {
                            case 1:
                                $im = imageCreateFromGif($src);
                                imageSaveAlpha($im, true);
                                break;
                            case 2:
                                $im = imageCreateFromJpeg($src);
                                break;
                            case 3:
                                $im = imageCreateFromPng($src);
                                imageSaveAlpha($im, true);
                                break;
                        }

                        $width  = $info[0];
                        $height = $info[1];

                        // Высота превью 100px, ширина рассчитывается автоматически.
                        $h = 100;
                        $w = ($h > $height) ? $width : ceil($h / ($height / $width));
                        $tw = ceil($h / ($height / $width));
                        $th = ceil($w / ($width / $height));

                        $new_im = imageCreateTrueColor($w, $h);
                        if ($info[2] == 1 || $info[2] == 3) {
                            imagealphablending($new_im, true);
                            imageSaveAlpha($new_im, true);
                            $transparent = imagecolorallocatealpha($new_im, 0, 0, 0, 127);
                            imagefill($new_im, 0, 0, $transparent);
                            imagecolortransparent($new_im, $transparent);
                        }

                        if ($w >= $width && $h >= $height) {
                            $xy = array(ceil(($w - $width) / 2), ceil(($h - $height) / 2), $width, $height);
                        } elseif ($w >= $width) {
                            $xy = array(ceil(($w - $tw) / 2), 0, ceil($h / ($height / $width)), $h);
                        } elseif ($h >= $height) {
                            $xy = array(0, ceil(($h - $th) / 2), $w, ceil($w / ($width / $height)));
                        } elseif ($tw < $w) {
                            $xy = array(ceil(($w - $tw) / 2), ceil(($h - $h) / 2), $tw, $h);
                        } else {
                            $xy = array(0, ceil(($h - $th) / 2), $w, $th);
                        }

                        imageCopyResampled($new_im, $im, $xy[0], $xy[1], 0, 0, $xy[2], $xy[3], $width, $height);

                        // Сохранение.
                        switch ($info[2]) {
                            case 1: imageGif($new_im, $thumb); break;
                            case 2: imageJpeg($new_im, $thumb, 100); break;
                            case 3: imagePng($new_im, $thumb); break;
                        }

                        imagedestroy($im);
                        imagedestroy($new_im);

                        // Вывод в форму: превью, кнопка для удаления и скрытое поле.
                        //$ok = true;
                        $mfiles[] = '
							<div class="img-item">
								<img src="' . $url_path . $name . '-thumb.' . $ext . '">
								<a herf="#" onclick="remove_img(this); return false;"></a>
								<input type="hidden" name="images[]" value="' . $name . '.' . $ext . '">
							</div>';
                    } else {
                        //$ok = false;
                        $code = 'Не удалось загрузить файл.';
                    }
                }
            }
        }

        //$response[] = array('error' => $error, 'data'  => $data);
        $jsd['mfiles'] = $mfiles;
        $jsd['code'] = $code;
        $jsd['error'] = $error;

    }

}
// Проверить доступность пользователя к не опубликованным заявкам
elseif($_GET['route'] == 'get_url_buy_sell_one'){

    $arr = $bs->GetUrlBuySellOne(array('buy_sell_id'=>$in['id']));

    $jsd['ok'] 	= $arr['ok'];
    $jsd['code']	= $arr['code'];
    $jsd['url'] 	= $arr['url'];
}
// проверяем получать ли бренды ЭТП при поиске
elseif($_GET['route'] == 'search_brend_etp'){

    $ok = false;
    $code = '';
    $error = 1;

    if($in['flag']=='infopart'){// страница https://....ru/infopart
        $rf['categories_id'] = 391;
        $rf['flag_search']	= 3;
    }else{
        $rf = reqSearchFilterParamCompany(array('login_id'=>LOGIN_ID,'company_id'=>COMPANY_ID));
    }
    // только объявления
    if($rf['flag_search']==3){
        $rc = reqSlovCategories(array('id'=>$rf['categories_id']));
        //vecho($rf['categories_id']);
        if(isset($rc['parent_id'])){
            $at = array(386,389,388);// допустимые категории 3 уровнея
            if(in_array($rc['parent_id'], $at)){//

                if(!COMPANY_ID){
                    if(!AMO_TOKEN){
                        $qrq		= new ClassQrq();
                        $token 	= $qrq->AuthorizationAmo();
                        $_SESSION['AMO_TOKEN'] 	= $token;
                    }

                }

                $arr = $qrq->AmoHtmlSearchbrend(array('flag'			=> 2,
                    'token'			=> $_SESSION['AMO_TOKEN'],
                    'artname'		=> $in['value'],
                    'categories_id'	=> $rf['categories_id']
                ));

                if($arr['code']){
                    $error = 1;
                    $code = $t->getModal(	array('class_dialog'=>'search-dialog needs-dialog','top'=>'','content'=>$arr['code']),
                        array('id'=>'','class'=>'') );
                }

            }
        }
    }


    $jsd['code'] = $code;
    $jsd['error'] = $error;
}
// получить результат предложений после выбора брендов
elseif($_GET['route'] == 'get_sell_by_amo_accountsetp'){

    $ok = $STH = false;
    $code = 'Нельзя выполнить';

    $_POST['values'] = isset($_POST['values'])? $_POST['values'] : array();



    // Очищаем старые полученные данные
    $row = reqBuySellEtpSell(array('cookie_session'=>COOKIE_SESSION,'company_id'=>COMPANY_ID));
    foreach($row as $i => $m){
        $sql = "	DELETE FROM buy_sell WHERE id=? ";

        $STH = PreExecSQL($sql,array($m['buy_sell_id']));
    }
    ///


    $arr = $qrq->InsertcronAmoBuySellSearchInfopart(array('values'=>$_POST['values'],'searchtext'=>$in['value'],'categories_id'=>$in['categories_id']));

    if($arr['ok']){
        $ok = $arr['ok'];
    }

    $jsd['ok'] 	= $ok;
    $jsd['code'] = $code;
}
// обновить предложения (объявления) при полуении с ЭТП (cron/cron_amo_buy_sell_search_infopart)
elseif($_GET['route'] == 'get_html_sell_by_infopart'){

    $ok = false;
    $tr = '';
    $last_etp_id = 0;

    $r['kol'] = true;// по умолчанию

    // Проверяем, есть ли не обработанный qwep запрос
    if($in['id']){
        $r = reqBuySell_PageSell_EtpNew(array('id'=>$in['id']));
    }


    if($r['kol']){

        // проверяем поступили ли новые предложения от qwep (проверяем с последнего пришедшего id)
        $row = reqBuySell_PageSell(array('value' 		=> $in['value'],
            'etp'			=> true	));
        $tr = '';
        $arr = array();
        foreach($row as $i => $m){

            $tr .= $t->TrPageSell22(array('row'=>$m));

            $arr[] = $m['id'];

        }

        $last_etp_id = ($tr)? max($arr) : 0;
        ///

    }


    $jsd['ok'] 	= $ok;
    $jsd['code']	= $tr;
    $jsd['id']	= $last_etp_id;
}
// показать телефон Объявление/Предложение
elseif($_GET['route'] == 'view_phone'){

	$arr = $t->ViewPhoneByBuySell(array('buy_sell_id'=>$in['id'],'amount'=>$in['amount']));

	$jsd['ok'] 		= $arr['ok'];
	$jsd['code'] 	= $arr['code'];
	$jsd['phone'] 	= $arr['phone'];
	$jsd['note'] 	= $arr['note'];
	$jsd['buy_offer'] = $arr['buy_offer'];
}




/*
*** 	END  -  НЕ АВТОРИЗОВАННОМУ ПОЛЬЗОВАТЕЛЮ
 */



/*
*** 	BEGIN  -  АВТОРИЗОВАННЫЙ ПОЛЬЗОВАТЕЛЬ
 */
if(LOGIN_ID){


    if($_GET['route'] == 'change_account_company'){
        $ok = false;
        $code = 'не возможно (';

        if($in['id']){// выбрана компания
            // проверяем принадлежность компании авторизованному пользователю
            //$r = reqCompany(array('login_id'=>LOGIN_ID,'id'=>$in['id']));
            $r = reqLoginCompanyPrava(array('login_id'=>LOGIN_ID,'company_id'=>$in['id'],'one'=>true));
            if($r['id']){
                $_SESSION['company_id'] 	= $r['company_id'];
                $_SESSION['flag_account'] 	= $r['flag_account'];	// 1 - профиль (аккаунт зарегистрированного пользователя),
                // 2 - компания,
                // 3 - несущест.поставщик
                $_SESSION['pro_mode']		= $r['pro_mode']; // Pro режим
                $_SESSION['prava'] 			= null;
                $_SESSION['prava'][ $r['prava_id'] ] = true;// не забудь отметить в config.php
                $ok = true;
                // сохраняем выбранную компанию за аккаунтом (чтобы при авторизации оставался в ней)
                $STH = PreExecSQL(" DELETE FROM company_last_session WHERE login_id=?; " ,
                    array( LOGIN_ID ));
                if($STH){
                    $STH = PreExecSQL(" INSERT INTO company_last_session (login_id,company_id) VALUES (?,?); " ,
                        array( LOGIN_ID , $r['company_id'] ));
                }
                ///
            }else{
                $code = 'хулиганим (';
            }
        }


        $jsd['ok'] 	= $ok;
        $jsd['code'] = $code;
    }
// модальное окно  при загрузке страницы
    elseif($_GET['route'] == 'modal_start'){

        $arr = $f->FormModalStartWelcome();

        $code = $t->getModal(	array('top'=>$arr['top'],'content'=>$arr['content'],'bottom'=>$arr['bottom']),
            array('id'=>'admin_categories-form','class'=>'') );

        $jsd['code'] = $code;
    }
// модальное окно Моя Компания
    elseif($_GET['route'] == 'modal_my_company'){

        $arr = $f->FormMyCompany(array('id'=>$in['id']));

        $code = $t->getModal(
            array('class_dialog' => 'registration-my-company', 'top' => $arr['top'], 'content' => $arr['content'], 'bottom' => $arr['bottom']),
            array('id' => 'my_company-form', 'class' => '')
        );
        // $code = $arr['content'];

        $jsd['code'] = $code;
    }
// сохранение Моя Компания
    elseif($_GET['route'] == 'save_my_company'){
        $ok = $STH = false;
        $code = 'Нельзя сохранить';

        $who1 = $who2 = 0;
        $v = isset($_POST['who_company'])? $_POST['who_company'] : 0; //array();

        $v = isset($_POST['who_company'])? $_POST['who_company'] : 0; //array();

        if(isset($v[0])&&$v[0]==1){// Продавец
            $who1 = 1;
        }
        if(isset($v[0])&&$v[0]==2){// Покупатель
            $who2 = 1;
        }
        if(isset($v[1])&&$v[1]==2){// Покупатель
            $who2 = 1;
        }

        /*
 	foreach($arr as $v){
		if($v==1){// Продавец
			$who1 = 1;
		}elseif($v==2){// Покупатель
			$who2 = 1;
		}
	}
	*/
        if(!$in['id']){// СОЗДАНИЕ
            // можно добавить только одну компанию
            $r = reqCompany(array('login_id'=>LOGIN_ID,'flag_account'=>2));
            if(empty($r)){// добавляем
                $STH = PreExecSQL(" INSERT INTO company (login_id,flag_account,legal_entity_id, company, email, position, tax_system_id, cities_id, who1, who2) VALUES (?,?,?,?, ?,?,?,?,?,?); " ,
                    array( LOGIN_ID,2,$in['legal_entity_id'],$in['company'],$in['email'],$in['position'],$in['tax_system_id'],$in['cities_id'],$who1,$who2 ));
                $company_id = $db->lastInsertId();
                // Права и Роль пользователя на компанию
                $STH = reqInsertLoginCompanyPrava(array(	'login_id'		=> LOGIN_ID,
                    'company_id'	=> $company_id,
                    'prava_id'		=> 2
                ));
            }else{
                $code = 'Нельзя добавить более одной компании';
            }


        }else{// РЕДАКТИРОВАНИЕ
            $STH = PreExecSQL(" UPDATE company SET legal_entity_id=?, company=?, email=?, position=?, tax_system_id=?, cities_id=?, who1=?, who2=? WHERE id=? AND login_id=?; " ,
                array( $in['legal_entity_id'],$in['company'],$in['email'],$in['position'],$in['tax_system_id'],$in['cities_id'],$who1,$who2,$in['id'],LOGIN_ID ));
            $company_id = $in['id'];
        }

        if($STH){
            $ok = true;
            // добавляем выбранные категории к компании
            $STH = PreExecSQL(" DELETE FROM company_categories WHERE company_id=?; " ,
                array( $company_id ));
            if($STH){
                $arr = isset($_POST['cc_categories'])? $_POST['cc_categories'] : array();
                foreach($arr as $v){
                    $STH = PreExecSQL(" INSERT INTO company_categories (company_id, categories_id) VALUES (?,?); " ,
                        array( $company_id,$v ));
                }
            }
        }

        $jsd['ok'] 	= $ok;
        $jsd['id'] 	= $company_id;
        $jsd['code']	= $code;
    }
// загрузить аватар/логотип
    elseif($_GET['route'] == 'upload_avatar'){
        $ok = $STH = false;
        $code = 'Нельзя сохранить';

        if(isset($_POST['image'])&&v_int($in['id'])){
            // проверяем принадлежность профиля/компании
            $r = reqCompany(array('login_id'=>LOGIN_ID,'id'=>$in['id']));
            if($r['id']){
                // создаем папку
                $g->jmkDir(FILES_ROOT_PATH.'avatar');
                $croped_image = $_POST['image'];
                list($type, $croped_image) = explode(';', $croped_image);
                list(, $croped_image)      = explode(',', $croped_image);
                $croped_image = base64_decode($croped_image);
                $image_name = $r['id'].'.png';
                if(file_put_contents(FILES_ROOT_PATH.'avatar/'.$image_name, $croped_image)){
                    $STH = PreExecSQL(" UPDATE company SET avatar=? WHERE id=? AND login_id=?; " ,
                        array( FILES_PATH.'avatar/'.$image_name,$in['id'],LOGIN_ID ));
                    if($STH){
                        $ok = true;
                        $code = 'сохранено';
                        $src = FILES_PATH.'avatar/'.$image_name.'?'.time();
                    }
                }
            }
        }

        $jsd['ok'] 	= $ok;
        $jsd['code']	= $code;
        $jsd['src']	= $src;
    }
// Сохранить данные профиля
    elseif($_GET['route'] == 'save_profile'){
        $ok = false;
        $code = 'Нельзя сохранить';
        $flag = $arr_code = array();

        $validate_email = (filter_var($in['email'], FILTER_VALIDATE_EMAIL));
        if($validate_email){
            //логин (email) занят
            $r=reqLogin(array('email'=>$in['email'],'not_id'=>LOGIN_ID));

            if(!empty($r['id'])){
                $arr_code[] 	= 'Email занят';
                $flag[] 	= 'email';
            }
            // проверяем есть ли пользователь с таким телефоном
            $in['phone'] = preg_replace("/[^0-9]/", '', $in['phone']);
            $r=reqCompany(array('phone'=>$in['phone'],'not_login_id'=>LOGIN_ID));
            if(!empty($r)){
                $arr_code[] 	= 'Пользователь с таким номером телефона зарегистрирован';
                $flag[] 	= 'phone';
            }
            if(empty($flag)){
                $STH1 = PreExecSQL(" UPDATE login SET email=? WHERE id=?; " ,
                    array( $in['email'],LOGIN_ID ));

                $STH2 = PreExecSQL(" UPDATE company SET company=?, iti_phone=?, phone=?, cities_id=? WHERE login_id=? AND flag_account=1; " ,
                    array( $in['name'],$in['value'],$in['phone'],$in['cities_id'],LOGIN_ID ));
                if($STH1&&$STH2){
                    $ok = true;
                    $code = 'Сохранено';
                }
            }
        }else{
            $code = 'Не верный email';
        }


        $flag = implode(',',$flag);
        if($flag){
            $code = implode(',<br/>',$arr_code);
        }


        $jsd['ok'] 			= $ok;
        $jsd['code'] 		= $code;
        $jsd['flag']			= $flag;
    }
// модальное окно Сменить пароль
    elseif($_GET['route'] == 'modal_change_pass'){

        $arr = $f->FormChangePass(array('flag'=>'profile'));

        $code = $t->getModal(	array('top'=>$arr['top'],'content'=>$arr['content'],'bottom'=>$arr['bottom']),
            array('id'=>'change-pass-form','class'=>'') );

        $jsd['code'] = $code;

    }
// действия над Заявка/Объявление
    elseif($_GET['route'] == 'action_buy_sell'){
        $ok = $STH = false;
        $code = 'Нельзя выполнить';

        $arr = $bs->UpdateStatusBuySell(array('buy_sell_id'=>$in['id'],'status'=>$in['status']));
        $code = ($arr['code'])? $arr['code'] : $code;

        // формируем и сохраняем html представление "строки" "Мои заявки/объявление"
        $tr = '';
        if($arr['ok']){
            $row_bs = $arr['row_bs'];
            $r = reqBuySell_ajax_form_buy_sell(array('id'=>$row_bs['id']));
            if(!empty($r)){// при отмене может запись быть удалена
                $bs->SaveCacheBuySell(array('buy_sell_id'=>$in['id'],'flag_buy_sell'=>$row_bs['flag_buy_sell']));
                $tr = $t->TrMyBuySellCache(array('buy_sell_id'=>$in['id'],'flag_buy_sell'=>$row_bs['flag_buy_sell']));
            }
        }

        $flag_reload = ($in['status']==13)? true : false;

        // запрос на сторонии ресурсы
        $ok = $qrq->InsertCronAmoBuySell(array('buy_sell_id'=>$in['id']));

        $jsd['code']			= $code;
        $jsd['ok'] 			= $arr['ok'];
        $jsd['tr'] 			= $tr;
        $jsd['flag_reload'] 	= $flag_reload;
    }


    elseif($_GET['route'] == 'skip_registration_company'){
    $STH = PreExecSQL(" UPDATE company SET skip=1 WHERE id=?; " ,
        array(COMPANY_ID));

    if($STH){
        $ok = true;
        $code = 'сохранено';
        $jsd['ok']  = $ok;
    }
}
// модальное окно Предложения на Заявки
    elseif($_GET['route'] == 'modal_offer_buy'){

        $row_bs = reqBuySell_TableOfferBuy(array('id' => $in['id']));

        if($row_bs['company_id']==COMPANY_ID){

            $arr = $t->TableOfferBuy(array('id'=>$in['id'],'row_bs'=>$row_bs));
            //vecho($arr['tid']);
            // удаляем оповещение(маркеры)
            if($arr['tid']){
                reqDeleteNotification(array('notification_id'=>2,'tid'=>$arr['tid']));
            }

            // фиксируем последнее посещение - предложений
            $cn->FixCompanyPageVisitedSend(array('page_id'=>2,'data_visited'=>'NOW()'));


            $code = $t->getModal(	array('class_dialog'=>'search-dialog needs-dialog offers-of-request','content'=>$arr['content']),
                array('id'=>'','class'=>'') );

            $jsd['code'] = $code;
        }
    }
// сохранить Заметки - Объявление/Предложение/Заявки
    elseif($_GET['route'] == 'save_note_buy_sell'){
        $ok = false;
        $code = 'Нельзя сохранить';


        if(!$in['id']){// СОЗДАНИЕ
            $STH = PreExecSQL(" INSERT INTO buy_sell_note (buy_sell_id, company_id, note) VALUES (?,?,?); " ,
                array( $in['buy_sell_id'],COMPANY_ID,$in['note'] ));
            if($STH){
                $id = $db->lastInsertId();
            }
        }else{// РЕДАКТИРОВАНИЕ
            $STH = PreExecSQL(" UPDATE buy_sell_note SET note=? WHERE id=? AND company_id=?; " ,
                array( $in['note'],$in['id'],COMPANY_ID ));
            if($STH){
                $id = $in['id'];
            }
        }


        if($STH){
            $ok 		= true;
            $code 	= 'Сохранено';
            $buy_sell_id = $db->lastInsertId();
            $code = $t->NoteBuySellOne(array('buy_sell_id'=>$in['buy_sell_id']));
        }

        $jsd['ok'] 	= $ok;
        $jsd['code']	= $code;
    }
// Купить Количество (возвращается после "Купить" на кого подписан)
    elseif($_GET['route'] == 'get_form_buy_amount'){

        $arr = $f->FormBuyAmount(array('buy_sell_id'=>$in['id'],'where'=>$in['where'],'amount'=>$in['amount']));

        $jsd['code'] 	= $arr['code'];
    }
// сохранить Купить - Предложение/Объявление
    elseif($_GET['route'] == 'save_buy_offer'){
        $ok = $flag_clear_parent = false;
        $error_qrq = $code_qrq = $code_qrq_222 = '';
        $code = 'Нельзя купить';
        $flag_json = true;// по умолчанию

        if(PRAVA_2||PRAVA_3){

            $row_bs = reqBuySell_SaveBuyOffer(array('id'=>$in['buy_sell_id']));


            // Покупаем у стороннего ресурса (если не получается купить ИМЕННО у стороннего ресурса то ничего не предпринимаем на нашем)
            $arr_qrq = $qrq->AmoOrderBuySell(array('row'=>$row_bs , 'amount'=>$in['amount'] , 'where'=>$in['where'] ));
            $error_qrq = $arr_qrq['error'];
            $code_qrq = $arr_qrq['code'];
            if($row_bs['qrq_id']>0){
                $flag_json	 = $arr_qrq['json'];
                if($flag_json==''){
                    $code = $code_qrq = 'QWEP вернул пустоту';
                }
            }

            //$code_qrq = '222';

            if($code_qrq){
                if($code_qrq=='111'){// "111" - означает, что форма не нужна и покупка произведена
                    $code_qrq = $error_qrq = '';
                }/*if($code_qrq=='222'){// "222" - означает, что только в корзине и надо уведомить пользователя (обработка ошибок ЭТП)
						$code_qrq_222 = $t->getModal(array('class_dialog'=>'search-dialog needs-dialog','content'=>'Здесь Обработчик'),
															array('id'=>'next_etp-form','class'=>'') );
						$ok = true;
					}*/else{
                    $ok = true;
                }
            }
            ///

            // в случае покупки объявления $row_bs['parent_id'] копию объявления нет!
            // а в случаем предложения , делаем копию заявки

            if(!empty($row_bs)&&empty($error_qrq)&&empty($code_qrq)&&$flag_json){

                $arr = $bs->SaveBuyOffer(array( 'row_bs'=>$row_bs , 'amount'=>$in['amount'] , 'buy_sell_id'=>$row_bs['id'] , 'where'=>$in['where'] ));

                $ok				= $arr['ok'];
                $code			= $arr['code'];
                $flag_clear_parent	= $arr['flag_clear_parent'];
                $parent_id		= $arr['parent_id'];
            }

        }

        $jsd['ok'] 					= $ok;
        $jsd['code']					= $code;
        $jsd['code_qrq']				= $code_qrq;
        $jsd['flag_clear_parent']	= $flag_clear_parent;
        $jsd['error_qrq'] 			= $error_qrq;
        //$jsd['code_qrq_222'] 		= $code_qrq_222;

    }
// сохранить Купить - Предложение/Объявление
    elseif($_GET['route'] == 'amo_basket'){

        $ok = $flag_clear_parent = $parent_id = $errors_message = $modal_errors_message = false;

        $code = 'Нельзя купить';

        $json = isset($_POST['json'])? $_POST['json'] : '';

        $json = json_decode($json);

        if(!$in['flag']){// обрабатываем ошибку

            // сохраняем параметры переданные с basket.php
            $STH = PreExecSQL(" DELETE FROM amo_accounts_basket_param WHERE accounts_id=? ; " ,
                array( $in['accounts_id'] ));
            $STH = PreExecSQL(" INSERT INTO amo_accounts_basket_param (accounts_id, param) VALUES (?,?); " ,
                array( $in['accounts_id'],$in['value'] ));
            ///

            // пишем лог
            $ins_id = reqInsertAmoLogJson(array('url'=>'ajax->amo_basket','parameters'=>'','json'=>$json,'token'=>'','accounts_id'=>$in['accounts_id']));


        }




        if($json){


            $Response	= $json->Response;

            $status = $Response->entity->status;

            if( $status || $in['flag'] ){//  $in['flag']==true , Пишем даже если ошибка (значит обрабатывалась через сервис ошибок и нажали оформить)

                $row_bs = reqBuySell_SaveBuyOffer(array('id'=>$in['buy_sell_id']));

                $arr = $bs->SaveBuyOffer(array( 'row_bs'=>$row_bs , 'amount'=>$in['amount'] , 'buy_sell_id'=>$row_bs['id'] , 'where'=>$in['where'] ));

                $ok				= $arr['ok'];
                $code			= $arr['code'];
                $flag_clear_parent	= $arr['flag_clear_parent'];
                $parent_id		= $arr['parent_id'];

            }else{

                // пишем ошибку и привязываем к общему json через parent_id
                reqInsertAmoLogJson(array('parent_id'=>$ins_id,'url'=>'ajax->amo_basket','parameters'=>'','json'=>$json,'token'=>'','accounts_id'=>$in['accounts_id']));


                $errors_message = $qrq->getErrorsMessageByJson(array('json'=>$json));

                // Проверяеи ошибку через сервис "ошибок Этп"

                $arr = $qrq->ProverkaErrorsMessageByAmoNameErrorEtp(array('errors_message'=> $errors_message,
                    'buy_sell_id'	=> $in['buy_sell_id'],
                    'amount'		=> $in['amount'],
                    'where'			=> $in['where'] ));

                if($arr['rez']){
                    $ok = true;
                    $modal_errors_message = $t->getModal(array('class_dialog'=>'search-dialog needs-dialog','content'=>$arr['code']),
                        array('id'=>'next_etp-form','class'=>'') );
                }else{
					$code = $errors_message;
				}
                ///


            }

        }

        $jsd['ok'] 					= $ok;
        $jsd['code']					= $code;
        $jsd['flag_clear_parent']	= $flag_clear_parent;
        $jsd['parent_id']			= $parent_id;
        $jsd['modal_errors_message']	= $modal_errors_message;

    }
// обновить кнопку у заявке
    elseif($_GET['route'] == 'button_buy_sell_html'){

        $button = $r['buy_sell_id'] = '';

        $r = reqBuySellRefreshAmoSearch(array('company_id'=>COMPANY_ID));

        if($r['buy_sell_id']){
            $m = reqMyBuySellCache(array('id'=>$r['buy_sell_id']));

            $button = $bs->ActionBuySell(array( 'row' => $m ));

            $STH = PreExecSQL(" DELETE FROM buy_sell_refresh_amo_search WHERE buy_sell_id=?; " ,
                array( $r['buy_sell_id'] ));

            $code = 'Обновились предложения';
        }


        $jsd['buy_sell_id'] 	= $r['buy_sell_id'];
        $jsd['code'] 		= $code;
        $jsd['button'] 		= $button;
    }
// модальное окно История изменений Заявки/Предложения
    elseif($_GET['route'] == 'modal_history_buy_sell'){

        $arr = $t->TableHistoryBuySell(array('id'=>$in['id']));

        $code = $t->getModal(	array('class_dialog'=>'history-buy-sell','top'=>$arr['top'],'content'=>$arr['content'],'bottom'=>$arr['bottom']),
            array('id'=>'','class'=>'') );

        $jsd['code'] = $code;
    }
// autocomplete Город - интересы
    elseif($_GET['route'] == 'autocomplete_interest_cities'){
        if(trim($in['value'])){
            $r	= reqCities(array('value' => $in['value'] , 'count_page'=>10));
            foreach($r as $i => $m){
                $jsd[] = array( 'id'=>$m['id'] , 	'text' 			=> $m['name'] );
            }
            $jsd = !empty($jsd)? array('results'=>$jsd) : array();
        }

    }
// Подписаться/Отписаться
    elseif($_GET['route'] == 'action_subscriptions'){

        $ok = $STH = $flag_modal_subscriptions_etp = false;
        $code = 'Нельзя выполнить';
        $button = $company_id = '';

        $r = reqSubscriptions(array('one'=>true,'company_id_in'=>COMPANY_ID,'company_id_out'=>$in['id']));
        $r_k = reqSubscriptions(array('kol'=>true,'company_id_in'=>COMPANY_ID));
        if(empty($r)){
            $flag = true;
            $ok = ( ($r_k['kol']<10) || PRO_MODE)? true : false;// не более 10 подписок
        }else{
            $flag = false;
        }

        if($flag){// СОЗДАНИЕ

            if($ok){
                $STH = PreExecSQL(" INSERT INTO subscriptions (company_id_in,company_id_out) VALUES (?,?); " ,
                    array( COMPANY_ID,$in['id'] ));
                if($STH){
                    // Оповещение
                    $cn->StartNotification(array(	'flag'				=> 'subscriptions',
                        'company_id'		=> $in['id'],
                        'tid'				=> COMPANY_ID,
                        'notification_id'	=> 13 ));
                }
            }else{
                $code = 'Лимит подписок исчерпан';
            }

        }else{// УДАЛЕНИЕ

            $STH = PreExecSQL(" DELETE FROM subscriptions WHERE company_id_in=? AND company_id_out=?; " ,
                array( COMPANY_ID,$in['id'] ));
            // удаляем  оповещение
            $STH = PreExecSQL(" DELETE FROM notification WHERE notification_id=13 AND company_id=? AND tid=?; " ,
                array( $in['id'] , COMPANY_ID ));
            $STH = PreExecSQL(" DELETE FROM notification_cron_send_1800 WHERE notification_id=13 AND company_id=? AND tid=?; " ,
                array( $in['id'] , COMPANY_ID ));
            ///

            // проверяем , если подключено ЭТП , то удаляем ...
            $cq = reqCompanyQrq(array('company_id'=>$in['id']));
			
            if( $cq['id'] ){

                $r = reqAmoAccountsEtp(array('company_id'=>COMPANY_ID,'company_id_qrq'=>$in['id']));

                if(!empty($r)){

                    $arr['rez'] = true;// по умолчанию

                    if($r['flag_autorize']==2){// если пользовать подключал сам ЭТП (со своим логин/пароль)

                        $arr = $qrq->AmoAccountsDelete(array('accounts_id'=>$r['accounts_id']));// удаляем Аккаунт на Amo

                    }


                    if($arr['rez']){
                        $code = 'Аккаунт удален';

                        $STH = PreExecSQL(" DELETE FROM amo_accounts_etp WHERE id=? AND company_id=?; " ,
                            array( $r['id'],COMPANY_ID ));
                        if($STH){
                            $ok		= true;
                        }

                    }else{
                        $code = 'ЭТП Аккаунт НЕ удален<br/><br/>'.$arr['errors_message'];
                    }
                }


            }


        }

        if($STH){
            $ok = true;
            $code = 'Сохранено';
            if( (!$in['where']) || ($in['where']=='company_profile') ){
                $button = $e->ButtonSubscriptions(array('flag'=>$flag,'company_id_out'=>$in['id'] ));
                $r_k = reqSubscriptions(array('kol'=>true,'company_id_in'=>COMPANY_ID));
            }
        }

        $jsd['ok'] 		= $ok;
        $jsd['code']		= $code;
        $jsd['button']	= $button;
        $jsd['count']	= $r_k['kol'];
        $jsd['flag_modal_subscriptions_etp']	= $flag_modal_subscriptions_etp;
        $jsd['company_id']					= $company_id;
    }
// autocomplete Компании
    elseif($_GET['route'] == 'autocomplete_fa'){
        $r	= reqCompanyAutocomplete(array('value' => $in['value']));
        foreach($r as $i => $m){
            if($m['flag_account']==1){//  Профиль аккаунта (физ.лицо)
                $company = $m['company'];
            }else{// Компания
                $company = $m['legal_entity'].' '.$m['company'];
            }
            $jsd[] = array( 'id'=>$m['id'] , 	'name' 			=> $company,
                'name2' 		=> $company,
                'id' 			=> $m['id'],
                'email' 		=> $m['email'],
                'value' 		=> $company );
        }
        if (empty($jsd)) $jsd[] = array(	'name' 	=> '<span class="text-muted">Создать поставщика</span>' ,
            'name2' =>'<button type="button" class="btn btn-warning modal_add_fa3" data-id="'.$in['id'].'" data-value="'.$in['value'].'" data-flag="'.$in['flag'].'"  data-flag_buy_sell="'.$in['flag_buy_sell'].'">Создать поставщика</button>' );
    }
// модальное окно - Создать несуществующего поставщика
    elseif($_GET['route'] == 'modal_add_fa3'){

        $arr = $f->FormAddFa3(array('value'=>$in['value']));

        $code = $f->getModal(	array('top'=>$arr['top'],'content'=>$arr['content'],'bottom'=>$arr['bottom']),
            array('id'=>'add_fa3-form','class'=>'') );

        $jsd['code'] = $code;
    }
// Сохранение - Создать несуществующего поставщика
    elseif($_GET['route'] == 'save_add_fa3'){

        $ok = $STH = $company_id = false;
        $code = 'Нельзя выполнить';
        $flag = array();


        //логин (email) занят
        if($in['email']){
            $validate_email = (filter_var($in['email'], FILTER_VALIDATE_EMAIL));
            if($validate_email){
                $r=reqLogin(array('email'=>$in['email']));
                if($r['id']){
                    $arr_code[] 	= 'Email занят';
                    $flag[] 		= 'email';
                }
            }else{
                $arr_code[] 	= 'Не верный email';
                $flag[] 		= 'email';
            }
        }
        // проверяем есть ли пользователь с таким телефоном
        if($in['phone']){
            $in['phone'] = preg_replace("/[^0-9]/", '', $in['phone']);
            $r=reqCompany(array('phone'=>$in['phone']));
            if(!empty($r)){
                $arr_code[] 	= 'Пользователь с таким номером телефона зарегистрирован';
                $flag[] 	= 'phone';
            }
        }

        if(empty($flag)){
            $r 	= reqCompany(array( 'id' => COMPANY_ID ));

            $STH = PreExecSQL(" INSERT INTO company (login_id,flag_account,legal_entity_id, company, email, iti_phone, phone, comments, cities_id, who1, who2) VALUES (?,?,?,?, ?,?,?,?,?,?,?); " ,
                array( LOGIN_ID,3,1,$in['company'],$in['email'],$in['value'],$in['phone'],$in['comments'],$r['cities_id'],1,0 ));


            if($STH){
                $ok = true;
                $code = 'Сохранено';
                $company_id = $db->lastInsertId();
            }

        }

        if(!empty($flag)){
            $flag = implode(',',$flag);
            if($flag){
                $code = implode(',<br/>',$arr_code);
            }
        }else{
            $flag = '';
        }

        $jsd['ok'] 			= $ok;
        $jsd['code']			= $code;
        $jsd['value']		= $in['company'];
        $jsd['company_id']	= $company_id;
        $jsd['flag']			= $flag;
    }
// сохранить Оповещение пользователя
    elseif($_GET['route'] == 'save_notification'){
        $ok = false;
        $code = 'Нельзя сохранить';

        $STH = PreExecSQL(" DELETE FROM notification_company_param WHERE login_id=? AND company_id=? AND flag=? AND notification_id=? ; " ,
            array( LOGIN_ID,COMPANY_ID,$in['flag'],$in['notification_id'] ));

        if($STH){
            $STH = PreExecSQL(" INSERT INTO notification_company_param (login_id,company_id,flag,notification_id,notification_param_id) VALUES (?,?,?,?,?); " ,
                array( LOGIN_ID,COMPANY_ID,$in['flag'],$in['notification_id'],$in['id'] ));

            if($STH){
                $ok 		= true;
                $code 	= 'Сохранено';
            }
        }

        $jsd['ok'] 	= $ok;
        $jsd['code']	= $code;
    }
// интересы - добавить условие
    elseif($_GET['route'] == 'add_interests'){

        $code = $t->TrInterestsCompanyParam(array('flag'=>$in['flag'],'login_id'=>$in['login_id']));

        $jsd['code']	= $code;
    }
// сохранение - интереса в профиле (select выпадающий список)
    elseif($_GET['route'] == 'save_interests_company_param'){

        $ok = $STH = false;
        $code = 'Нельзя сохранить';

        $flag = 1;// по умолчанию
        if($in['flag']==1){// компании
            $flag 	= 1;
            $login_id 	= LOGIN_ID;
            $sql_login_id = '';// в комании может удалять параметры любой администратор
        }elseif($in['flag']==2){// сотрудник
            $flag 	= 2;
            $login_id 	= $in['login_id'];
            $sql_login_id = " login_id=".$in['login_id']." AND ";// login_id - это сотрудник
        }

        if($in['value']=='insert'){// СОЗДАНИЕ
            // удаляем если ранее добавлена
            $STH = PreExecSQL(" DELETE FROM interests_company_param WHERE ".$sql_login_id." company_id=? AND interests_id=? AND interests_param_id=? AND flag=? AND tid=?; " ,
                array( COMPANY_ID,$in['interests_id'],$in['interests_param_id'],$flag,$in['id'] ));
            $STH = PreExecSQL(" INSERT INTO interests_company_param (login_id,company_id,interests_id,interests_param_id,flag,tid) VALUES (?,?,?, ?,?,?); " ,
                array( $login_id,COMPANY_ID,$in['interests_id'],$in['interests_param_id'],$flag,$in['id'] ));
            if($in['where']=='categories'){// добавляем id дочерних последних уровней
                $r = reqUpDownTree(array('table'=>'slov_categories','id'=>$in['id'],'updown'=>'down','flag'=>false,'vkl'=>false));
                if(!empty($r)){
                    $ids = implode(', ', array_map(function ($r) { return $r['ids']; }, $r));
                    $r = reqSlovCategories(array('ids'=>$ids , 'level'=>2));
					$ids = implode(', ', array_map(function ($r) { return $r['id']; }, $r));
					$r3 = reqSlovCategories(array('parent_id'=>$ids , 'level'=>3));
					foreach($r3 as $i3 => $m3){
						// удаляем если ранее добавлена
						$STH = PreExecSQL(" DELETE FROM interests_company_param WHERE ".$sql_login_id." company_id=? AND interests_id=? AND interests_param_id=? AND flag=? AND tid=?; " ,
							array( COMPANY_ID,$in['interests_id'],$in['interests_param_id'],$flag,$m3['id'] ));
						$STH = PreExecSQL(" INSERT INTO interests_company_param (login_id,company_id,interests_id,interests_param_id,flag,tid,views) VALUES (?,?,?, ?,?,?,?); " ,
							array( $login_id,COMPANY_ID,$in['interests_id'],$in['interests_param_id'],$flag,$m3['id'],2 ));
					
					}
                }
            }
        }elseif($in['value']=='delete'){// УДАЛЕНИЕ
            $STH = PreExecSQL(" DELETE FROM interests_company_param WHERE ".$sql_login_id." company_id=? AND interests_id=? AND interests_param_id=? AND flag=? AND tid=?; " ,
                array( COMPANY_ID,$in['interests_id'],$in['interests_param_id'],$flag,$in['id'] ));
            if($in['where']=='categories'){// удаляем id дочерних последних уровней
                $r = reqUpDownTree(array('table'=>'slov_categories','id'=>$in['id'],'updown'=>'down','flag'=>false,'vkl'=>false));
                if(!empty($r)){
                    $ids = implode(', ', array_map(function ($r) { return $r['ids']; }, $r));
                    $r = reqSlovCategories(array('ids'=>$ids , 'level'=>2));
					$ids = implode(', ', array_map(function ($r) { return $r['id']; }, $r));
					$r3 = reqSlovCategories(array('parent_id'=>$ids , 'level'=>3));
					foreach($r3 as $i3 => $m3){
						$STH = PreExecSQL(" DELETE FROM interests_company_param WHERE ".$sql_login_id." company_id=? AND interests_id=? AND interests_param_id=? AND flag=? AND tid=?; " ,
                            array( COMPANY_ID,$in['interests_id'],$in['interests_param_id'],$flag,$m3['id'] ));
					
					}
					/*
                    foreach($r as $i => $m){
                        $STH = PreExecSQL(" DELETE FROM interests_company_param WHERE ".$sql_login_id." company_id=? AND interests_id=? AND interests_param_id=? AND flag=? AND tid=?; " ,
                            array( COMPANY_ID,$in['interests_id'],$in['interests_param_id'],$flag,$m['id'] ));
                    }
					*/
                }
            }
        }

        if($STH){
            $ok = true;
            $code = 'Сохранено';
        }

        $jsd['ok'] 			= $ok;
        $jsd['code']			= $code;
    }
// модальное окно - Расчеты формы оплаты
    elseif($_GET['route'] == 'modal_company_form_payment'){

        $arr = $f->FormCompanyFormPayment(array('tax_system_id'=>$in['tax_system_id']));

        $code = $f->getModal(	array('class_dialog'=>'company-form-payment','top'=>$arr['top'],'content'=>$arr['content'],'bottom'=>$arr['bottom']),
            array('id'=>'company_form_payment-form','class'=>'') );

        $jsd['code'] = $code;
    }
// сохранение - Расчеты формы оплаты
    elseif($_GET['route'] == 'save_company_form_payment'){

        $ok = false;
        $code = 'Нельзя сохранить';

        $arr 		= isset($_POST['check'])&&!empty($_POST['check'])? $_POST['check'] : array();

        // очищаем раннее данные
        $STH = PreExecSQL(" DELETE FROM company_form_payment WHERE company_id=?; " ,
            array( COMPANY_ID ));

        foreach($arr as $i){
            $coefficient = $g->ReaplaceZap($_POST['coefficient'.$i.'']);

            $STH = PreExecSQL(" INSERT INTO company_form_payment (company_id,form_payment_id,coefficient) VALUES (?,?,?); " ,
                array( COMPANY_ID,$i,$coefficient ));
        }

        if($STH){
            $ok = true;
            $code = 'Сохранено';
        }


        $jsd['ok'] 			= $ok;
        $jsd['code']			= $code;
    }
// модальное окно - Поделиться
    elseif($_GET['route'] == 'modal_share_buy_sell'){

        $arr = $f->FormShareBuySell(array('company_id'=>$in['company_id'],'flag_buy_sell'=>$in['flag_buy_sell'],'value'=>$in['value']));

        $code = $t->getModal(	array('class_dialog'=>'share-buy-sell','content'=>$arr['content']),
            array('id'=>'','class'=>'') );

        $jsd['code'] = $code;
    }
// Поделиться отправка email/копия
    elseif($_GET['route'] == 'send_copy_share'){

        // проверяем соответствие компании и статусам (2,3) и формируем ссылку
        $arr = $g->getShareBuySellUrl(array(	'ids'			=> $in['value'],
            'flag'			=> $in['flag'],
            'flag_buy_sell'	=> $in['flag_buy_sell'],
            'company_id'	=> $in['company_id'],
            'email'			=> $in['email'],
            'name'			=> $in['name'],
            'comments'		=> $in['comments'] ));



        if(!$arr['error']&&$arr['url']){
            $code = $t->TextAfterClickSendCopyShare(array('flag' => $in['flag'])).'
				<br/>
				<input type="text" value="'.$arr['url'].'" id="myCopyText" style="height:0px;">';
            // отправка на email
            if($in['flag']==1){

                $rez = $tes->LetterSendShareBuySell(array(	'flag_buy_sell'	=> $in['flag_buy_sell'],
                    'company_id'	=> $in['company_id'],
                    'url' 			=> $arr['url'],
                    'email'			=> $in['email'],
                    'name'			=> $in['name'],
                    'comments'		=> $in['comments']));
            }
        }

        $jsd['code']		= $code;
        $jsd['url'] 		= $arr['url'];
        $jsd['error'] 	= $arr['error'];
    }
// модальное окно - Пригласить сотрудника
    elseif($_GET['route'] == 'modal_invite_workers'){

        $arr = $f->FormInviteWorkers(array('id'=>$in['id'],'flag'=>$in['flag']));

        $code = $t->getModal(	array('class_dialog'=>'invite-workers','content'=>$arr['content']),
            array('id'=>'invite_workers-form','class'=>'') );

        $jsd['code'] = $code;
    }
// сохранение - отправить Приглашение сотруднику
    elseif($_GET['route'] == 'save_invite_workers'){

        $ok = false;
        $code = $code_w = '';

        if(!$in['id']){// Создаем сотрудника

            $code_w = 'Нельзя отправить приглашение';

            // Проверяем сотрудника и приглашаем , добавляем
            $arr = $g->AddInviteWorkers(array(	'name'		=> $in['name'],
                'position'	=> $in['position'],
                'email'		=> $in['email'],
                'prava_id'	=> $in['prava_id'] ));

            $ok 		= $arr['ok'];
            $code 	= $code_w = $arr['code'];

            if($ok){
                $code_w = 'Сотрудник приглашен';
            }

        }else{// Редактирование
            $code_w = 'Нельзя сохранить';
            if(PRAVA_2){
                if($in['flag']==1){// зарегистрированный аккаунт
                    $STH = PreExecSQL(" UPDATE login_company_prava SET position=? , prava_id=? WHERE id=? AND company_id=?; " ,
                        array( $in['position'],$in['prava_id'],$in['id'],COMPANY_ID ));

                    if($STH){
                        $ok 		= true;
                        $code_w = 'Сохранено';
                    }
                }elseif($in['flag']==2){// не зарегистрированный аккаунт
                    $STH = PreExecSQL(" UPDATE invite_workers SET position=? , prava_id=? WHERE id=? AND company_id=?; " ,
                        array( $in['position'],$in['prava_id'],$in['id'],COMPANY_ID ));

                    if($STH){
                        $ok 		= true;
                        $code_w = 'Сохранено';
                    }
                }
            }

        }


        $jsd['ok'] 			= $ok;
        $jsd['code']			= $code;
        $jsd['code_w']		= $code_w;
    }
// удалить сотрудника
    elseif($_GET['route'] =