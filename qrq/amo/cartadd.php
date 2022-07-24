<?php

// https://itel-app.ru/amo/cartadd.php?token=3e0c5b1d5b7e09b11512c60b69c118b2ef78813c&itemid=1724775822&quantity=1

$pToken = '';
$pItemId = '';
$pQuantity = '';

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

if (isset($_GET['itemid']))
{
    $pItemId = $_GET['itemid'];
    $pItemId = trim($pItemId);
}
if (isset($_POST['itemid']))
{
    $pItemId = $_POST['itemid'];
    $pItemId = trim($pItemId);
}

if (isset($_GET['quantity']))
{
    $pQuantity = $_GET['quantity'];
    $pQuantity = trim($pQuantity);
}
if (isset($_POST['quantity']))
{
    $pQuantity = $_POST['quantity'];
    $pQuantity = trim($pQuantity);
}


$text = $pToken.' = '.$pItemId.' = '.$pQuantity;
$filename = 'logs/'.$pItemId.'_cartadd1.txt';
$fh = fopen($filename, 'w');
fwrite($fh, $text);
fclose($fh);


$postData = array(
    'Request'=>array(
        'RequestData'=>array(
            'itemId'=>$pItemId,
            'quantity'=>$pQuantity,
            'comment'=>'pay'
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


$response = file_get_contents('https://userapi.qwep.ru/cart/add', FALSE, $context);
//$Resp = json_decode($response, JSON_UNESCAPED_UNICODE);

$filename = 'logs/'.$pItemId.'_cartadd3.txt';
$fh = fopen($filename, 'w');
fwrite($fh, json_encode($response, JSON_UNESCAPED_UNICODE));
fclose($fh);


echo $response;


?>