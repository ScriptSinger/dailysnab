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
        //$row['id'] = 563;
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

    $code = $t->getModal(	array('class_dialog'=>'register-dialog', 'class_con