<?php

// https://itel-app.ru/amo/authorization.php


// Тестовый код авторизации
$pauthorizationCode = 'A949620A6D6DBD76A5F4';



$postData = array(
    'Request' => array('RequestData' => array('authorizationCode' => $pauthorizationCode))
);


$context = stream_context_create(array(
    'http' => array(
        'method' => 'POST',
        'header' => "Content-Type: application/json\r\n",
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
echo $json;


?>