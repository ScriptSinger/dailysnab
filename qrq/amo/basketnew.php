<?php

// https://questrequest.ru/qrq/amo/basket.php?token=5c30e99e8ca9dd0904c92855622d075435c86b62&accountid=1600536

$pParam = '';
$pToken = '';
$pAccountId = '';
$pAmount = '';
$pBuy_sell_id = '';
$pWhere = '';



/*
if (isset($_GET['pparam']))
{
    $pParam = $_GET['pparam'];
    $pParam = trim($pParam);
}
if (isset($_POST['pparam']))
{
    $pParam = $_POST['pparam'];
    $pParam = trim($pParam);
}
*/

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

/*Димы*/
if (isset($_GET['amount']))
{
    $pAmount = $_GET['amount'];
    $pAmount = trim($pAmount);
}
if (isset($_GET['buy_sell_id']))
{
    $pBuy_sell_id = $_GET['buy_sell_id'];
    $pBuy_sell_id = trim($pBuy_sell_id);
}
if (isset($_GET['where']))
{
    $pWhere = $_GET['where'];
    $pWhere = trim($pWhere);
}
if (isset($_POST['amount']))
{
    $pAmount = $_POST['amount'];
    $pAmount = trim($pAmount);
}
if (isset($_POST['buy_sell_id']))
{
    $pBuy_sell_id = $_POST['buy_sell_id'];
    $pBuy_sell_id = trim($pBuy_sell_id);
}
if (isset($_POST['where']))
{
    $pWhere = $_POST['where'];
    $pWhere = trim($pWhere);
}



$postData = array(
    'Request'=>array(
        'RequestData'=>array(
            'accountId'=>$pAccountId
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


$response = file_get_contents('https://userapi.qwep.ru/basket', false, $context);
//$Resp = json_decode($response, JSON_UNESCAPED_UNICODE);
$Resp = json_decode($response,true);



  echo "<pre>";
  print_r($Resp);
  echo "</pre>";

?>