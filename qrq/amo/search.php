<?php


// https://questrequest.ru/qrq/amo/search.php?token=3e0c5b1d5b7e09b11512c60b69c118b2ef78813c&searchtext=105310&brand=Lema&accountid=1531261,1531268

$pToken = '';
$pSearchText = '';
$pAccountId = '';
$pBrand = '';

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

if (isset($_GET['brand']))
{
    $pBrand = $_GET['brand'];
    $pBrand = trim($pBrand);
}
if (isset($_POST['brand']))
{
    $pBrand = $_POST['brand'];
    $pBrand = trim($pBrand);
}

if (isset($_GET['searchtext']))
{
    $pSearchText = $_GET['searchtext'];
    $pSearchText = trim($pSearchText);
}
if (isset($_POST['searchtext']))
{
    $pSearchText = $_POST['searchtext'];
    $pSearchText = trim($pSearchText);
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




$pieces = explode(",", $pAccountId);

$Num = array();
foreach ($pieces as $value) {
    $Num = array("id" => $value);
    $InfoArray[] = $Num;
}



/*
$pAccountId = [
    array(
        'Id'=>'1531261'
    ),
    array(
        'Id'=>'1531268'
    )
];
*/



$postData = array(
    'Request'=>array(
        'RequestData'=>array(
            'article'=>$pSearchText,
            'brand'=>$pBrand,
            'timeout'=>'60000',
            'openAllClarifications'=>'true',
            'excludePromo'=>'false',
            'type'=>'1',
            'accounts'=>$InfoArray
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


$response = file_get_contents('https://userapi.qwep.ru/search', FALSE, $context);
echo $response;

?>