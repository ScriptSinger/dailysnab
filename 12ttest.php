<?php

// https://itel-app.ru/amo/basket.php?token=bb53bcac8486be2c36dde75ec9d9a7e354643d12&accountid=1534115

$pToken = '4dac722fdd4c0e81753679b4ce47a28e78905e2e';
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
    'Request'=>array(
        'RequestData'=>array(
            'accountId'=>$pAccountId
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



/*

$url   = 'https://userapi.qwep.ru/basket';
$fp    = fopen($url, 'r', false, $context);
$meta  = stream_get_meta_data($fp);
if (!$fp) {
    echo "Failed!";
} else {
    echo "Success";
    $response = stream_get_contents($fp);
}
fclose($fp);

echo "000";
print_r($response);
echo "111";

*/



$response = file_get_contents('https://userapi.qwep.ru/basket', false, $context);


$Resp = json_decode($response);
$Resp = json_decode($response);
print_r($response);
//$Resp = json_decode($response, JSON_UNESCAPED_UNICODE);
//$Resp = json_encode($response);

/*

$time_limit = ini_get('max_execution_time');
$memory_limit = ini_get('memory_limit');
set_time_limit(0);
ini_set('memory_limit', '-1');   
$remote_contents=file_get_contents('https://userapi.qwep.ru/basket', TRUE, $context);
//esponse=file_put_contents($local_path, $remote_contents);
set_time_limit($time_limit);
ini_set('memory_limit', $memory_limit); 
    
echo "<br>";
echo "memory_limit = ".$memory_limit;
echo "<br>";
echo "time_limit = ".$time_limit;
echo "<br>";
echo "<br>";

echo "1111";
echo "<br>";
print_r($response);
echo "<br>";
echo "2222";
echo "<br>";
*/


/*


$error = $Resp['Response']['errors'];
$warnings = $Resp['Response']['warnings'];
$entity = $Resp['Response']['entity']['baskets']['0']['basketForm'];
$pFormId = $entity['formId'];
$pFormArray = $entity['fields'];


if ( ($error==null) and ($warnings==null) )
{
    echo '<select id="vSelect_0">';
    echo '  <option value="token,'.$pToken.'">'.$pToken.'</option>';
    echo '</select>';
    echo "<script>";
    echo "  document.getElementById('vSelect_0').style.display='none'; ";
    echo "</script>";
}
*/

?>

<div id="basket_body"></div>
