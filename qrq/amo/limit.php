<?php

// https://itel-app.ru/amo/limit.php


// Тестовый код авторизации
$pauthorizationCode = 'A949620A6D6DBD76A5F4';



$postData = array(
    'Request' => array('RequestData' => array('authorizationCode' => $pauthorizationCode))
);


$context = stream_context_create(array(
    'http' => array(
        'method' => 'POST',
        "Content-Type: application/json\r\n",
        'content' => json_encode($postData)
    )
));


$response = file_get_contents('https://userapi.qwep.ru/authorization', FALSE, $context);
$Resp = json_decode($response);
$pToken = $Resp->Response->entity->token;

$Info = array(
    "token" => $pToken
);

$json = json_encode($Info, JSON_UNESCAPED_UNICODE);
//echo $json;





// http://userapi.qwep.ru/applicationInfo

$postData = array(
    'Request' => array('RequestData' => array())
);
$context = stream_context_create(array(
    'http' => array(
        'method' => 'POST',
        'header' => "Authorization: Bearer {$pToken}\r\n".
            "Content-Type: application/json\r\n",
        'content' => json_encode($postData)
    )
));
$response = file_get_contents('https://userapi.qwep.ru/applicationInfo', FALSE, $context);
//$Resp = json_decode($response);
$Resp = json_decode($response, true);

$wer1 = $Resp['Response']['entity'];
$wer2 = $Resp['Response']['entity']['package'];
$ostatok = $Resp['Response']['entity']['packageStatus']['requestLimit'];
$date_begin = $Resp['Response']['entity']['packageStatus']['periodEnd'];
$date_end = $Resp['Response']['entity']['packageStatus']['paidTill'];
$alllimit = $Resp['Response']['entity']['package']['requestLimit'];


echo "<br>";
echo "Веделено лимита: ".$alllimit;
echo "<br>";
echo "Остаток лимита: <b>".$ostatok.'</b>';
echo "<br>";
echo "Дата начала: ".$date_begin;
echo "<br>";
echo "Дата окончания: ".$date_end;
echo "<br>";


//print_r($wer2);




?>