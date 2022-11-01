<?php


$pToken = '';
$pAccountId = '';
$pFormId = '';

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

if (isset($_GET['formid']))
{
    $pFormId = $_GET['formid'];
    $pFormId = trim($pFormId);
}
if (isset($_POST['formid']))
{
    $pFormId = $_POST['formid'];
    $pFormId = trim($pFormId);
}




/*
{
    "Request": {
    "RequestData": {
        "accountId": "1531261",
      	"formId": 165904,
      	"fieldValues": [
        {
            "fieldName": "defaultName",
          "value": ""
        }
      ]
     }
  }
}
*/


$postData = array(
    'Request'=>array(
        'RequestData'=>array(
            'accountId'=>$pAccountId,
            'formId'=>$pFormId,
            'fieldValues'=>array(
                'fieldName'=>'defaultName',
                'value'=>''
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


$response = file_get_contents('https://userapi.qwep.ru/basket/order', FALSE, $context);
//$Resp = json_decode($response, JSON_UNESCAPED_UNICODE);

echo $response;




?>