<?php

// https://questrequest.ru/qrq/amo/accountsget.php?token=3925f0954a22d5ee6ce68bb1cde6ee66ba369a96

$pToken = '';

if (isset($_GET['token']))
{
    $pToken = $_GET['token'];
    $pToken = trim($pToken);
}
if (isset($_POST['token']))
{
    $pToken = $_POST['token'];
    $pToken = trim($pToken);
}




$postData = array(
    "Request"=>array(
        "RequestData"=>array(
            "excludePromo"=>false,
            "excludeDisabled"=>false
        )
    )
);

$context = stream_context_create(array(
    'http' => array(
        'method' => 'POST',
        'header' => "Authorization: Bearer {$pToken}\r\n".
            "Content-Type: application/json\r\n",
        'content' => json_encode($postData)
    )
));


$response = file_get_contents('https://userapi.qwep.ru/accounts/get', FALSE, $context);
$Resp = json_decode($response,true);


    echo '<pre>';
    print_r($Resp);
    echo '</pre>';
    echo "<br>";



?>