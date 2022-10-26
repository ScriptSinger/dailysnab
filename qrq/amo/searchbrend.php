<?php

// https://itel-app.ru/amo/searchbrend.php?token=3e0c5b1d5b7e09b11512c60b69c118b2ef78813c&searchtext=105310


$pToken = '';
$pSearchText = '';


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


$postData = array(
    'Request'=>array(
        'RequestData'=>array(
            'article'=>$pSearchText,
            'useAltShortNumberBase' => 'true'
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


$response = file_get_contents('https://userapi.qwep.ru/preSearch', FALSE, $context);
//$Resp = json_decode($response, JSON_UNESCAPED_UNICODE);

echo $response;


?>