<?php

// https://itel-app.ru/amo/cartadd.php?token=3e0c5b1d5b7e09b11512c60b69c118b2ef78813c&itemid=1724775822&quantity=1

$pToken = '';
$pItemId = '';
$pQuantity = '';
$pAccountId = '';

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

if (isset($_GET['accountid']))
{
    $pAccountId = $_GET['accountid'];
    $pAccountId = trim($pAccountId);
}
if (isset($_POST['accountid']))
{
    $pAccountId = $_POST['accountid'];
    $pAccountId = trim($pAccountId);
}




    $postData = array(
        'Request' => array(
            'RequestData' => array(
                'itemId' => $pItemId,
                'quantity' => $pQuantity,
                'comment' => 'pay'
            )
        )
    );


    $context = stream_context_create(array(
        'http' => array(
            'method' => 'POST',
            'header' => "Authorization: Bearer {$pToken}\r\n" .
                "Content-Type: application/json\r\n",
            'content' => json_encode($postData)
        )
    ));


    $response = file_get_contents('https://userapi.qwep.ru/cart/add', FALSE, $context);
//$Resp = json_decode($response, JSON_UNESCAPED_UNICODE);

    echo $response;



?>
