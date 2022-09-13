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


$restaccount = file_get_contents('https://questrequest.ru/qrq/amo/accounts.php?token='.$pToken.'&accountid='.$pAccountId);
if (strlen(trim($restaccount))>0)
{
    $restvendor = file_get_contents('https://questrequest.ru/qrq/amo/vendorsget.php?token='.$pToken.'&vid='.$restaccount);
}
else
{
    $restvendor = '';
}

if ( (strlen(trim($restaccount))>0) && (strlen(trim($restvendor))>0))
{


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

}
else
{
    if ( strlen(trim($restaccount))==0 )
    {
        echo '111';
    }
    else
    {
        echo ('{"Response":[{"errors":["code":"222","message":"AccountId='.$pAccountId.' ушел только в корзину","details":null],"warnings":null}]}');
		
		//echo ('{"Coords":[{"Accuracy":"65","Latitude":"53.277720488429026","Longitude":"-9.012038778269686","Timestamp":"Fri Jul 05 2013 11:59:34 GMT+0100 (IST)"},{"Accuracy":"65","Latitude":"53.277720488429026","Longitude":"-9.012038778269686","Timestamp":"Fri Jul 05 2013 11:59:34 GMT+0100 (IST)"},{"Accuracy":"65","Latitude":"53.27770755361785","Longitude":"-9.011979642121824","Timestamp":"Fri Jul 05 2013 12:02:09 GMT+0100 (IST)"},{"Accuracy":"65","Latitude":"53.27769091555766","Longitude":"-9.012051410095722","Timestamp":"Fri Jul 05 2013 12:02:17 GMT+0100 (IST)"},{"Accuracy":"65","Latitude":"53.27769091555766","Longitude":"-9.012051410095722","Timestamp":"Fri Jul 05 2013 12:02:17 GMT+0100 (IST)"}]}');
		
		/*
		echo json_encode(array("Response"=>array("errors"=>array(	"code"=>"222",
																	"message"=>"AccountId=".$pAccountId." ушел только в корзину",
																	"details"=>""
																),
												"warnings"=>""
												)
								)
						);
		*/
    }
}


?>