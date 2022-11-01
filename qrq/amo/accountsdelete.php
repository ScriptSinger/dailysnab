<?php


// https://itel-app.ru/amo/accountsadd.php?token=fceabdcf12df12b4eb78386bf73b518f66466f30&vendorid=8004facc-8701-4d44-88b2-e56084b8ab3c&login=656881&password=123456
// http://dailysnab.beget.tech/qrq/amo/accountsadd.php


$pToken = '';
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
    "Request"=>array(
        "RequestData"=>array(
            "accounts"=>[
                array(
                    "id"=>$pAccountId
                )
            ]
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



$response = file_get_contents('https://userapi.qwep.ru/accounts/delete', FALSE, $context);
$Resp = json_decode($response);

echo $response;


?>

