<?php

// https://questrequest.ru/qrq/amo/vendorsget.php?token=73b7d210f74223b6cf3f35f63b8da6ed63fd45c8&vid=74fe3e4b-fc4f-4727-99d7-75e07ec0cc96


$pToken = '';
$pVid = '';

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

if (isset($_GET['vid']))
{
    $pVid = $_GET['vid'];
    $pVid = trim($pVid);
}
if (isset($_POST['vid']))
{
    $pVid = $_POST['vid'];
    $pVid = trim($pVid);
}


$postData = array(
    "Request"=>array(
        "RequestData"=>array(
            "filters"=>array(
                "vendors"=>
                    [
                    array('id'=>$pVid)
                    ],
                "branches"=>[]
            )
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


$response = file_get_contents('https://userapi.qwep.ru/vendors', FALSE, $context);
$Resp = json_decode($response);

if(!empty($Resp->Response->entity->vendors[0]->checkout))
    $items = $Resp->Response->entity->vendors[0]->checkout;

if (strlen($items)==0)
{
    echo '';
}
else
{
    echo 'no';
}



?>