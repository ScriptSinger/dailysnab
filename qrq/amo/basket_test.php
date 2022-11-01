<?php
// https://questrequest.ru/qrq/amo/basket_test.php

$pToken = '46510b33482a8ecf2af6e3f989ecda8420b1abb9';

$postData = array(
'Request'=>array(
'RequestData'=>array(
'accountId'=>1671494
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


$response = file_get_contents('https://userapi.qwep.ru/basket', false, $context);
//$Resp = json_decode($response, JSON_UNESCAPED_UNICODE);
$Resp = json_decode($response,true);

var_dump($Resp); 

echo "<br>";
echo '++++++++++++++++++++++++++++++';

foreach ( $Resp  as $mass1 )
{
  foreach ( $mass1  as $mass2 )
  {
    foreach ( $mass2  as $mass3 )
    {
        
        echo '<pre>';
        print_r($mass3[0]['basketForm']);
        echo '</pre>';
        echo "<br>";

        
    }
  }
}





echo "<br>";
echo '++++++++++++++++++++++++++++++';
echo "<br>";
echo "<br>";
echo "<br>";


echo '<pre>';
print_r($Resp);
echo '</pre>';
echo "<br>";





?>


