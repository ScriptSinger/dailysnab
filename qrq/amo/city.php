<?php

// https://questrequest.ru/qrq/amo/city.php?token=73b7d210f74223b6cf3f35f63b8da6ed63fd45c8

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


$response = file_get_contents('https://userapi.qwep.ru/geo/cities', FALSE, $context);
$Resp = json_decode($response,true);

/*
echo '<pre>';
print_r($Resp);
echo '</pre>';
echo "<br>";
*/

echo $response;


?>