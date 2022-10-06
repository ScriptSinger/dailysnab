<?php


// https://questrequest.ru/qrq/amo/searchupdate.php?token=3e0c5b1d5b7e09b11512c60b69c118b2ef78813c&searchid=105310

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

if (isset($_GET['searchid']))
{
    $pSearchId = $_GET['searchid'];
    $pSearchId = trim($pSearchId);
}
if (isset($_POST['searchid']))
{
    $pSearchId = $_POST['searchid'];
    $pSearchId = trim($pSearchId);
}



    $Num = array();
    $Num = array('type'=>'items', 'sort'=>'price', 'order'=>'asc');
    $InfoArray[] = $Num;


$postData = array(
    'Request'=>array(
        'RequestData'=>array(
            'searchId'=>$pSearchId,
			'sorts'=>$InfoArray
			)
        )
);

/*
    echo '<pre>';
    print_r($postData);
    echo '</pre>';
    echo "<br>";
*/






$context = stream_context_create(array(
    'http' => array(
        'method' => 'POST',
        'header' => "Authorization: Bearer {$pToken}\r\n".
            "Content-Type: application/json\r\n",
        'content' => json_encode($postData)
    )
));


$response = file_get_contents('https://userapi.qwep.ru/search/updates', FALSE, $context);
echo $response;

    echo "111";
    echo "<br>";

$Resp = json_decode($response,true);

    echo '<pre>';
    print_r($Resp);
    echo '</pre>';
    echo "<br>";
    
    echo "222";
    echo "<br>";


?>