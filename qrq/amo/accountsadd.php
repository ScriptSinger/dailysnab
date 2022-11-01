<?php


// https://itel-app.ru/amo/accountsadd.php?token=fceabdcf12df12b4eb78386bf73b518f66466f30&vendorid=8004facc-8701-4d44-88b2-e56084b8ab3c&login=656881&password=123456

// snabdaily@gmail.com
// Ar299792458

$pToken = '';
$pVendorId = '';
$pLogin = '';
$pPassword = '';

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

if (isset($_GET['vendorid']))
{
    $pVendorId = $_GET['vendorid'];
    $pVendorId = trim($pVendorId);
}
if (isset($_POST['vendorid']))
{
    $pVendorId = $_POST['vendorid'];
    $pVendorId = trim($pVendorId);
}

if (isset($_GET['filialid']))
{
    $pFilialId = $_GET['filialid'];
    $pFilialId = trim($pFilialId);
}
if (isset($_POST['filialid']))
{
    $pFilialId = $_POST['filialid'];
    $pFilialId = trim($pFilialId);
}

if (isset($_GET['login']))
{
    $pLogin = $_GET['login'];
    $pLogin = trim($pLogin);
}
if (isset($_POST['login']))
{
    $pLogin = $_POST['login'];
    $pLogin = trim($pLogin);
}

if (isset($_GET['password']))
{
    $pPassword = $_GET['password'];
    $pPassword = trim($pPassword);
}
if (isset($_POST['password']))
{
    $pPassword = $_POST['password'];
    $pPassword = trim($pPassword);
}



$postData = array(
    'Request'=>array(
        'RequestData'=>array(
            'accounts'=>[
                array(
                'vid'=>$pVendorId,
                'bid'=>$pFilialId,
                'login'=>$pLogin,
				'password'=>$pPassword,
                'title'=>'',
				'check'=>'true',
				'parameters'=>''
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



$response = file_get_contents('https://userapi.qwep.ru/accounts/add', FALSE, $context);
//$Resp = json_decode($response);

echo $response;


?>

