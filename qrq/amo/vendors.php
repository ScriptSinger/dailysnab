<?php

// https://itel-app.ru/amo/vendors.php?token=ddcd9a86c3cecc1c01c9335a46ac544b35ca58f1


$pToken = '';

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


$postData = array(
    "Request"=>array(
        "RequestData"=>array(
            "filters"=>array(
                "vendors"=>[],
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

$items = $Resp->Response->entity->vendors;


if (is_array($items))
{
    foreach ($items as $item)
    {
        $Info = array(
            "id" => $item->id,
            "title" => $item->title,
            "branches" => $item->branches,
            "checkout " => $item->checkout
        );
        $InfoArray[] = $Info;
    }

}

$json = json_encode($InfoArray, JSON_UNESCAPED_UNICODE);
echo $json;


?>