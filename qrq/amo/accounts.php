<?php

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
           "excludePromo"=>false,
           "excludeDisabled"=>false
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


$response = file_get_contents('https://userapi.qwep.ru/accounts/get', FALSE, $context);
$Resp = json_decode($response);

$fuck = '';
$items = $Resp->Response->entity->accounts;
if (is_array($items))
{
    foreach ($items as $item)
    {
        $pid = $item->id;
        $pvid = $item->vid;
        
       // echo $pAccountId.' = '.$pid.' = '.$pvid;
       // echo '<br>';
        
        if ($pAccountId==$pid)
        {
            if ( ($pvid=='df837bc1-599b-46f7-83b5-3a764ce850e0') or
                 ($pvid=='977ff8fc-6ecc-403a-b6b9-e39abdadfa45') or
                 ($pvid=='0dd3d1c5-acf3-4805-ac14-5e9ab9ed2a46') or
                 ($pvid=='4fe3e4b-fc4f-4727-99d7-75e07ec0cc96') 

                // Armtek API
                or ($pvid=='2a9a260a-474c-4ff9-a304-f99f38319319')
            )
            {
                $fuck = '';
            }
            else
            {
                $fuck = $pvid;
            }
        }

    }

}

echo $fuck;



?>